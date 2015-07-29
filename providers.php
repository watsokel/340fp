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
    <title>CS340 Final Project</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header>
      <table width="100%">
        <tr>
          <th style="text-align:left"><h1>CS 340 Final Project</h1><br><span id="headLine">VIEW, FILTER AND ADD HEALTHCARE PROVIDERS</th>
          <td valign="top">Programmed by <strong>Kelvin Watson</strong><br>OSU ID: 932540242<br>ONID ID: watsokel</td>
        </tr>
      </table>
    </header>
    <hr>
    <nav>
      <table border="1" width="100%" id="navigation"><caption><h2>Choose an Action</h2></caption>
        <tr>
          <td><a href="index.php">View, Filter and Add Appointments</a></td>
          <td><a href="patients.php">View and Filter Patients</a></td>
          <td><a href="assistants.php">View, Sort and Add Medical Office Assistants</a></td>
          <td><a href="providers.php">View, Filter and Add Healthcare Providers</a></td>
          <td><a href="conditions.php">View, Filter and Add Medical Conditions</a></td>
          <td><a href="medications.php">View, Filter and Add  Medications</a></td>
        </tr>
      </table>
    </nav>
    
    <hr>

    <section>
      <table border="1" id="databaseData"><caption><h2>Healthcare Providers</h2></caption>
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
            if(!($stmt = $mysqli->prepare("SELECT * FROM healthcare_providers"))){
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
     </section> 

    <section>
      <h2>Add Healthcare Providers</h2>
      <form action="addProvider.php" method="post">
        <fieldset>
        <legend>Healthcare Provider Information</legend>
        <table>
          <tr>
              <td><label for="fname">First Name</label></td>
              <td><input type="text" name="firstName" id="fname"></td>
          </tr>
          <tr>
            <td><label for="lname">Last Name</label></td>
            <td><input type="text" name="lastName" id="lname"></td>
          </tr>
          <tr>
            <td>Profession</td>
            <td><select name="profession">
              <option value="Chiropractor">Chiropractor</option>
              <option value="Dentist">Dentist</option>
              <option value="Dietician">Dietician</option>
              <option value="Nurse Practitioner">Nurse Practitioner</option>
              <option value="Occupational Therapist">Occupational Therapist</option>
              <option value="Optometrist">Optometrist</option>
              <option value="Pharmacist">Pharmacist</option>
              <option value="Physician">Physician</option>
              <option value="Physiotherapist">Physiotherapist</option>
            </td>
          </tr>
          <tr>
            <td><label for="lic">License</label></td>
            <td><input type="text" name="license" id="lic"></td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" value="Add Provider"></td>
          </tr>
        </table>
        </fieldset>
      </form>
    </section>

    <section>
      <h2>Filter Healthcare Provider</h2>
      <form action="filterProvider.php" method="post">
        <fieldset>
        <legend>Filter by</legend>
        <table>
          <tr>
            <td><label for="filterByProfession">Profession</label>
            <select name="filterProvider" id="filterByProfession">
            <?php
            if(!($stmt = $mysqli->prepare("SELECT DISTINCT profession FROM healthcare_providers"))){
              echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
              echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if(!$stmt->bind_result($profession)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt->fetch()){
              echo "<option value=\"$profession\">$profession</option>";
            }
            $stmt->close();
            ?>
            </select>
            </td>
            <td><input type="submit" value="Filter"></td>
          </tr>        
        </table>
        </fieldset>
      </form>
    </section>

    <section>
      <h2>Sort Medical Office Assistants</h2>
      <form action="sortProviders.php" method="post">
        <fieldset>
        <legend>Sort by</legend>
        <table>
          <tr>
            <td><input type="radio" name="sortProvider" value="first_name">First Name</td>
            <td><input type="radio" name="sortProvider" value="last_name">Last Name</td>
            <td><input type="radio" name="sortProvider" value="profession">Profession</td>
            <td><input type="radio" name="sortProvider" value="license">License Number</td>
            <td><input type="submit" value="Sort"></td>
          </tr>        
        </table>
        </fieldset>
      </form>
    </section>
    
    <footer><em>Kelvin Watson, OSU ID 932540242, CS340 Final Project</em></footer>

  </body>
</html>