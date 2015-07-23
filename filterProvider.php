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
    <title>Filter Healthcare Provder</title>
  </head>
  <body>
    
    <table border="1"><caption>Healthcare Providers whose Profession is <span style="color:blue"><?php echo $_POST['filterProvider']; ?></span></caption>
      <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
      </tr>
      </thead>
      <tbody>
        <tr>
          <?php
          if(!($stmt = $mysqli->prepare("SELECT first_name,last_name FROM healthcare_providers WHERE profession=?"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }
          if (!$stmt->bind_param("s", $_POST['filterProvider'])){
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
          }
          if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          if(!$stmt->bind_result($firstName,$lastName)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          while($stmt->fetch()){
           echo "<tr><td>" . $firstName . "</td><td>" . $lastName . "</td></tr>";
          }
          $stmt->close();
          ?>
        </tr>
      </tbody>
    </table>
    Return to <a href="providers.php">View, Sort and Add Healthcare Providers</a> page

  </body>
</html>