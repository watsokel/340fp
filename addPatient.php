<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Add Appointment</title>
  </head>
  <body>

<?php

if(empty($_POST['firstName']) || ("" == trim($_POST['firstName']))) {
  echo "Unable to add appointment. You must enter a first name for a patient.<br>";
}
else if(empty($_POST['lastName']) || ("" == trim($_POST['lastName']))) {
 echo "Unable to add patient. You must enter a last name.<br>"; 
}
else if((!isset($_POST['dateOfBirth'])) || empty($_POST['dateOfBirth']) || ("" == trim($_POST['dateOfBirth']))) {
  echo "Unable to add patient. You must enter a birth date.<br>"; 
}
else {
  $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  if(!($stmt = $mysqli->prepare("INSERT INTO patients(first_name, last_name, birthdate) VALUES (?,?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  $birthDate = date("Y-m-d", strtotime($_POST['dateOfBirth']));  //reformat and create date object


  if(!($stmt->bind_param("sss",$_POST['firstName'],$_POST['lastName'],$birthDate))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
      echo "Successfully added " . $stmt->affected_rows . " row(s) to TABLE patients.<br>";
  }
}?>
  Return to <a href="patients.php">View, Filter and Add Patients</a> page
  </body>
</html>