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
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  </head>
  <body>
    <header>
      <table width="100%">
        <tr>
          <th style="text-align:left"><h1>CS 340 Final Project</h1><br><span id="headLine">VIEW, FILTER AND ADD PATIENTS</th>
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
            <th>First Name</th>
            <th>Last Name</th>
            <th>Birthdate</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php
            if(!($stmt = $mysqli->prepare("SELECT * FROM patients"))){
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
     </section> 

    <section>
      <h2>Add Patients</h2>
      <form action="addPatient.php" method="post">
        <fieldset>
        <legend>Patient Information</legend>
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
            <td>Birthdate</td>
            <td><input type="text" name="dateOfBirth" id="datepicker" placeholder="Click to Select Birthdate">
            </td>
          </tr>
          <tr>
            <td colspan="2"><input type="submit" value="Add Patient"></td>
          </tr>
        </table>
        </fieldset>
      </form>
    </section>

    <section>
      <h2>Sort Patients</h2>
      <form action="sortPatients.php" method="post">
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


<!-- Load jQuery JS -->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<!-- Load jQuery UI Main JS  -->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script> 
<!--code.runnable.com/UdTuotHbZoQNAABq/adding-a-date-picker-to-an-input-form-field-using-jquery-->
$(document).ready(
  function () {
    $( "#datepicker" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true, //this option for allowing user to select from year range
      yearRange: '1900:2015',
      dateFormat: "yy-mm-dd"
    });
  }
);
</script>
</html>