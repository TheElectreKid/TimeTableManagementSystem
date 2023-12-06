<?php
session_start();

// Check if the user is logged in and has the correct usertype (sysadmin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../../dbconfig.php"); // Connects to the MySQL Database
include("../globalsorter.php"); // Sorter for consistent deletion and insertion to the database

// Check if both timetable ID and class ID are provided
if (isset($_GET['ttable_id']) && isset($_GET['class_id'])) {
    $ttableID = intval($_GET['ttable_id']);
    $classID = intval($_GET['class_id']);

    // Validate the timetable ID (you may want to validate the class ID as well)
    if ($ttableID > 0) {
        // Perform the deletion
        $sqlDeleteClass = "DELETE FROM table_$ttableID WHERE class_id = $classID";
        $resultDeleteClass = $dbtables->query($sqlDeleteClass);

        if (!$resultDeleteClass) {
            // Handle the case where deletion fails
            die("Error deleting class: " . $dbtables->error);
        }

        // Redirect back to the timetable view after deletion
        header("Location: edittimetable.php?ttable_id=$ttableID");
        exit();
    } else {
        // Handle the case where the timetable ID is not valid
        die("Invalid timetable ID");
    }
} else {
    // Handle the case where either timetable ID or class ID is not provided in the URL
    die("Timetable ID or Class ID not provided");
}
?>
