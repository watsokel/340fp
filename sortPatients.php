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
    <title>Sort Assistants</title>
    <style>
    body {
      font-family: Arial;
    }
    #databaseData td{
      font-family: monospace;
      font-size: 1.2em;
    }
    </style>
  </head>
  <body>
    <table border="1"><caption>Patients Ordered by <?php echo $_POST['sort']; ?></caption>
      <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Birthdate</th>
      </tr>
      </thead>
      <tbody>
        <tr>
          <?php
          if(!($stmt = $mysqli->prepare("SELECT * FROM patients ORDER BY $_POST[sort] ASC"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }

          if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          if(!$stmt->bind_result($id, $firstName, $lastName, $birthDate)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          while($stmt->fetch()){
           echo "<tr><td>" . $firstName . "</td><td>" . $lastName . "</td><td>" . $birthDate . "</td></tr>";
          }
          $stmt->close();
          ?>
        </tr>
      </tbody>
    </table>
    Return to <a href="patients.php">View, Sort and Add Patients</a> page

  </body>
</html>