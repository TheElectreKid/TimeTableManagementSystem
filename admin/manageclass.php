<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../dbconfig.php");

// Fetch classes, and from other tables from the database for display using LEFT JOIN
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

//Receive the class_id to be edited from the URL
if (isset($_GET["edit_class"])) {
    $classIdToEdit = $_GET["edit_class"];
    $sql3 = "SELECT * FROM class WHERE class_id = $classIdToEdit";
    $db->query($sql3);
    header("Location:editclass.php?class_id=$classIdToEdit");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<header>
    <div style="background-color:#000080; color:#FFFFFF;">
        <p align='center' style="font-size:50px;"></p>
    </div>
</header>

<div align="center" class="nav">
    <div class="navbar">  
        <p style="font-size:x-large; margin: 10px;">Manage Classes: </p>
        <a href="index.php" align='left'>Back</a>
        <a href="createclass.php">Create Class</a>
    </div>
    <table align='center'>
        <tr height='25'>
            <th> Class ID </th>
            <th> Class Name </th>
            <th> Teacher </th>
            <th> Class Time </th>
            <th> End Time </th>
            <th> Subject </th>
            <th> Action </th>
        </tr>

        <tr>
            <?php
            //Display
            foreach ($classes as $class) {
                echo "<tr>";
                echo "<td height='25' width='100' align='center' style='border: solid 1px #000080;'>{$class['class_id']}</td>";
                echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$class['classname']}</td>";
                echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$class['teacher_name']}</td>";
                echo "<td style='border: solid 1px #000080;' width='100' align='center'>" . date("h:i A", strtotime($class['class_time'])) . "</td>";
                echo "<td style='border: solid 1px #000080;' width='100' align='center'>" . date("h:i A", strtotime($class['end_time'])) . "</td>";
                echo "<td style='border: solid 1px #000080;' width='200' align='center'>{$class['subject_name']}</td>";
                echo "<td align='center' style = 'border: solid 1px #000080;' width = '100'><a href='?edit_class={$class['class_id']}'>Edit</a></td>";
                echo "</tr>";
            }
            ?>
        </tr>
    </table>
</div>

<footer style="text-align: center;">
    &copy; 2023 All Rights Reserved
</footer>

</body>
</html>
