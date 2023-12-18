<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}
include("../../dbconfig.php"); // Connects to the MySQL Database
include ("../globalsorter.php"); // Sorter for consistent deletion and insertion to the database

// Step 1: Receiving and assigning the user data to variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $usertype = $_POST['usertype'];

    if (!empty($username) && !empty($password) && !empty($firstname) && !empty($lastname)  && !empty($gender)) {
        if ($usertype == 'student') {

            // INSERT INTO USER CREDENTIALS
            $tableName = "usercredentials";
            $IDColumn = "user_id";
            $missingID = findMissingID($db, $tableName, $IDColumn);
            $userid = $missingID;
            $sql2 = "INSERT INTO usercredentials (user_id, user_name, pwd, user_type)
            VALUES ($userid, '$username', '$password', '$usertype')";
            $result = $db->query($sql2);

            //INSERT INTO STUDENT TABLE
            $tableName = "students";
            $IDColumn = "stud_id";
            $missingID = findMissingID($db, $tableName, $IDColumn);
            $sql3 = "INSERT INTO students (stud_id, firstname, lastname, gender, user_id, ttable_id)
            VALUES ($missingID, '$firstname', '$lastname', '$gender', '$userid', NULL)";
            $result = $db->query($sql3);
            
            if (!$result) {
                echo "Error: " . $db->error;
            }
            header("Location: {$_SERVER['PHP_SELF']}");
            echo "Registered Successfully!";
        }

        else if ($usertype == 'faculty') {

            // INSERT INTO USER CREDENTIALS
            $tableName = "usercredentials";
            $IDColumn = "user_id";
            $missingID = findMissingID($db, $tableName, $IDColumn);
            $userid = $missingID;
            $sql2 = "INSERT INTO usercredentials (user_id, user_name, pwd, user_type)
            VALUES ($userid, '$username', '$password', '$usertype')";
            $result = $db->query($sql2);

            //INSERT INTO TEACHER TABLE
            $tableName = "teachers";
            $IDColumn = "teacher_id";
            $missingID = findMissingID($db, $tableName, $IDColumn);
            $sql3 = "INSERT INTO teachers (teacher_id, firstname, lastname, gender, user_id, ttable_id)
            VALUES ($missingID, '$firstname', '$lastname', '$gender', '$userid', NULL)";
            $result = $db->query($sql3);

            if (!$result) {
                echo "Error: " . $db->error;
            }
            header("Location: {$_SERVER['PHP_SELF']}");
            echo "Registered Successfully!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>
<header>
    <div style="background-color:#000080; color:#FFFFFF;">
        <p align='center' style="font-size:50px;"></p>
    </div>
</header>

<div align="center" class="nav">
    <div class="navbar">
        <p style="font-size:x-large; margin: 10px;">User Registration</p>
        <a href="index.php" align='left'>Back</a>
    </div>

    <table width='999' align='center'>
        <tr>
            <th>
                Registration
            </th>
        </tr>

        <tr>
            <td align = 'center'>
                <form action="" method="post">
                    <table align='center'>
                        <tr>
                            <td>
                                <label for="username">Username:</label>
                            </td>
                            <td>
                                <input type="text" id="username" name="username" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">Password:</label>
                            </td>
                            <td>
                                <input type="password" id="password" name="password" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="firstname">First Name:</label>
                            </td>
                            <td>
                                <input type="text" id="firstname" name="firstname" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="lastname">Last Name:</label>
                            </td>
                            <td>
                                <input type="text" id="lastname" name="lastname" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="gender">Gender:</label>
                            </td>
                            <td>
                                <input type="text" id="gender" name="gender" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="usertype">Usertype:</label>
                            </td>
                            <td>
                                <input type="radio" id="student" name="usertype" value="student">
                                <label for="student">Student</label>
                                <input type="radio" id="faculty" name="usertype" value="faculty">
                                <label for="faculty">Faculty/Teacher</label>
                                
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type="submit" value="Register User">
                </form>
            </td>
        </tr>
    </table>
    </div>
</div>

<footer style="text-align: center;">
    2023 All Rights Reserved
</footer>
</body>
</html>
