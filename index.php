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
  </head>
  <body>
    <header>
      <table width="100%">
        <tr>
          <th style="text-align:left"><h1>CS 340 Final Project</h1><br><span style="color:blue">View and Filter Appointments</span></th>
          <td valign="top">Programmed by <strong>Kelvin Watson</strong><br>OSU ID: 932540242<br>ONID ID: watsokel</td>
        </tr>

      </table>
    </header>
    
    <nav>
      <table border="0" width="100%"><caption><h3>Choose an Action</h3></caption>
        <tr>
          <td><a href="index.php">View, Filter and Add Appointments</a></td>
          <td>View and Filter Patients</td>
          <td><a href="assistants.php">View, Sort and Add Medical Office Assistants</a></td>
          <td><a href="providers.php">View, Filter and Add Healthcare Providers</a></td>
          <td><a href="conditions.php">View, Filter and Add Medical Conditions</a></td>
          <td>View, Filter and Add  Medications</td>
        </tr>
      </table>
    </nav>
    
    <hr>

    <section>
      <table border="1"><caption>Appointments</caption>
        <thead>
          <tr>
            <th>Patient Last Name</th>
            <th>Patient First Name</th>
            <th>Appointment Date</th>
            <th>Healthcare Provider</th>
            <th>Reason for Appointment</th>
            <th>Scheduled By (Medical Office Assistant)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>table data</td>
            <td>more table data</td>
            <td>more table data</td>
            <td>more table data</td>
            <td>more table data</td>
            <td>more table data</td>
          </tr>
        </tbody>
      </table>
     </section> 

    <section>
      <h2>Manage Patient Appointments</h2>
      <form action="process.php" method="post">
        <fieldset>
        <legend>Patient Demographics</legend>
        <table>
          <tr>
            <td colspan="2">Patient's Name</td>
          </tr>
          <tr>
              <td><label for="fname">First Name</label></td>
              <td><input type="text" name="firstname" id="fname"></td>
          </tr>
          <tr>
            <td><label for="lname">Last Name</label></td>
            <td><input type="text" name="lastname" id="lname"></td>
          </tr>
          <tr>
            <td><label for="dob">Birth Date</label></td>
            <td><input type="text" name="birthDate" id="dob" placeholder="dd/mm/yyyy"></td>
            <!--PHP REGEX http://stackoverflow.com/questions/15491894/regex-to-validate-date-format-dd-mm-yyyy-->
          </tr>
        </table>
        </fieldset>

        <fieldset>
          <legend>Apointment Date</legend>
        </fieldset>
      </form>
    </section>
    
    <footer><em>Kelvin Watson, OSU ID 932540242, CS340 Final Project</em></footer>

  </body>
</html>