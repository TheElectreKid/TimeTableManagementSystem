<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

// SQL Connection
include("../dbconfig.php"); 
function findMissingID($db, $tableName, $IDColumn) {
    $sql = "SELECT $IDColumn FROM $tableName ORDER BY $IDColumn ASC";
    $result = $db->query($sql);

    $IDs = array();
    while ($row = $result->fetch_assoc()) {
        $IDs[] = $row[$IDColumn];
    }

    $IDmissing = null;
    $expectedID = 1;

    foreach ($IDs as $ID) {
        if ($ID != $expectedID) {
            $IDmissing = $expectedID;
            break;
        }

        $expectedID++;
    }

    if ($IDmissing === null) {
        $IDmissing = $expectedID;
    }

    return $IDmissing;
}

// Fetch teachers, subjects, and class times for dropdowns
$sql2 = "SELECT teacher_id, firstname FROM teachers";
$result2 = $db->query($sql2);
$teachers = [];
if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $teachers[] = $row2;
    }
}

$sql3 = "SELECT subject_id, subject_name FROM subjects";
$result3 = $db->query($sql3);
$subjects = [];
if ($result3->num_rows > 0) {
    while ($row3 = $result3->fetch_assoc()) {
        $subjects[] = $row3;
    }
}

$sql4 = "SELECT time_id, classtime, endtime FROM datetimes";
$result4 = $db->query($sql4);
$classtimes = [];
if ($result4->num_rows > 0) {
    while ($row4 = $result4->fetch_assoc()) {
        $classtimes[] = $row4;
    }
}
//

// Handle form submission to create a new class
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $classname = $_POST['classname'];
    $teacher_id = $_POST['teacher_id'];
    $time_id = $_POST['time_id'];
    $subject_id = $_POST['subject_id'];

    // Find the missing class ID
    $tableName = 'class'; // The name of the table for classes
    $IDColumn = 'class_id'; // The name of the ID column for classes
    $missingClassID = findMissingID($db, $tableName, $IDColumn);

    if ($missingClassID !== null) {
        // Use the missingClassID for the new class
        $classID = $missingClassID;
    } else {
        // If no missing ID was found, use the next available ID
        $classID = $missingClassID + 1;
    }

    // Insert the new class into the database
    $insert_sql = "INSERT INTO class (class_id, classname, teacher_id, time_id, subject_id) VALUES ($classID, '$classname', $teacher_id, $time_id, $subject_id)";
    if ($db->query($insert_sql)) {
        // Redirect to a page after successful class creation
        header("Location: manageclass.php");
        exit();
    } else {
        echo "Error creating class: " . $db->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
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
    <div style="width:1000px; height:500px; border: solid 2px #000080;" align="left">
        <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
            <p style="font-size:x-large; margin: 10px;">Create Class</p>
            <a href="manageclass.php" align='left'><button>Back</button></a>
        </div>

        <!-- Form for creating a new class -->
        <form method="POST">
            <table width='999' align='center'>
                <tr>
                    <td>
                        Class Name: <input type="text" name="classname" required>
                    </td>
                    <td>
                        Teacher:
                        <select name="teacher_id" required>
                            <?php
                            //Display for the interface
                            foreach ($teachers as $teacher) {
                                echo "<option value='" . $teacher['teacher_id'] . "'>" . $teacher['firstname'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        Subject:
                        <select name="subject_id" required>
                            <?php
                            foreach ($subjects as $subject) {
                                echo "<option value='" . $subject['subject_id'] . "'>" . $subject['subject_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        Class Time:
                        <select name="time_id" required>
                            <?php
                            foreach ($classtimes as $classtime) {
                                echo "<option value='" . $classtime['time_id'] . "'>" . $classtime['classtime'] . " - " . $classtime['endtime'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
                <button type="submit" name="create">Create</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
