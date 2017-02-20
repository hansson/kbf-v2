<?php
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class ClimbInfo extends DatabaseConnector {
        var $pnr;
        var $card;
        var $left;
        var $fee_valid;
        var $member_valid;

        function __construct($pnr) {		
            parent::__construct();
			$this->pnr = parent::cleanField($pnr);
            $this->populateFields();		
		}

        function getCard() {
            return $this->card;
        }

        function getLeft() {
            return $this->left;
        }

        function getFeeValid() {
            return $this->fee_valid;
        }

        function getMemberValid() {
            return $this->member_valid;
        }

        function canClimb() {
            return $this->left != "-" || ($this->fee_valid != "-" && $this->member_valid != "-");
        }

        function populateFields() {
            $sql = "SELECT `left`, card FROM `ten_card` WHERE `pnr` = '$this->pnr' AND `left` > 0";
            $result = parent::getMysql()->query($sql);
            $this->left = "-";
            $this->card = "-";
            if($result->num_rows === 1) {
                $row = $result->fetch_row();
                $this->left = $row[0];
                $this->card = $row[1];
            }
            $result->close();
            $year = date('Y');
            $month = date('n');
            if($month > "6") {
                $sql = "SELECT paymentDate, `type` FROM `climbing_fee` WHERE `pnr` = '$this->pnr' AND (paymentDate > '$year-07-01 00:00:00' OR (paymentDate > '$year-01-01 00:00:00' AND `type` = 2)) LIMIT 1";
            } else {
                $sql = "SELECT paymentDate, `type` FROM `climbing_fee` WHERE `pnr` = '$this->pnr' AND paymentDate > '$year-01-01 00:00:00' LIMIT 1";
            }

            $this->fee_valid = "-";
            if($this->isResponsible()) {
                $this->fee_valid = "$year-12-31";
            }  else {
                $result = parent::getMysql()->query($sql);
                if($result->num_rows === 1) {
                    $row = $result->fetch_row();
                    if( $row[1] == 2 || $month > "6") { //year or later part of year
                        $this->fee_valid = "$year-12-31";
                    } else { //half year, begining of year
                        $this->fee_valid = "$year-06-30";
                    }
                }
                $result->close();
            }
            $sql = "SELECT paymentDate FROM `membership` WHERE `pnr` = '$this->pnr' AND paymentDate > '$year-01-01 00:00:00' ORDER BY paymentDate DESC LIMIT 1";
            $result = parent::getMysql()->query($sql);
            $this->member_valid = "-";
            if($result->num_rows === 1) {
                $this->member_valid = "$year-12-31";
            }
            $result->close();
        }

        function isResponsible() {
            $sql = "SELECT responsible FROM `person` WHERE `pnr` = '$this->pnr' AND responsible > 0";
            $result = parent::getMysql()->query($sql);
            if($result && $result->num_rows === 1) {
                $responsible = $result->fetch_row()[0] > 0;
                $result->close();
                return $responsible;
            }
            return false;
        }
    }

?>