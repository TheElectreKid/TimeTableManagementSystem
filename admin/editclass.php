<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../dbconfig.php"); // SQL Connection

// Retrieve class id from the URL
if(isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    // Fetch class details
    $sql = "SELECT * FROM class WHERE class_id = $class_id";
    $result = $db->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $classid = $row['class_id'];
        $classname = $row['classname'];
        $teacherid = $row['teacher_id'];
        $timeid = $row['time_id'];
        $subjectid = $row['subject_id'];
    } else {
        echo "Error fetching class details.";
        exit();
    }
} else {
    echo "Class ID not provided in the URL.";
    exit(); 
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

// Handle form submission to update class details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_classname = $_POST['classname'];
    $new_teacherid = $_POST['teacher_id'];
    $new_timeid = $_POST['time_id'];
    $new_subjectid = $_POST['subject_id'];

    // Update the database
    $update_sql = "UPDATE class SET classname = '$new_classname', teacher_id = $new_teacherid, time_id = $new_timeid, subject_id = $new_subjectid WHERE class_id = $class_id";
    if ($db->query($update_sql)) {
        // Redirect back to the same page after a successful update
        header("Location: editclass.php?class_id=$classid");
        exit();
    } else {
        echo "Error updating class details: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
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
            <p style="font-size:x-large; margin: 10px;">Edit Class</p>
            <a href="manageclass.php" align='left'><button>Back</button></a>
        </div>

        <!-- Form for editing class details -->
        <form method="POST">
            <table width='999' align='center'>
                <tr>
                    <td>
                        Class Name: <input type="text" name="classname" value="<?php echo $classname; ?>">
                    </td>
                    <td>
                        Teacher:
                        <select name="teacher_id">
                            <?php
                            foreach ($teachers as $teacher) {
                                $selected = ($teacher['teacher_id'] == $teacherid) ? 'selected' : '';
                                echo "<option value='" . $teacher['teacher_id'] . "' $selected>" . $teacher['firstname'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        Subject:
                        <select name="subject_id">
                            <?php
                            foreach ($subjects as $subject) {
                                $selected = ($subject['subject_id'] == $subjectid) ? 'selected' : '';
                                echo "<option value='" . $subject['subject_id'] . "' $selected>" . $subject['subject_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        Class Time:
                        <select name="time_id">
                            <?php
                            foreach ($classtimes as $classtime) {
                                $selected = ($classtime['time_id'] == $timeid) ? 'selected' : '';
                                
                                // Format the time in 12-hour format
                                $start_time = date('h:i A', strtotime($classtime['classtime']));
                                $end_time = date('h:i A', strtotime($classtime['endtime']));

                                echo "<option value='" . $classtime['time_id'] . "' $selected>" . $start_time . " - " . $end_time . "</option>";
                            }
                            ?>
                        </select>
                    </td>


            <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
                <button type="submit">Apply</button>
            </div>
        </form>
            
        <td>
            <form method="POST" action="deleteclass.php">
                <input type="hidden" name="class_id" value="<?php echo $classid; ?>">
                <button type="submit" name="delete_class">Delete</button>
            </form>
        </td>
            </table>

    </div>
</div>

</body>
</html>
