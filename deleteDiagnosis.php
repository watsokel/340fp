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
    <title>Delete Diagnosis</title>
  </head>
  <body>

<?php
if(!isset($_POST['selectPatient']) || empty($_POST['selectPatient']) || ("" == trim($_POST['selectPatient']))) {
  echo "Unable to delete diagnosis. You must select a patient.<br>";
} else {
  echo '<table border="1" id="databaseData"><caption><h2>Diagnoses</h2></caption>
        <thead>
          <tr>
            <th>Patient First Name</th>
            <th>Patient Last Name</th>
            <th>Medical Conditions</th>
          </tr>
        </thead>
        <tbody>';
          if(!($stmt = $mysqli->prepare("SELECT " . "pt.pID, pt.first_name,pt.last_name,mc.name 
          FROM patients pt
          LEFT JOIN diagnosed di ON pID = patient_ID 
          LEFT JOIN medical_conditions mc ON mc.name = diagnosis WHERE pID=$_POST[selectPatient]"))){
            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }

          if(!$stmt->execute()){
            echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          if(!$stmt->bind_result($patientID, $firstName, $lastName, $condition)){
            echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
          }
          while($stmt->fetch()){
           echo "<tr><td>" .$firstName. "</td><td>" .$lastName. "</td><td>" .$condition. "</td></tr>";
          }
          $stmt->close();
          echo '
        </tbody>
      </table>';
}
?>


    <section>
      <h2>Delete Diagnosis</h2>
      <form action="deleteDiagnosis2.php" method="post">
        <fieldset>
        <legend>Delete Medical Condition from this patient</legend>
        <table>
          <tr>
            <td><label for="selectCondition">Medical Condition</label></td>
            <td><select name="selectCondition" id="selectCondition" required>
            <option selected="true" disabled="disabled"></option>
            <?php
            if(!($stmt = $mysqli->prepare("SELECT " . "mc.name 
            FROM patients pt
            LEFT JOIN diagnosed di ON pID = patient_ID 
            LEFT JOIN medical_conditions mc ON mc.name = diagnosis WHERE pID=$_POST[selectPatient]"))){
              echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
              echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            if(!$stmt->bind_result($condition)){
              echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
            }
            while($stmt->fetch()){
              echo "<option value=\"$condition\">$condition</option>";
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
            <td><input type="submit" value="Delete Condition from this patient"></td>
          </tr> 
        </table>
        </fieldset>
      </form>
    </section>

  Cancel and return to <a href="diagnosis.php">Diagnosis</a> page
  </body>
</html>