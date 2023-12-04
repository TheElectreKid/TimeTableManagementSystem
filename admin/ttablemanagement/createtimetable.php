<?php
session_start();

// Check if the user is logged in and has the correct usertype (sysadmin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../../dbconfig.php"); // Connects to the MySQL Database
include("../globalsorter.php"); // Sorter for consistent deletion and insertion to the database


// Step 1: Check timetableid for the missing id
$tablename = 'timetableid';
$IDColumn = 'ttable_id';
$missingTTableID = findMissingID($db, $tablename, $IDColumn);

if ($missingTTableID !== null) {
    $ttableID = $missingTTableID;
} else {
    $ttableID = $missingTTableID + 1;
}

// Step 2: Insert into timetableid 
$sqlInsert = "INSERT INTO timetableid (ttable_id) VALUES ($ttableID)";
$resultInsert = $db->query($sqlInsert);


// Step 3: Create a new empty table in $dbtables (tablename = ttable_id)
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS table_$ttableID (
    class_id INT,
    classname VARCHAR(255),
    teacher_id INT,
    time_id INT,
    subject_id INT
)";

$resultCreateTable = $dbtables->query($sqlCreateTable);

if (!$resultCreateTable) {
    // Handle the case where table creation failed
    die("Error creating table: " . $dbtables->error);
}

// Step 3: Redirect to assignclasses.php
header('Location: index.php');
exit();
?>
