<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Add Prescription</title>
  </head>
  <body>

<?php
if(empty($_POST['selectDrug']) || ("" == trim($_POST['selectDrug']))) {
  echo "Unable to add prescription. You must select a medication.<br>";
} else {
  $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  if(!($stmt = $mysqli->prepare("INSERT INTO takes(patient_ID,drug_name) VALUES (?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("is",$_POST['patientID'],$_POST['selectDrug']))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
      echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "Successfully added " . $stmt->affected_rows . " row(s) to TABLE takes.<br>";
  }
  $stmt->close();
} 
?>
  Return to <a href="prescription.php">Prescription</a> page
  </body>
</html>