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

$apptDateTime = $_POST['apptDate']." ".$_POST['apptTime']; 

if(empty($_POST['selectPatient']) || ("" == trim($_POST['selectPatient']))) {
  echo "Unable to add appointment. You must select a patient.<br>";
}
else if((!isset($_POST['apptDate'])) || empty($_POST['apptDate']) || ("" == trim($_POST['apptDate']))) {
  echo "Unable to add appointment. You must select an appointment date.<br>"; 
} 
else if((!isset($_POST['apptTime'])) || empty($_POST['apptTime']) || ("" == trim($_POST['apptTime']))) {
  echo "Unable to add appointment. You must select an appointment time.<br>"; 
}
else if(empty($_POST['selectProvider']) || ("" == trim($_POST['selectProvider']))) {
  echo "Unable to add appointment. You must select a healthcare provider.<br>";
} else {
  $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  if(!($stmt = $mysqli->prepare("INSERT INTO appointments(date_time, reason, patient_ID, provider_ID, assistant_ID) VALUES (?,?,?,?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("ssiii",$apptDateTime,$_POST['reason'],$_POST['selectPatient'],$_POST['selectProvider'],$_POST['selectAssistant']))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
      echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "Successfully added " . $stmt->affected_rows . " row(s) to TABLE appointments.<br>";
  }
  $stmt->close();
} 
?>
    Return to <a href="index.php">View, Filter and Add Appointments</a> page
  </body>
</html>