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

function getPnr($pnr, $mysqli) {
	$pnr = cleanField($pnr, $mysqli);
	try {
		$pnr = handlePersonalNumber($pnr);
	} catch ( Exception $e ) {
		error("Bad personal number");
		$mysqli->close();
		exit();
	}
	return $pnr;
}

function checkPnr($pnr) {
	try {
		$pnr = handlePersonalNumber($pnr);
	} catch ( Exception $e ) {
		error("Bad personal number");
		exit();
	}
	return $pnr;
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
	return isset($_SESSION["responsible"]) && $_SESSION["responsible"] >= 1;
}

function isAdmin() {
	return isset($_SESSION["responsible"]) && $_SESSION["responsible"] == 2;
}

function checkResponsible() {
	if(!isResponsible())  {
		error("Not authorized");
		exit();
	}
	return true;
}

function checkAdmin() {
	if(!isAdmin())  {
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

function redirectNotAdmin() {
	if(!isAdmin()) {
		header("location:index.php");
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

function getNameForItems($items, $mysqli) {
	for ($i = 0; $i < sizeof($items); $i++) {
		$item = $items[$i];
		$id = cleanField($item['id'], $mysqli);
		$sql = "SELECT name FROM prices WHERE id=$id";
		$result = $mysqli->query($sql);
		while($row = $result->fetch_row()) {
			$items[$i]["name"] = $row[0];
		}
	}
	return $items;
}
?>