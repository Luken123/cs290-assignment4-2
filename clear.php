<?php
ini_set('display_errors', 'On');


$mysqli = new mysqli("oniddb.cws.oregonstate.edu","luken-db", "rHL5UMGvjDYSkTYk","luken-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error" .$mysqli->connect_errno . "luken-db" . $mysqli->connect_error;
}
else{
	
}
//lecture and php manual-followed along

if (!($stmt = $mysqli->prepare("TRUNCATE TABLE testing"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		echo "Inventory cleared!!<br>";
$stmt->close();
echo '<a href="interface.php"> Return </a>';
?>