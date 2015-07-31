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
          <th style="text-align:left"><h1>CS 340 Final Project</h1><br><span id="headLine">VIEW, ADD AND SORT MEDICAL OFFICE ASSISTANTS</span></th>
          <td valign="top">Programmed by <strong>Kelvin Watson</strong><br>OSU ID: 932540242<br>ONID ID: watsokel</td>
        </tr>
      </table>
    </header>
    <hr>
    <nav>
      <table border="1" width="100%" id="navigation"><caption><h3>Choose an Action</h3></caption>
        <tr>
          <td><strong>BASIC OPERATIONS</strong></td>
          <td><a href="index.php">View, Add and Sort Appointments</a></td>
          <td><a href="patients.php">View, Add and Sort Patients</a></td>
          <td><a href="assistants.php">View, Add and Sort Medical Office Assistants</a></td>
          <td><a href="providers.php">View, Add, Filter and Sort Healthcare Providers</a></td>
          <td><a href="conditions.php">View, Add and Sort Medical Conditions</a></td>
          <td><a href="medications.php">View, Add and Sort Medications</a></td>
        </tr>
        <tr>
          <td><strong>ADVANCED OPERATIONS</strong></td>
          <td><a href="diagnosis.php">Add/Update Patient Diagnoses</a></td>
          <td><a href="prescription.php">Add/Update Patient Prescription</a></td>
          <td><a href="updatePatient.php">Update Patient Demographics</a></td>
          <td><a href="updateAssistant.php">Update Medical Office Assistant Information</a></td>
          <td><a href="updateProvider.php">Update Healthcare Provider Information</a></td>
          <td></td>
        </tr>
      </table>
    </nav>
    
    
    <hr>

    <section>
      <table border="1" id="databaseData"><caption><h2>Medical Office Assistants</h2></caption>
        <thead>
          <tr>
            <th>Staff ID</th>
            <th>Last Name</th>
            <th>First Name</th>
          </tr>
        </thead>
        <tbody>
            <?php
            if(!($stmt = $mysqli->prepare("SELECT * FROM medical_office_assistants"))){
              echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }

            if(!$stmt->execute()){
              echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if(!$stmt->bind_result($id, $firstName, $lastName)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt->fetch()){
             echo "<tr><td>" . $id . "</td><td>" . $firstName . "</td><td>" . $lastName . "</td></tr>";
            }
            $stmt->close();
            ?>
        </tbody>
      </table>
     </section> 

    <section>
      <h2>Add Medical Office Assistants</h2>
      <form action="addAssistant.php" method="post">
        <fieldset>
        <legend>Medical Office Assistant Information</legend>
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
            <td colspan="2"><input type="submit" value="Add Assistant"></td>
          </tr>
        </table>
        </fieldset>
      </form>
    </section>

    <section>
      <h2>Sort Medical Office Assistants</h2>
      <form action="sortAssistants.php" method="post">
        <fieldset>
        <legend>Sort by</legend>
        <table>
          <tr>
            <td><input type="radio" name="sort" value="first_name">First Name</td>
            <td><input type="radio" name="sort" value="last_name">Last Name</td>
            <td><input type="submit" value="Sort"></td>
          </tr>        
        </table>
        </fieldset>
      </form>
    </section>
    
    <footer><em>Kelvin Watson, OSU ID 932540242, CS340 Final Project</em></footer>

  </body>
</html>