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
    
    <table border="1"><caption>Healthcare Providers Ordered by <?php echo $_POST['sortProvider']; ?></caption>
      <thead>
      <tr>
        <th>Provider ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Profession</th>
        <th>License</th>
      </tr>
      </thead>
      <tbody>
        <tr>
          <?php
          if(!($stmt = $mysqli->prepare("SELECT * FROM healthcare_providers ORDER BY $_POST[sortProvider] ASC"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }
          if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          if(!$stmt->bind_result($id, $firstName, $lastName, $profession, $license)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          while($stmt->fetch()){
           echo "<tr><td>" . $id . "</td><td>" . $firstName . "</td><td>" . $lastName . "</td><td>" . $profession . "</td><td>" . $license . "</td></tr>";
          }
          $stmt->close();
          ?>
        </tr>
      </tbody>
    </table>
    Return to <a href="assistants.php">View, Sort and Add Medical Office Assistants</a> page

  </body>
</html>