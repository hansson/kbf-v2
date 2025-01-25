<?php
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class TagInfo extends DatabaseConnector {
        var $pnr;
        var $tag_valid;

        function __construct($pnr) {		
            parent::__construct();
			$this->pnr = parent::cleanField($pnr);
            $this->populateFields();		
		}

        function getTagValid() {
            return $this->tag_valid;
        }

        function populateFields() {
            $year = date('Y');
            $month = date('n');
            if($month > "6") {
                $sql = "SELECT paymentDate, `type` FROM `tag` WHERE `pnr` = '$this->pnr' AND (paymentDate > '$year-07-01 00:00:00' OR (paymentDate > '$year-01-01 00:00:00' AND `type` = 2)) LIMIT 1";
            } else {
                $sql = "SELECT paymentDate, `type` FROM `tag` WHERE `pnr` = '$this->pnr' AND paymentDate > '$year-01-01 00:00:00' LIMIT 1";
            }

            $this->tag_valid = "-";
            $result = parent::getMysql()->query($sql);
            if($result->num_rows === 1) {
                $row = $result->fetch_row();
                if( $row[1] == 2 || $month > "6") { //year or later part of year
                    $this->tag_valid = "$year-12-31";
                } else { //half year, begining of year
                    $this->tag_valid = "$year-06-30";
                }
            }
            $result->close();
        }

    }

?>