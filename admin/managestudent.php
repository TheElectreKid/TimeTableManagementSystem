<?php
    session_start();
    // Check if the user is logged in and has the correct usertype (admin)
    if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
        header('Location: ../login.php');
        exit();
    }
    include ("../dbconfig.php");
// Fetch student list from the database for display

$sql = "SELECT * FROM students";
$result = $db->query($sql);
$students = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

if (isset($_GET["edit_student"])) {
    $studIdToEdit = $_GET["edit_student"];
    $sql = "SELECT * FROM students WHERE stud_id = $studIdToEdit";
    $db->query($sql);
    header("Location:editstudent.php?stud_id=$studIdToEdit");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
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
    <!-- Stuff inside the box header -->
    <div style="width:1000px; height:1000px; border: solid 2px #000080;" align="left">
    
        <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
            <p style="font-size:x-large; margin: 10px;">Manage Students</p>
            <a href="index.php" align = 'left'><button>Back</button></a>
        </div>

    
    <table width='999'>
        <tr height = '25'>
            <th> User ID </th>
            <th> Student ID </th>
            <th> First Name </th>
            <th> Last Name </th>
            <th> Gender </th>
            <th> Action </th>
        </tr>
        <tr>
            <?php
                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td height = '25' width = '100' align = 'center' style = 'border: solid 1px #000080;'> {$student['user_id']}</td>";
                    echo "<td height = '25' width = '100' align = 'center' style = 'border: solid 1px #000080;'> {$student['stud_id']}</td>";
                    echo "<td style = 'border: solid 1px #000080;' width = '200' align = 'center'> {$student['firstname']}</td>";
                    echo "<td style = 'border: solid 1px #000080;' width = '200' align = 'center'> {$student['lastname']}</td>";
                    echo "<td height = '25' width = '100' align = 'center' style = 'border: solid 1px #000080;'> {$student['gender']}</td>";
                    echo "<td align='center' style = 'border: solid 1px #000080;' width = '100'><a href='?edit_student={$student['stud_id']}'>Edit</a></td>";
                    echo "</tr>";
                }

            ?>
        </tr>
    </table>
    </div>
</div>

<footer style="text-align: center;">
    &copy; 2023 All Rights Reserved
</footer>

</body>
</html>