<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Add Healthcare Provider</title>
  </head>
  <body>
<?php

if(!ctype_digit($_POST['license'])){
  echo "Unable to add healthcare provider. License must be a whole number.";
}
else{
  $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  if(!($stmt = $mysqli->prepare("INSERT INTO healthcare_providers(first_name, last_name, profession, license) VALUES (?,?,?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("sssi",$_POST['firstname'],$_POST['lastname'],$_POST['profession'],$_POST['license']))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
      echo "Successfully added " . $stmt->affected_rows . " row(s) to TABLE healthcare_providers.<br>";
  }
}?>
  Return to <a href="providers.php">View, Filter and Add Healthcare Providers</a> page
  </body>
</html>