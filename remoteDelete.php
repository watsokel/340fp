<?php
/* Error Reporting */
error_reporting(E_ALL);
ini_set('display_errors',1);

/* PHP script deletes all expired foods from the database.  Normally this would be
scheduled from a serverside event scheduler, but OregonState servers do not allow us
to schedule events.  This work around would allow us to remotely access the database
with a local scheduler. */

$scriptpw = "twinkies";

/* Credentials */
include 'dbpass.php';

/* Connect to database */
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

/* Password to run Query is passed by Get header */
if (isset($_GET['pw'])) {
    if ($_GET['pw'] === $scriptpw) {
        deleteExpired($mysqli);
    }
}


/************
* Functions *
************/
function matchUserToEvent($db) {
	//check that username matches to eventId
	if (!($stmt = $db->prepare("DELETE FROM food_items_available WHERE eat_by < CURDATE()"))) {
			printError("Prepare failed: (" . $db->errno . ") " . $db->error);
			return;
	}
    
	$stmt->execute();
	$stmt->close();
    
    echo "Performed SQL Query 'DELETE FROM food_items_available WHERE eat_by < CURDATE()'";
}


?>