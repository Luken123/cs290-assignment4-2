<?php
ini_set('display_errors', 'On');


$mysqli = new mysqli("oniddb.cws.oregonstate.edu","luken-db", "rHL5UMGvjDYSkTYk","luken-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error" .$mysqli->connect_errno . "luken-db" . $mysqli->connect_error;
}
else{
	
}

//create variables
$title = $_POST['title'];
$category = $_POST['category'];
$length = $_POST['length'] + 0;


//input validation for adding a movie
if ($_POST['title'] == "") {
	echo 'Title is a required field.<br>';
	echo '<a href="interface.php"> Return </a>';
	exit;
}

if ($length != NULL) {
	if (!is_int($length) || $length < 1) {  // 
		echo 'Length needs to be a positive integer.<br>';
		echo '<a href="interface.php"> Return </a>';
		exit;
	}
}

if ($length == NULL) {
	echo 'Length needs to be a positive integer.<br>';
		echo '<a href="interface.php"> Return </a>';
		exit;
	}


//prepared statement from lecture and php manual

if (!($stmt = $mysqli->prepare("INSERT INTO testing (id, name, category, length) VALUES (null,?,?,?);"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		if (!$stmt->bind_param("ssi", $title, $category, $length)) {
		   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}

		if (!$stmt->execute()) {
		   
		    if ($mysqli->errno == 1062) {
		    	echo "Duplicate entry. Try again<br>";
		    	echo '<a href="interface.php"> Return </a>';
		    	exit;
		    }
		   
		}
 			echo "Video Added!!!<br>";
			echo '<a href="interface.php"> Return </a>';
		    exit;
$stmt->close();

echo '<a href="interface.php"> Return </a>';
?>