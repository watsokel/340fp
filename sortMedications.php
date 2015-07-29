<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Sort Providers</title>
  </head>
  <body>
      
    <table border="1"><caption>Medications Ordered by name <?php if($_POST['alphaCondition']=='ASC') echo 'in alphabetical order'; else echo 'in reverse alphabetical order'; ?></caption>
      <thead>
      <tr>
        <th>Medication Name</th>
      </tr>
      </thead>
      <tbody>
        <tr>
          <?php
          if($_POST['alphaCondition']=='ASC'){
            if(!($stmt = $mysqli->prepare("SELECT * FROM medications ORDER BY name ASC"))){
              echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
          } 
          else{
            if(!($stmt = $mysqli->prepare("SELECT * FROM medications ORDER BY name DESC"))){
              echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
          } 
          if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          if(!$stmt->bind_result($name)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          while($stmt->fetch()){
           echo "<tr><td>" . $name . "</td></tr>";
          }
          $stmt->close();
          ?>
        </tr>
      </tbody>
    </table>
    Return to <a href="medications.php">View, Sort and Add Medications</a> page

  </body>
</html>