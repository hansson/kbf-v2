<?php
    include_once (__DIR__ . '/ClimbInfo.php');
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class CurrentOpen extends DatabaseConnector {
        var $open_id;

        function __construct() {		
            parent::__construct();
            $this->open_id  = NULL;
            $this->populateFields();
		}

        function getOpenId() {
            return $this->open_id;
        }

        function populateFields() {
            $sql = "SELECT id FROM `open` WHERE `signed` IS NULL LIMIT 1";
            $result = parent::getMysql()->query($sql);
            while($row = $result->fetch_row()) {
                $this->open_id  = $row[0];
            }
            if($result->num_rows === 0) {
                $this->open_id  = NULL;
            }
            $result->close();
        }

        function add($identification) {
            if($this->open_id) {
                $pnr = parent::cleanField($identification);
                $card = NULL;
                try {
                    $pnr = handlePersonalNumber($pnr);
                } catch ( Exception $e ) {
                    //Assume number is a card
                    $card = $pnr;
                    $pnr = NULL;
                }
                if($pnr) {
                    $climbInfo = new ClimbInfo($pnr);
                    if($climbInfo->canClimb()) {
                        if($climbInfo->getMemberValid() != "-" && $climbInfo->getFeeValid() != "-") {
                            $sql="INSERT INTO `open_person` (`open_id`, `pnr`, `name`) VALUES ($this->open_id,'$pnr',NULL)";
                            $result  = parent::getMysql()->real_query($sql);
                            if(!$result) {
                                error("Failed to insert row");
                                return false;
                            }
                            return true;
                        } else {
                            return $this->addCard($climbInfo->card, $climbInfo->left);
                        }
                    } else {
                        error("No fee paid");
                        return false;
                    }
                } else {
                    $sql = "SELECT `left`, card FROM `ten_card` WHERE `id` = $card AND `left` > 0";
                    $result = parent::getMysql()->query($sql);
                    $left = NULL;
                    if($result->num_rows === 1) {
                        $row = $result->fetch_row();
                        $left = $row[0];
                        $card = $row[1];
                    }
                    $result->close();
                    if($left) {
                        return $this->addCard($card, $left);
                    } else {
                        error("Failed to find card");
                        return false;
                    }
                }
            } else {
                error("No open");
                return false;
            }
        }

        function addCard($card, $left) {
            $left = $left - 1;
            $sql = "SELECT id FROM `open_person` WHERE open_id = $this->open_id AND `name` = $card";
            if($result = parent::getMysql()->query($sql)) {
                if($result->num_rows == 0) {
                    parent::disableAutoCommit();
                    $sql = "INSERT INTO `open_person` (`open_id`, `pnr`, `name`) VALUES ($this->open_id,NULL,'$card')";
                    $result  = parent::getMysql()->real_query($sql);
                    $sql = "UPDATE `ten_card` SET `left`='$left' WHERE `card`=$card";
                    $second_result  = parent::getMysql()->real_query($sql);
                    if($result && $second_result) {
                        parent::commit();
                        return true;
                    } else {
                        error("Failed to insert row");
                        parent::rollback();
                        return false;
                    }
                } else {
                   error("Card already exist");
                    return false; 
                }
                
            } else {
                error("Card already exist");
                return false;
            }
        }

    }

?>