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
    <link rel="stylesheet" href="../css/admin.css">
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
    <div>
        <p align='center' style="font-size:50px;"></p>
    </div>
</header>

<div align="center" class="nav">
        <div class="navbar">
            <p style = "font-size:x-large; margin: 10px;"><?php echo "Welcome {$_SESSION['user_name']}";?> </p>
            <a href="../admin/ttablemanagement/index.php">Manage Timetables</a>
            <a href="managesubject.php">Manage Subjects</a>
            <a href="manageclass.php"> Manage Classes </a> 
            <a href="manageschedule.php"> Manage Schedules</a>
            <a href="../admin/usermanagement/index.php"> Manage Users</a>
            <a href="managestudent.php"> Manage Students</a>
            <a href="manageteachers.php"> Manage Teachers</a>
            <a onclick="confirmLogout()">Logout</a>
        </div>
        <div class="textbox">
            <p id="desc1"> Manage the timetables inside the TImetable System Database</p>
        </div>
</div>

<footer>
    <p class="footer-text">&copy; 2023 All Rights Reserved</p>
</footer>

</body>
</html>
