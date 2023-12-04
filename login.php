<?php
session_start(); 
include ('dbconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM usercredentials WHERE user_name = '$username' AND pwd = '$password'";
        $result = $db->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id']; // New line to retrieve user_id

            $usertype = $row['user_type'];

            if ($usertype == 'student') {
                $_SESSION['usertype'] = $usertype;
                $_SESSION['user_id'] = $user_id; // Store user_id in the session
                header("Location: student/index.php");
                exit();
            } elseif ($usertype == 'faculty') {
                $_SESSION['usertype'] = $usertype;
                $_SESSION['user_id'] = $user_id; // Store user_id in the session
                header("Location: faculty/index.php");
                exit();
            } elseif ($usertype == 'sysadmin') {
                $_SESSION['usertype'] = $usertype;
                $_SESSION['user_id'] = $user_id; // Store user_id in the session
                header("Location: admin/index.php");
                exit();
            }
        }
    }
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-container">
        <a href="index.php" class="logo-link">
            <p class="logo-text">Timetable Management System</p>
        </a>
    </div>
</header>

<div class="center-container">            
    <div class="login-container">
        <div class="login-header">
            <b>Welcome Back!</b>
        </div>
        
        <div class="login-content">
            <form action="" method="post">
                <label for="username">Username :</label>
                <input type="text" id="username" name="username" required> <br/><br/>
                <label for="password">Password :</label>
                <input type="password" id="password" name="password" required> <br/><br/>
                <input type="submit" value=" Login "/><br/>
            </form>

            <div class="error-message"></div>
        </div>
    </div>
</div>

<footer>
    <p class="footer-text">2023 All Rights Reserved</p>
</footer>

</body>
</html>
