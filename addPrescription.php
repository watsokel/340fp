<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Add Prescription</title>
  </head>
  <body>

<?php
if(!isset($_POST['selectPatient']) || empty($_POST['selectPatient']) || ("" == trim($_POST['selectPatient']))) {
  echo "Unable to add prescription. You must select a patient.<br>";
} else {
  echo '<table border="1" id="databaseData"><caption><h2>Current Prescriptions for this Patient</h2></caption>
        <thead>
          <tr>
            <th>Patient First Name</th>
            <th>Patient Last Name</th>
            <th>Current Medications</th>
          </tr>
        </thead>
        <tbody>';
          if(!($stmt = $mysqli->prepare("SELECT " . "pt.pID,pt.first_name,pt.last_name,me.name 
            FROM patients pt
            LEFT JOIN takes ta ON pID = patient_ID 
            LEFT JOIN medications me ON me.name = drug_name WHERE pID=$_POST[selectPatient]"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }

          if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          if(!$stmt->bind_result($patientID, $firstName, $lastName, $drug)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          while($stmt->fetch()){
           echo "<tr><td>" .$firstName. "</td><td>" .$lastName. "</td><td>" .$drug. "</td></tr>";
          }
          $stmt->close();
          echo '
        </tbody>
      </table>';
}
?>

    <section>
      <h2>Add Prescription</h2>
      <form action="addPrescription2.php" method="post">
        <fieldset>
        <legend>Add Medication for this patient</legend>
        <table>
          <tr>
            <td><label for="selectDrug">Medication</label></td>
            <td><select name="selectDrug" id="selectDrug" required>
            <option selected="true" disabled="disabled"></option>
            <?php
            if(!($stmt = $mysqli->prepare("SELECT name FROM medications"))){
              echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
              echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if(!$stmt->bind_result($drug)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt->fetch()){
              echo "<option value=\"$drug\">$drug</option>";
            }
            $stmt->close();
            ?>
            </select>
            </td>
          </tr>
          <tr>
            <td><input type="hidden" name="patientID" value=<?php echo "$patientID"?>></td>
          </tr>
          <tr>
            <td><input type="submit" value="Add Medication to this Patient"></td>
          </tr> 
        </table>
        </fieldset>
      </form>
    </section>

  Cancel and return to <a href="prescription.php">Takes (Prescription)</a> page
  </body>
</html>