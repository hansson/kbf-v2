<?php
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class Person extends DatabaseConnector {
        var $pnr;
        var $name;
        var $address;
        var $email;
        var $payments;

        function __construct($pnr) {		
            parent::__construct();
			$this->pnr = parent::cleanField($pnr);
            $this->payments = array();
            $this->populateFields();
		}

        function getName() {
            return $this->name;
        }

        function getAddress() {
            return $this->address;
        }

        function getEmail() {
            return $this->email;
        }

        function getPayments() {
            return $this->payments;
        }

        function populateFields() {
            //hämta rätt fält
            $sql = "SELECT name, email, address FROM person WHERE pnr = '$this->pnr'";
            $result = parent::getMysql()->query($sql);
            while($row = $result->fetch_row()) {
                $this->name = parent::getStringcolumn($row, 0);
                $this->email = parent::getStringcolumn($row, 1);
                $this->address = parent::getStringcolumn($row, 2);
            }
            $result->close();

            //Populate payments
            $sql = "SELECT i.name, cf.paymentDate, cf.receipt
	                    FROM climbing_fee AS cf
	                    INNER JOIN item AS i on i.paymentDate = cf.paymentDate
	                    INNER JOIN prices AS p ON p.name = i.name
                    WHERE cf.pnr = '$this->pnr' AND p.`table` = 'climbing_fee' AND (i.pnr IS NULL OR i.pnr = '$this->pnr') ORDER BY cf.paymentDate DESC";
            $this->populatePaymentsFromSql($sql);

            $sql = "SELECT i.name, m.paymentDate, m.receipt
	                    FROM membership AS m
	                    INNER JOIN item AS i on i.paymentDate = m.paymentDate
	                    INNER JOIN prices AS p ON p.name = i.name
                    WHERE m.pnr = '$this->pnr' AND p.`table` = 'membership' AND (i.pnr IS NULL OR i.pnr = '$this->pnr') ORDER BY m.paymentDate DESC";
            $this->populatePaymentsFromSql($sql);

            //$sql = "SELECT card FROM ten_card WHERE pnr = '$this->pnr' ORDER BY id DESC";
            
        }

        function populatePaymentsFromSql($sql) {
            $result = parent::getMysql()->query($sql);
            while($row = $result->fetch_row()) {
                $this->payments[] = new Payment(parent::getStringcolumn($row, 0), parent::getStringcolumn($row, 1), parent::getStringcolumn($row, 2));
            }
            $result->close();
        }

        function print() {
            $payments = "";
            foreach ($this->payments as $payment) {
                $payments .= $payment->print() . ",";
            }
            $payments = endJsonList($payments, 0);
            return "{
                \"pnr\":\"$this->pnr\",
                \"name\":\"$this->name\",
                \"email\":\"$this->email\",
                \"payments\": [ $payments ]
            }";
        }
    }

    class Payment {
        var $name;
        var $paymentDate;
        var $receipt;

        function __construct($name, $paymentDate, $receipt) {		
            $this->name = $name;
            $this->paymentDate = $paymentDate;
            $this->receipt = $receipt;
        }

        function print() {
            return "{
                \"name\":\"$this->name\",
                \"paymentDate\":\"$this->paymentDate\",
                \"receipt\":\"$this->receipt\"
            }";
        }
    }


?>