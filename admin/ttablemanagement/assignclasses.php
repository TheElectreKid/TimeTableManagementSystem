<?php
session_start();

// Check if the user is logged in and has the correct usertype (sysadmin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../../dbconfig.php"); // Connects to the MySQL Database
include("../globalsorter.php"); // Sorter for consistent deletion and insertion to the database

$ttableIDToAdd = isset($_GET['ttable_id']) ? intval($_GET['ttable_id']) : null;
$ttableIDToInsertInto = $_GET['ttable_id'];

// Receives 'class' from group2db and stores it as an array
$sql = "SELECT c.*, t.firstname AS teacher_name, d.classtime AS class_time, d.endtime AS end_time, s.subject_name
        FROM class AS c
        LEFT JOIN teachers AS t ON c.teacher_id = t.teacher_id
        LEFT JOIN datetimes AS d ON c.time_id = d.time_id
        LEFT JOIN subjects AS s ON c.subject_id = s.subject_id";

$result = $db->query($sql);
$classes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
}

//Receives Class to Add from form then sends it to addclass.php along with the timetable id for timetable insertion
if (isset($_GET["add_class"])) {
    $classIdToAdd = $_GET["add_class"]; 
    $sql2 = "SELECT * FROM class WHERE class_id = $classIdToAdd";
    $result2 = $db->query($sql2);
    
    if ($result2->num_rows > 0) {
        header("Location: addclass.php?class_id=$classIdToAdd&ttable_id=$ttableIDToInsertInto");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        html {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>

<script>
    function goBack() {
      window.history.back();
    }
</script>

<header>
    <div style="background-color:#000080; color:#FFFFFF;">
        <p align='center' style="font-size:50px;"></p>
    </div>
</header>

<div align="center">
    <div style="width:1000px; height:1000px; border: solid 2px #000080;" align="left">
        <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
            <p style="font-size:x-large; margin: 10px;">Add Classes </p>
            <button onclick="goBack()">Back</button>
        </div>
        <!-- Display classes in a table -->
        <table align='center'>
            <tr>
                <th>Class ID</th>
                <th>Class Name</th>
                <th>Teacher ID</th>
                <th>Class Time</th>
                <th>End Time</th>
                <th>Subject </th>
                <th>Action </th>
            </tr>
            <?php
            foreach ($classes as $class) {
                echo "<tr>";
                echo "<td height='25' width='100' align='center' style='border: solid 1px #000080;'>{$class['class_id']}</td>";
                echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$class['classname']}</td>";
                echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$class['teacher_name']}</td>";
                echo "<td style='border: solid 1px #000080;' width='100' align='center'>" . date("h:i A", strtotime($class['class_time'])) . "</td>";
                echo "<td style='border: solid 1px #000080;' width='100' align='center'>" . date("h:i A", strtotime($class['end_time'])) . "</td>";
                echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$class['subject_name']}</td>";
                echo "<td align='center' style='border: solid 1px #000080;' width='100'><a href='?add_class={$class['class_id']}&ttable_id={$ttableIDToInsertInto}'>Add</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

<footer style="text-align: center;">
    &copy; 2023 All Rights Reserved
</footer>

</body>
</html>
