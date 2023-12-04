<?php
session_start();

// Check if the user is logged in and has the correct usertype (sysadmin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../../dbconfig.php"); // Connects to the MySQL Database
include("../globalsorter.php"); // Sorter for consistent deletion and insertion to the database

// Fetch timetable ID from the URL parameter
$ttableIDToDelete = isset($_GET['ttable_id']) ? intval($_GET['ttable_id']) : null;

if ($ttableIDToDelete !== null) {
    // Step 1: Check if the timetable exists
    $sqlCheckTimetable = "SELECT * FROM timetableid WHERE ttable_id = $ttableIDToDelete";
    $resultCheckTimetable = $db->query($sqlCheckTimetable);

    if ($resultCheckTimetable->num_rows > 0) {
        // Step 2: Delete the timetable from timetableid
        $sqlDeleteTimetable = "DELETE FROM timetableid WHERE ttable_id = $ttableIDToDelete";
        $resultDeleteTimetable = $db->query($sqlDeleteTimetable);

        if (!$resultDeleteTimetable) {
            // Handle the case where deletion from timetableid failed
            die("Error deleting timetable: " . $db->error);
        }

        // Step 3: Drop the corresponding table if it exists
        $sqlDropTable = "DROP TABLE IF EXISTS table_$ttableIDToDelete";
        $resultDropTable = $dbtables->query($sqlDropTable);

        if (!$resultDropTable) {
            // Handle the case where dropping the table failed
            die("Error dropping table: " . $dbtables->error);
        }

        // Step 4: Redirect to index.php or any other page
        header('Location: index.php');
        exit();
    } else {
        // Handle the case where the timetable does not exist
        die("Timetable not found");
    }
} else {
    // Handle the case where ttable_id is not provided in the URL
    die("Timetable ID not provided");
}
?>
