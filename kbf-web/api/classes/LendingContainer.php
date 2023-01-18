<?php
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/Lending.php');
    include_once (__DIR__ . '/../../helpers.php');

    class LendingContainer extends DatabaseConnector {
        var $lends;
        var $historicLends;

        function __construct() {		
            parent::__construct();
            $this->lends = array();
            $this->populateFields();
		}

        function getLends() {
            return $this->lends;
        }

        function getHistoricLends() {
            return $this->historicLends;
        }

        function populateFields() {
            //hämta rätt fält
            $sql = "SELECT id FROM lending where returned_at IS NULL";
            $result = parent::getMysql()->query($sql);
            while($row = $result->fetch_row()) {
                $lendId = $row[0];
                $this->lends[] = new Lending($lendId);
            }
            $result->close();

            $sql = "SELECT id FROM lending where returned_at IS NOT NULL";
            $result = parent::getMysql()->query($sql);
            while($row = $result->fetch_row()) {
                $lendId = $row[0];
                $this->historicLends[] = new Lending($lendId);
            }
            $result->close();
        }

        function delete($id) {
            $currentDate = date("Y-m-d");
            $cleanId = parent::cleanField($id);
            $sql = "UPDATE lending SET returned_at = '$currentDate' WHERE id=$cleanId";
            parent::getMysql()->real_query($sql);
        }

        function create($member, $responsible, $lended) {
            $cleanMember = parent::cleanField($member);
            $cleanResponsible = parent::cleanField($responsible);
            $cleanLended = parent::cleanField($lended);
            $sql = "INSERT INTO lending (member,responsible,lended) VALUES ('$cleanMember', '$cleanResponsible', '$cleanLended')";
            parent::getMysql()->real_query($sql);
        }

        function print() {
            $lends_print = "";
            foreach ($this->lends as $lend) {
                $lends_print .= $lend->print() . ",";
            }
            $lends_print = endJsonList($lends_print, 0);
            return "[" . $lends_print . "]";
        }

        function printHistoric() {
            $lends_print = "";
            foreach ($this->historicLends as $lend) {
                $lends_print .= $lend->print() . ",";
            }
            $lends_print = endJsonList($lends_print, 0);
            return "[" . $lends_print . "]";
        }
    }


?>