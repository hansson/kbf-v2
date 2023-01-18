<?php
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class Lending extends DatabaseConnector {
        var $id;
        var $responsible;
        var $member;
        var $lended;
        var $lended_at;
        var $returned_at;

        function __construct($id) {		
            parent::__construct();
			$this->id = parent::cleanField($id);
            $this->populateFields();
		}

        function getId() {
            return $this->id;
        }

        function getResponsible() {
            return $this->responsible;
        }

        function getMember() {
            return $this->member;
        }

        function getLended() {
            return $this->lended;
        }

        function getLendedAt() {
            return $this->lended_at;
        }

        function getReturnedAt() {
            return $this->returned_at;
        }

        function populateFields() {
            //hämta rätt fält
            $sql = "SELECT id, responsible, member, lended, lended_at, returned_at FROM lending WHERE id = '$this->id'";
            $result = parent::getMysql()->query($sql);
            while($row = $result->fetch_row()) {
                $this->id = $row[0];
                $this->responsible = parent::getStringcolumn($row, 1);
                $this->member = parent::getStringcolumn($row, 2);
                $this->lended = parent::getStringcolumn($row, 3);
                $this->lended_at = parent::getStringcolumn($row, 4);
                $this->returned_at = parent::getStringcolumn($row, 5);
            }
            $result->close();
        }

        function print() {
            return "{
                \"id\":\"$this->id\",
                \"responsible\":\"$this->responsible\",
                \"member\":\"$this->member\",
                \"lended\":\"$this->lended\",
                \"lended_at\":\"$this->lended_at\",
                \"returned_at\":\"$this->returned_at\"
            }";

        }
    }


?>