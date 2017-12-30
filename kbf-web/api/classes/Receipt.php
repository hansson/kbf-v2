<?php
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class Receipt extends DatabaseConnector {
        var $type;
        var $receipt;
        var $id;
        var $email;
        var $url;
        var $date;
        var $total;
        var $responsible;
        var $items;

        function __construct($receipt, $id, $type, $email) {		
            parent::__construct();
            $this->receipt =  parent::cleanField($receipt);
            $this->id = parent::cleanField($id);
            $this->email = parent::cleanField($email);
            $this->type = parent::cleanField($type);
            $this->items = array();
            $this->total = 0;
            $this->url = "http://karlskronabergsport.se/api/public/receipt?id=$this->id&type=$this->type&receipt=$this->receipt";
            $this->populateFields();		
		}

        function getUrl() {
            return $this->url;
        }

        function getEmail() {
            return $this->email;
        }

        function getDate() {
            return $this->date;
        }

        function getTotal() {
            return $this->total;
        }

        function getResponsible() {
            return $this->responsible;
        }

        function getItems() {
            return $this->items;
        }

        function populateFields() {
            if ($this->type == "open") {
                $this->populateFieldsOpen();
            } else if($this->type == "fee") {
                $this->populateFieldsFee();
            }

        }

        function populateFieldsFee() {
            $sql = "SELECT p.name, cf.paymentDate, i.price, i.name FROM climbing_fee AS cf                    
                        INNER JOIN item AS i ON i.paymentDate = cf.paymentDate OR i.pnr = cf.pnr               
                        INNER JOIN person AS p on p.pnr =  cf.signed                                           
                    WHERE cf.receipt = '$this->receipt' AND i.name IN (select name FROM prices WHERE `table` = 'climbing_fee')
                                                                                                            
                    UNION                                                                                     
                                                                                                            
                    SELECT p.name, m.paymentDate, i.price, i.name FROM membership AS m                        
                        INNER JOIN item AS i ON i.paymentDate = m.paymentDate OR i.pnr = m.pnr                 
                        INNER JOIN person AS p on p.pnr =  m.signed                                            
                    WHERE m.receipt = '$this->receipt' AND i.name IN (SELECT name FROM prices WHERE `table` = 'membership')";

            $result = parent::getMysql()->query($sql);
            if($result && $result->num_rows > 0) {
                $row = $result->fetch_row();
                $this->responsible  = parent::getStringcolumn($row, 0);
                $this->date  = $row[1];
                $this->items[] = new Item(parent::getStringcolumn($row, 3), $row[2]);
                $this->total = $row[2];
                $result->close();
            } else {
                if($result) {
                    $result->close();
                }
                //TODO Check for 10-card
            }
        }

        function populateFieldsOpen() {
            $sql = "SELECT oi.name, oi.price, p.name, o.date FROM open_person AS op
                INNER JOIN open_item AS oi ON oi.open_person = op.id
                INNER JOIN open AS o on o.id = op.open_id
                INNER JOIN person AS p on p.pnr =  o.responsible
            WHERE op.id = $this->id 
            AND op.receipt = '$this->receipt'
            AND op.receipt != '0'";
            $result = parent::getMysql()->query($sql);
            while($result && $row = $result->fetch_row()) {
                $this->responsible  = parent::getStringcolumn($row, 2);
                $this->date  = $row[3];
                $this->items[] = new Item(parent::getStringcolumn($row, 0), $row[1]);
                $this->total += $row[1];
            }
            if($result) {
                $result->close();
            }
        }

        function print() {
            $items = "";
            foreach ($this->items as $item) {
                $items .= $item->print();
            }
            return "
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"500\" id=\"bodyTable\">
            <tr>
              <td><img src=\"https://www.karlskronabergsport.se/img/logo.png\" width=\"34\" /></td>
              <td colspan=\"5\">
                <h3>Karlskrona Bergsportsf&ouml;rening</h3>
              </td>
            </tr>
            <tr>
              <td colspan=\"6\">
                <h4>
                  Kvitto f&ouml;r ditt k&ouml;p $this->date
                </h4>
              </td>
            </tr>
            <tr>
              <td align=\"left\" valign=\"top\" colspan=\"6\">
          
                <table border=\"0\" cellpadding=\"10\" cellspacing=\"0\" id=\"emailContainer\" align=\"left\">
                  <tr>
                    <th align=\"left\" style=\"border-bottom: 1px solid #000\">Produkt</th>
                    <th align=\"left\" style=\"border-bottom: 1px solid #000\">Pris</th>
                  </tr>
                  $items
                </table>
              </td>
            </tr>
            <tr height=\"30\"></tr>
            <tr>
              <td colspan=\"6\"><b>Totalt: $this->total kr</b></td>
            </tr>
            <tr>
              <td colspan=\"6\"><b>Varav moms: 0 kr</b></td>
            </tr>
            <tr height=\"10\"></tr>
            <tr>
              <td colspan=\"6\">S&aring;lt av: $this->responsible</td>
            </tr>
            <tr>
                <td colspan=\"6\">Org. nummer: 835000-9893</td>
            </tr>
            <tr height=\"60\"></tr>
            <tr>
                <td colspan=\"6\">
                    <a href=\"$this->url\">Ser mailet konstigt ut? Klicka h&auml;r f&ouml;r att &ouml;ppna det i din webl&auml;sare</a>
                </td>
            </tr>
            </table>
            ";
        }
    }
    
    class Item {
        var $name;
        var $price;

        function __construct($name, $price) {		
            $this->name = $name;
            $this->price = $price;
        }

        function print() {
            return "
            <tr>
                <td align=\"left\" valign=\"top\" style=\"border-bottom: 1px solid #ccc\">
                    $this->name
                </td>
                <td align=\"left\" valign=\"top\" style=\"border-bottom: 1px solid #ccc\">
                    $this->price
                </td>
            </tr>";
        }
    }

?>