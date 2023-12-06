<?php
session_start();
// Check if the user is logged in and has the correct usertype (faculty)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'faculty') {
    header('Location: ../login.php');
    exit();
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
    <div style="width:1000px; height:1000px; border: solid 2px #000080;" align="left">
        <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
            <p style = "font-size:x-large; margin: 10px;">Dashboard <button onclick="confirmLogout()">Logout</button></p>
            <a href="timetable.php"><button>Your Schedule</button></a>
        </div>
    </div>
</div>
<!-- Table Display --> 
<table> 
    








</table>

<footer style="text-align: center;">
    &copy; 2023 All Rights Reserved
</footer>

</body>
</html>

