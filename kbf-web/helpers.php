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
		access_log($_SESSION["pnr"] . " - ? - ? - ERROR: Bad db result");
	}
}

function handleResults($result, $second_result, $mysqli) {
	if($result && $second_result) {
		echo '{"status":"ok"}';
		$mysqli->commit();
	} else {
		error("Failed to insert row");
		access_log($_SESSION["pnr"] . " - ? - ? - ERROR: Bad db result");
		$mysqli->rollback();
	}
	$mysqli->close();
}

function error($error) {
	http_response_code(400);
	echo "{\"status\":\"error\", \"error\":\"$error\"}";
	if(isset($_SESSION["pnr"])) {
		access_log($_SESSION["pnr"] . " - GET - /api/private/open/ - ERROR: $error");
	} else {
		access_log("No session - Unknown - Unknown - ERROR: $error");
	}
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

function getHeader($active) {
	if(isResponsible()) {
		echo '<li class="nav-item">';
		if($active == "index") {
			echo '<a class="nav-link active" href="#">Öppna</a>';
		} else {
			echo '<a class="nav-link" href="index.php">Öppna</a>';
		}
		echo '</li>';    

		echo '<li class="nav-item">';
		if($active == "register_fee") {
			echo '<a class="nav-link active" href="#">Registrera</a>';
		} else {
			echo '<a class="nav-link" href="register_fee.php">Registrera</a>';
		}
		echo '</li>';
	}
	if(isAdmin()) {
		echo '<li class="nav-item">';
		if($active == "administer") {
			echo '<a class="nav-link active" href="#">Admin</a>';
		} else {
			echo '<a class="nav-link" href="administer.php">Admin</a>';
		}
		echo '</li>';

		echo '<li class="nav-item">';
		if($active == "reports") {
			echo '<a class="nav-link active" href="#">Rapporter</a>';
		} else {
			echo '<a class="nav-link" href="reports.php">Rapporter</a>';
		}
		echo '</li>';
	}

	echo '<li class="nav-item">';
	if($active == "my_info") {
		echo '<a class="nav-link active" href="my_info.php">Min info</a>';
	} else {
		echo '<a class="nav-link" href="my_info.php">Min info</a>';
	}
	echo '</li>'; 
}

function access_log($text) {
	$filename = __DIR__ . "/logs/access.log";
	if (!file_exists($filename)) { touch($filename); chmod($filename, 0666); }
	if (filesize($filename) > 2*1024*1024) {
		$filename2 = "$filename.old";
		if (file_exists($filename2)) unlink($filename2);
		rename($filename, $filename2);
		touch($filename); chmod($filename,0666);
	}
	$date = date("Y-m-d H:i");
	$text = "$date: $text\n";
	if (!is_writable($filename)) die("<p>\nCannot open log file ($filename)");
	if (!$handle = fopen($filename, 'a')) die("<p>\nCannot open file ($filename)");
	if (fwrite($handle, $text) === FALSE) die("<p>\nCannot write to file ($filename)");
	fclose($handle);
}
?>