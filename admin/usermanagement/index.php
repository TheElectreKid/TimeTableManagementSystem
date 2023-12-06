<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}
include("../../dbconfig.php"); // Connects to the MySQL Database

//Receive data from user credentials for display
$sql = "SELECT * FROM usercredentials";
$result = $db->query($sql);
$userlist = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userlist[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        html {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
<div align='right'>
</div>
<header>
    <div style="background-color:#000080; color:#FFFFFF;">
        <p align='center' style="font-size:50px;"></p>
    </div>
</header>

<div align="center">
    <div style="width:1000px; height:1000px; border: solid 2px #000080;" align="left">
        <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
            <p style="font-size:x-large; margin: 10px;">User Management</p>
            <a href="../index.php"><button> Back to Main Dashboard </button></a>
            <a href="registeruser.php"><button> Registration </button></a>
        </div>

        <table width='999' align='center'">
            <tr>
                <h2 align = 'center'> User List </h2>
            </tr>
            <tr> 
                <th width='10%'> User ID </th>
                <th> Username </th>
                <th> PWD </th>
                <th> User Type </th>
            </tr>
            <tr rowspan="2" style='border: solid 1px #000080'>
                <?php
                foreach ($userlist as $users) {
                    echo "<table width='100%'>";
                    echo "<tr>";
                    echo "<td width='10%' style = 'border: solid 1px #000080;'>{$users['user_id']}</td>";
                    echo "<td width='33%' style = 'border: solid 1px #000080;'>{$users['user_name']}</td>";
                    echo "<td width='33%' style = 'border: solid 1px #000080;'>{$users['pwd']}</td>";
                    echo "<td width='33%' style = 'border: solid 1px #000080;'>{$users['user_type']}</td>";


                    echo "</tr>";
                    echo "</table>";
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
