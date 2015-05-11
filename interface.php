<?php
ini_set('display_errors', 'On');


$mysqli = new mysqli("oniddb.cws.oregonstate.edu","luken-db", "rHL5UMGvjDYSkTYk","luken-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error" .$mysqli->connect_errno . "luken-db" . $mysqli->connect_error;
}
else{
	//echo "Connection worked!<br>";
}
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title> Video Interface </title>
	</head>
	<body>
		<form action="addMovie.php" method="post">
			Movie Title:<br>
			<input type = "text" name="title">
			<br><br>Category:<br>
			<input type = "text" name="category">
			<br><br>Length of Video in Minutes:<br>
			<input type = "text" name="length">
			<br><br>
			<input type = "submit" value="Add Video">
		</form>


</form>
<br>
	<table border='3'>
	<caption> Video Inventory </caption>
	<tr>
	<th>Name
	<th>Category
	<th>Length
	<th>Status
	<th>Check In/Out
	<th>Delete

<?php


if ($_POST == NULL || (isset($_POST['selectCategory']) && $_POST['selectCategory'] == "All Movies")) {
	if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM testing ORDER BY name"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
} else { 
		$category = $_POST['selectCategory'];
		if (!($stmt = $mysqli->prepare("SELECT id, name, category, length, rented FROM testing WHERE category = ? ORDER BY name"))) {
		    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
		if (!$stmt->bind_param("s", $category)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
		    exit;
		}
	}


//code from php manul on fetching from database
	$out_id = NULL;
		$out_name = NULL;
		$out_category = NULL;
		$out_length = NULL;
		$out_rented = NULL;

		if (!$stmt->bind_result($out_id, $out_name, $out_category, $out_length, $out_rented)) {
		    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		    exit;
		}
		while ($stmt->fetch()) {
		     echo '<tr>
		    	  	<td>' . "$out_name" . '</td>
		    	  	<td>' . "$out_category" . '</td>
		    	 	<td>' . "$out_length" . '</td>
		    	 	<form action="status.php" method="POST">';
		    	 	if ($out_rented == 0) {
		    	 		echo '<td>Available</td>
		    	 			<td>
		    	 			<input type="hidden" name="video_id" value="' . "$out_id" . '">
					  		<input type="submit" name="status" value="Check Out">
					  		</td>';
		    	  	} else {
						echo '<td>Rented</td>
							<td>
							<input type="hidden" name="video_id" value="' . "$out_id" . '">
					  		<input type="submit" name="status" value="Return">
							</td>';
					}
					echo '
					</form>
					<form action="delete.php" method="POST">
					<td>
					
					 <input type="hidden" name="video_id" value="' . "$out_id" . '">
					 <input type="submit" value="X">
					 
					 </td>
					 </form>
				</tr>';
		}
?>

	</table>
	<br>
	<form action="interface.php" method="POST">
	Select Category: 
	<select name="selectCategory"> 
	<option value="All Movies">All Movies</option>	
<?php 
		if (!($stmt = $mysqli->prepare("SELECT DISTINCT category FROM testing WHERE category != ''"))) {
    		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}
		if (!$stmt->execute()) {
    		echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    		exit;
		}
		$out_category = NULL;
		if (!$stmt->bind_result($out_category)) {
    		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    		exit;
		}
		while ($stmt->fetch()) {
			echo '			<option value="' . "$out_category" . '">' . "$out_category" . '</option>';
		}
?>
	</select>
	<input type="submit" value = "Filter Results"/><br>
	</form>
	<br>

<form action="clear.php" method="POST">
	Clear Inventory: 
	<input type="submit" value = "Delete All Videos"/><br>
	</form>
	</center>
</body>
</html>

<?php
$stmt->close();
?>
