<?php
function getDBConnection($config) {
	$host=$config['mysql_address']; // Host name
	$username=$config['mysql_username']; // Mysql username
	$password=$config['mysql_password']; // Mysql password
	$db_name=$config['mysql_database']; // Database name
	// Connect to server and select databse.
	$mysqli = new mysqli($host, $username, $password, $db_name);
	return $mysqli;
}
?>