<?php

session_start();

// Check if the user is logged in and has the correct usertype (sysadmin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../../dbconfig.php"); // Connects to the MySQL Database
include("../globalsorter.php"); // Sorter for consistent deletion and insertion to the database

$classIdToAdd = $_GET['class_id'];
$TimetableIdToInsert = $_GET['ttable_id'];

// Select the row from class where the class_id=$classIdToAdd
$sql = "SELECT * FROM class WHERE class_id = $classIdToAdd";
$result = $db->query($sql);

// Check if the class exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Insert the row into table_$TimetableIdtoInsert
    $sql2 = "INSERT INTO table_$TimetableIdToInsert (class_id, classname, teacher_id, time_id, subject_id)
             VALUES ('$row[class_id]', '$row[classname]', '$row[teacher_id]', '$row[time_id]', '$row[subject_id]')";
    $dbtables->query($sql2);
    header("Location: edittimetable.php?ttable_id=$TimetableIdToInsert");
} else {
    // Handle the case where the class doesn't exist
    echo "Class not found.";
}

?>
