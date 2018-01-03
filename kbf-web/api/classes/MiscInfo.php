<?php
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class MiscInfo extends DatabaseConnector {
        var $type;
        var $text;

        function __construct($type) {		
            parent::__construct();
            $this->type = parent::cleanField($type);
            $this->populateFields();		
		}

        function getText() {
            return $this->text;
        }

        function populateFields() {
            $sql = "SELECT `text` FROM misc";
            $result = parent::getMysql()->query($sql);
            while($result && $row = $result->fetch_row()) {
                $this->text  = parent::getStringcolumn($row, 0);
            }
            if($result) {
                $result->close();
            }
        }

        function print() {
            echo $this->text;
        }
    }

?>