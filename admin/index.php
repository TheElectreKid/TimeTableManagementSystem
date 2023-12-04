<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <style>
        html {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>

<script>
function confirmLogout() {
    var confirmLogout = confirm("Are you sure you want to logout?");
    if (confirmLogout) {
        // If the user confirms, proceed with the logout
        window.location.href = "../logout.php"; // Add a query parameter to indicate the logout action
    }
}
</script>

<header>
    <div style="background-color:#000080; color:#FFFFFF;">
        <p align='center' style="font-size:50px;"></p>
    </div>
</header>

<div align="center">
    <div style="width:1000px; height:500px; border: solid 2px #000080;" align="left">
        <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
            <p style = "font-size:x-large; margin: 10px;">Admin Dashboard <button onclick="confirmLogout()">Logout</button></p>
            <a href="../admin/ttablemanagement/index.php"><button>Manage Timetables</button></a>
            <a href="managesubject.php"><button>Manage Subjects</button></a>
            <a href="manageclass.php"><button> Manage Classes </button></a> 
            <a href="manageschedule.php"><button> Manage Schedules</button></a>
            <a href="../admin/usermanagement/index.php"><button> Manage Users</button></a>
            <a href="managestudent.php"><button> Manage Students</button></a>
            <a href="manageteachers.php"><button> Manage Teachers</button></a>
        </div>
    <table>
        <!--  Table Display--->
    








    </table>

    </div>
</div>
<!-- Table Display --> 

<footer style="text-align: center;">
    &copy; 2023 All Rights Reserved
</footer>

</body>
</html>
