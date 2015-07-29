<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Add Medication</title>
  </head>
  <body>
<?php

if(!empty($_POST['conditionName'])){
  $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  if(!($stmt = $mysqli->prepare("INSERT INTO medical_conditions(name) VALUES (?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("s",$_POST['conditionName']))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
      echo "Successfully added " . $stmt->affected_rows . " row(s) to TABLE healthcare_providers.<br>";
  }
} else {
  echo "Cannot insert row. You must enter a medical condition name.";
}
?>
  Return to <a href="conditions.php">View, Filter and Add Medical Conditions</a> page
  </body>
</html>