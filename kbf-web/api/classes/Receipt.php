<?php
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class Receipt extends DatabaseConnector {
        var $type;
        var $receipt;
        var $id; //for fee id is PNR or CARDNR
        var $email;
        var $url;
        var $date;
        var $created_date;
        var $total;
        var $responsible;
        var $items;
        var $receiver;

        function __construct($receipt, $id, $type, $email) {		
            parent::__construct();
            $this->receipt =  parent::cleanField($receipt);
            $this->id = parent::cleanField($id);
            $this->email = parent::cleanField($email);
            $this->type = parent::cleanField($type);
            $this->items = array();
            $this->total = 0;
            $this->url = "http://karlskronabergsport.se/api/public/receipt?id=$this->id&type=$this->type&receipt=$this->receipt";
            $this->receiver = "";
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
            $this->populateCreatedDate();
            if ($this->type == "open") {
                $this->populateFieldsOpen();
            } else if($this->type == "fee") {
                $this->populateFieldsFee();
            }

        }

        function populateCreatedDate() {
            $sql = "SELECT `date` FROM receipt WHERE id='$this->receipt'";
            $result = parent::getMysql()->query($sql);
            if($result && $result->num_rows == 1) {
                $row = $result->fetch_row();
                $this->created_date = new DateTime($row[0]);
            } else {
                $insert_sql = "INSERT INTO receipt (id) VALUES ('$this->receipt')";
                $insert_result = parent::getMysql()->real_query($insert_sql);
                $this->created_date = new DateTime();
            }
            $this->created_date = $this->created_date->format('Y-m-d');
            if($result) {
                $result->close();
            }
        }

        function populateFieldsFee() {
            $sql = "SELECT p.name, cf.paymentDate, i.price, i.name, receiver.name FROM climbing_fee AS cf                    
                        INNER JOIN item AS i ON i.paymentDate = cf.paymentDate AND i.pnr = cf.pnr               
                        INNER JOIN person AS p ON p.pnr =  cf.signed
                        INNER JOIN person AS receiver ON receiver.pnr = cf.pnr                                            
                    WHERE cf.receipt = '$this->receipt' AND i.name IN (select name FROM prices WHERE `table` = 'climbing_fee')
                                                                                                            
                    UNION                                                                                     
                                                                                                            
                    SELECT p.name, m.paymentDate, i.price, i.name, receiver.name FROM membership AS m                        
                        INNER JOIN item AS i ON i.paymentDate = m.paymentDate AND i.pnr = m.pnr                 
                        INNER JOIN person AS p ON p.pnr =  m.signed
                        INNER JOIN person AS receiver ON receiver.pnr = m.pnr                                        
                    WHERE m.receipt = '$this->receipt' AND i.name IN (SELECT name FROM prices WHERE `table` = 'membership')";

            $result = parent::getMysql()->query($sql);
            if($result && $result->num_rows > 0) {
                $row = $result->fetch_row();
                $this->responsible  = parent::getStringcolumn($row, 0);
                $this->date  = $row[1];
                $this->items[] = new Item(parent::getStringcolumn($row, 3), $row[2]);
                $this->total = $row[2];
                $this->receiver = parent::getStringcolumn($row, 4);
                $result->close();
            } else {
                if($result) {
                    $result->close();
                }
                
                $sql = "SELECT p.name, i.paymentDate, i.name, i.price 
                            FROM ten_card AS c
                            INNER JOIN item AS i ON i.name LIKE '%$this->id%'
                            INNER JOIN person AS p ON p.pnr =  c.signed
                        WHERE c.receipt = '$this->receipt'";
                $result = parent::getMysql()->query($sql);
                if($result && $result->num_rows > 0) {
                    $row = $result->fetch_row();
                    $this->responsible  = parent::getStringcolumn($row, 0);
                    $this->date  = $row[1];
                    $this->items[] = new Item(parent::getStringcolumn($row, 2), $row[3]);
                    $this->total = $row[3];
                    $this->receiver = $this->email;
                }
                if($result) {
                    $result->close();
                }
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
            $receiverHtml = "";
            if($this->receiver != "") {
                $receiverHtml = "
                <tr>
                    <td colspan=\"6\">
                        <h4>
                        Kvitto till: $this->receiver
                        </h4>
                    </td>
                </tr>";
            }
            
            return "
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"500\" id=\"bodyTable\">
            <tr>
              <td><img src=\"https://www.karlskronabergsport.se/img/logo.png\" width=\"34\" /></td>
              <td colspan=\"5\">
                <h3>Karlskrona Bergsportsf&ouml;rening</h3>
              </td>
            </tr>
            $receiverHtml
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
                <td colspan=\"6\">Kvitto skapat: $this->created_date</td>
            </tr>
            <tr>
                <td colspan=\"6\">Org nr: 835000-9893</td>
            </tr>
            <tr>
                <td colspan=\"6\">Adress: Gr&auml;svikshallen, 371 41 Karlskrona</td>
            </tr>
            <tr height=\"60\"></tr>
            <tr>
                <td colspan=\"6\">
                    <a href=\"$this->url\">Ser mailet konstigt ut? Klicka h&auml;r f&ouml;r att &ouml;ppna det i din webbl&auml;sare</a>
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