<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}
    include ("../dbconfig.php");
    
$sql = "SELECT * FROM teachers";
$result = $db->query($sql);
$teachers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
}

if (isset($_GET["edit_teacher"])) {
    $teacherIdToEdit = $_GET["edit_teacher"];
    $sql = "SELECT * FROM teacher WHERE teacher_id = $teacherIdToEdit";
    $db->query($sql);
    header("Location:editteacher.php?teacher_id=$teacherIdToEdit");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
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
            <p style="font-size:x-large; margin: 10px;">Manage Teachers</p>
            <a href="index.php" align = 'left'><button>Back</button></a>
        </div>

    
    <table width='999'>
        <tr height = '25'>
            <th> User ID </th>
            <th> Teacher ID </th>
            <th> First Name </th>
            <th> Last Name </th>
            <th> Gender </th>
            <th> Action </th>
        </tr>
        <tr>
            <?php
                foreach ($teachers as $teacher) {
                    echo "<tr>";
                    echo "<td height = '25' width = '100' align = 'center' style = 'border: solid 1px #000080;'> {$teacher['user_id']}</td>";
                    echo "<td height = '25' width = '100' align = 'center' style = 'border: solid 1px #000080;'> {$teacher['teacher_id']}</td>";
                    echo "<td style = 'border: solid 1px #000080;' width = '200' align = 'center'> {$teacher['firstname']}</td>";
                    echo "<td style = 'border: solid 1px #000080;' width = '200' align = 'center'> {$teacher['lastname']}</td>";
                    echo "<td height = '25' width = '100' align = 'center' style = 'border: solid 1px #000080;'> {$teacher['gender']}</td>";
                    echo "<td align='center' style = 'border: solid 1px #000080;' width = '100'><a href='?edit_teacher={$teacher['teacher_id']}'>Edit</a></td>";
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