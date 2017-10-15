<?php
    include_once (__DIR__ . '/../db.php');

    class DatabaseConnector {
        var $mysqli;

        function __construct() {
            $config = require (__DIR__ . "/../../kbf.config.php");
            $this->mysqli = getDBConnection($config);
        }

        function __destruct() {
            $this->mysqli->close();
        }

        function getMysql() {
            return $this->mysqli;
        }

        function disableAutoCommit() {
            $this->mysqli->autocommit(FALSE);
        }

        function commit() {
            $this->mysqli->commit();
        }

        function rollback() {
            $this->mysqli->rollback();
        }

        function cleanField($field) { 
            $field = stripslashes($field);
            $field = $this->mysqli->escape_string($field);
            return $field;
        }

        function getStringcolumn($row, $index) {
            $value = $row[$index];
            return str_replace('"', '\\"', $value);
        }
    }

?>