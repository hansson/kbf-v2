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
            $sql = "SELECT paymentDate, type FROM climbing_fee WHERE pnr = '$this->pnr' ORDER BY paymentDate DESC";
            $sql = "SELECT paymentDate, type, registered FROM membership WHERE pnr = '$this->pnr' ORDER BY paymentDate DESC";
            $sql = "SELECT card FROM ten_card WHERE pnr = '$this->pnr' ORDER BY id DESC";
            
            $result = $mysqli->query($sql);
            $json_result = "[";
            while($row = $result->fetch_row()) {
                $pnr = getStringcolumn($row, 0);
                $name = getStringcolumn($row, 1);
                $email = getStringcolumn($row, 2);
                $json_result .= "{";
                $json_result .= "\"pnr\":\"$pnr\",";
                $json_result .= "\"name\":\"$name\",";
                $json_result .= "\"email\":\"$email\"";
                $json_result .= "},";
            }
            $json_result = endJsonList($json_result, 1);
            echo $json_result . "]";
        }
    }

?>