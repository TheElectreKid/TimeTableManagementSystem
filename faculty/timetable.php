<?php
session_start();
// Check if the user is logged in and has the correct usertype (faculty)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'faculty') {
    header('Location: ../login.php');
    exit();
}

include("../dbconfig.php");

// Retrieve teacher's ttable_id
$sql = "SELECT ttable_id FROM teachers WHERE user_id = {$_SESSION['user_id']}";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$tableid = $row['ttable_id'];


// Check if $tableid is 0, display an error message
if ($tableid == 0) {
    
} else {
    // Retrieve timetable information
    $sql2 = "SELECT timetable.*, teachername.firstname, time1.*
             FROM group2dbttables.table_$tableid timetable
             JOIN group2db.teachers teachername ON timetable.teacher_id = teachername.teacher_id
             JOIN group2db.datetimes time1 ON timetable.time_id = time1.time_id";

    $result2 = $db->query($sql2);
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

<header>
    <div style="background-color:#000080; color:#FFFFFF;">
        <p align='center' style="font-size:50px;"></p>
    </div>
</header>

<div align="center">
    <div style="width:1000px; height:1000px; border: solid 2px #000080;" align="left">
        <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
            <p style="font-size:x-large; margin: 10px;">Schedule</p>
            <a href="index.php"><button>Back</button></a>
        </div>

        <?php if ($tableid != 0) { ?>
            <table width='999' align='center'>
                <tr height=''>
                    <th> Class ID </th>
                    <th> Class Name </th>
                    <th> Teacher </th>
                    <th> Class Time </th>
                    <th> End Time </th>
                </tr>

                <!-- Use a while loop to iterate through rows -->
                <?php
                while ($timetable = $result2->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td height='25' width='100' align='center' style='border: solid 1px #000080;'>{$timetable['class_id']}</td>";
                    echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$timetable['classname']}</td>";
                    echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$timetable['firstname']}</td>";

                    // Convert the 24-hour format to 12-hour format for both start and end times
                    $startTime = date("h:i A", strtotime($timetable['classtime']));
                    $endTime = date("h:i A", strtotime($timetable['endtime']));

                    echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$startTime}</td>";
                    echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$endTime}</td>";

                    echo "</tr>";
                }
                ?>

            </table>
        <?php }
         else {
            echo "<p align='center'>No data in your timetable. Contact Administrator</p>";
         }?>

    </div>
</div>

<footer style="text-align: center;">
    &copy; 2023 All Rights Reserved
</footer>

</body>
</html>
