<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Delete Diagnosis</title>
  </head>
  <body>

<?php
if(empty($_POST['selectCondition']) || ("" == trim($_POST['selectCondition']))) {
  echo "Unable to delete diagnosis. You must select a condition.<br>";
} else {
  $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  if(!($stmt = $mysqli->prepare("DELETE FROM diagnosed WHERE patient_ID=? AND diagnosis=?"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("is",$_POST['patientID'],$_POST['selectCondition']))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
      echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "Successfully deleted " . $stmt->affected_rows . " row(s) from TABLE diagnosed.<br>";
  }
  $stmt->close();
} 
?>
  Return to <a href="diagnosis.php">Diagnosis</a> page
  </body>
</html>