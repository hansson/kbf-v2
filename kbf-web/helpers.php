<?php
function handlePersonalNumber($pnr) {
	$pnrContainsDash = strpos($pnr, '-');
	if (($pnrContainsDash && strlen($pnr) > 8) || (!$pnrContainsDash && strlen($pnr) > 6)) {
		$pnr = substr($pnr, 2);
	}

	if (preg_match("/[0-9]{6}(-[0-9]){0,1}/", $pnr) && (strlen($pnr) == 6 || ($pnrContainsDash && strlen($pnr) == 8))) {
    	return $pnr;
	} else {
		throw new Exception("Bad personal number");
	}

}

function cleanField($field, $mysqli) {
	$field = stripslashes($field);
	$field = $mysqli->escape_string($field);
	return $field;
}

function handleResult($result) {
	if($result) {
		echo '{"status":"ok"}';
	} else {
		error("Failed to insert row");
	}
}

function handleResults($result, $second_result, $mysqli) {
	if($result && $second_result) {
		echo '{"status":"ok"}';
		$mysqli->commit();
	} else {
		error("Failed to insert row");
		$mysqli->rollback();
	}
	$mysqli->close();
}

function error($error) {
	http_response_code(400);
	echo "{\"status\":\"error\", \"error\":\"$error\"}";
}

function forceHttps($config) {
	if($config["environment"] === "prod") {
		if($_SERVER["HTTPS"] != "on") {
			header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
			exit();
		}
	}
}

function checkSession() {
	if(!isset($_SESSION["pnr"])){
		header("location:login.php");
		exit();
	}
}

function checkSessionApi($config) {
	if($config["environment"] === "prod") {
		session_start();
		if(!isset($_SESSION["pnr"])){
			error("Need to be logged in");
			exit();
		}
	}
}

function isResponsible() {
	return isset($_SESSION["responsible"]) && $_SESSION["responsible"] == 1;
}

function checkResponsible() {
	if(!isResponsible())  {
		error("Not authorized");
		exit();
	}
	return true;
}

function redirectNotResponsible() {
	if(!isResponsible()) {
		header("location:my_info.php");
		exit();
	}
}

function getStringcolumn($row, $index) {
	$value = $row[$index];
	return str_replace('"', '\\"', $value);
}

function invalidateSession($error) {
	unset($_SESSION['pnr']);
	error($error);
}

function endJsonList($json, $initialCharacters) {
	if(strlen($json) > $initialCharacters) {
		return substr($json, 0, strlen($json) - 1);
	} else {
		return $json;
	}
}
?>