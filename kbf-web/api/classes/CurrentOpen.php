<?php
    include_once (__DIR__ . '/ClimbInfo.php');
    include_once (__DIR__ . '/DatabaseConnector.php');
    include_once (__DIR__ . '/../../helpers.php');

    class CurrentOpen extends DatabaseConnector {
        var $open_id;
        var $responsible;
        var $date;
        var $name;

        function __construct() {		
            parent::__construct();
            $this->open_id  = NULL;
            $this->responsible  = NULL;
            $this->date  = NULL;
            $this->name  = NULL;
            $this->populateFields();
		}

        function getOpenId() {
            return $this->open_id;
        }

        function getResponsible() {
            return $this->responsible;
        }

        function populateFields() {
            $sql = "SELECT o.id, o.responsible, o.date, p.name FROM `open` as o INNER JOIN `person` as p ON p.pnr = o.responsible WHERE o.`signed` IS NULL LIMIT 1";
            $result = parent::getMysql()->query($sql);
            while($row = $result->fetch_row()) {
                $this->open_id  = $row[0];
                $this->responsible  = $row[1];
                $this->date  = $row[2];
                $this->name  = getStringcolumn($row, 3);
            }
            $result->close();
        }

        function print() {
            echo "{";
            echo "\"id\":$this->open_id,";
            echo "\"responsible\":\"$this->responsible\",";
            echo "\"date\":\"$this->date\",";
            echo "\"responsible_name\":\"$this->name\"";
            echo "}";
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

                            $sql = "SELECT id FROM `open_person` WHERE open_id = $this->open_id AND `pnr` = $pnr";
                            if($result = parent::getMysql()->query($sql)) {
                                if($result->num_rows > 0) {
                                    $row = $result->fetch_row();
                                    parent::commit();
                                    return $row[0];
                                }
                            } 
                            error("Could not find person");
                            return false;

                        } else {
                            return $this->addCard($climbInfo->card, $climbInfo->left);
                        }
                    } else {
                        error("No fee paid");
                        return false;
                    }
                } else {
                    $sql = "SELECT `left`, card FROM `ten_card` WHERE `card` = $card AND `left` > 0";
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
                parent::disableAutoCommit();
                $sql = "INSERT INTO `open_person` (`open_id`, `pnr`, `name`) VALUES ($this->open_id,NULL,'$card+$result->num_rows')";
                $result  = parent::getMysql()->real_query($sql);
                $sql = "UPDATE `ten_card` SET `left`='$left' WHERE `card`=$card";
                $second_result  = parent::getMysql()->real_query($sql);
                if($result && $second_result) {
                    $sql = "SELECT id FROM `open_person` WHERE open_id = $this->open_id AND `name` = $card";
                    if($result = parent::getMysql()->query($sql)) {
                        if($result->num_rows > 0) {
                            $row = $result->fetch_row();
                            parent::commit();
                            return $row[0];
                        }
                    } 
                    error("Could not find card");
                    return false;
                } else {
                    error("Failed to insert row");
                    parent::rollback();
                    return false;
                }        
            } else {
                error("Card already exist");
                return false;
            }
        }

    }

?>