<?php
session_start();

// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../dbconfig.php");
include("globalsorter.php");

// Fetch schedules from the database for display
$sql = "SELECT * FROM datetimes";
$result = $db->query($sql);
$schedules = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
}

// Adds Schedule to the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classtime = $_POST["classtime"];
    $endtime = $_POST["endtime"];

    if (!empty($classtime) && !empty($endtime)) {
        $tableName = "datetimes";
        $IDColumn = "time_id";
        $missingID = findMissingID($db, $tableName, $IDColumn);
        
        // Insertion of time data into the datetimes table
        $sql = "INSERT INTO datetimes (time_id, classtime, endtime) VALUES ($missingID, '$classtime', '$endtime')";
        $result = $db->query($sql);

        if ($result) {
            echo "Schedule added successfully.";
            header("Location: {$_SERVER['PHP_SELF']}");
        } else {
            echo "Error: " . $db->error;
        }
    }
}

//Delete schedule
if (isset($_GET["delete_schedule"])) {
    $timeIdToDelete = $_GET["delete_schedule"];
    // Construct SQL Query to delete the schedule
    $sql = "DELETE FROM datetimes WHERE time_id = $timeIdToDelete";
    $db->query($sql);
    header("Location: {$_SERVER['PHP_SELF']}");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedules</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<header>
    <div style="background-color:#000080; color:#FFFFFF;">
        <p align='center' style="font-size:50px;"></p>
    </div>
</header>

<div align="center" class="nav">
    <div class="navbar">
        <p style="font-size:x-large; margin: 10px;">Manage Schedules:</p>
        <a href="index.php" align='left'>Back</a>
        <form action="" method="post" style="margin-top: 14px; padding-left: 7px;">
            <label>Class Time: </label>
            <input type="time" id="classtime" name="classtime" required>
            <label>End Time: </label>
            <input type="time" id="endtime" name="endtime" required>
            <input type="submit" value="Add">
        </form>
    </div>
        <table align='center'>
            <tr height='25'>
                <th>Time ID</th>
                <th align='left'>Class Time</th>
                <th align='left'>End Time</th>
                <th>Action</th>
            </tr>
            <tr>
                <?php
                foreach ($schedules as $schedule) {
                    echo "<tr>";
                    echo "<td height='25' width='60' align='center' style='border: solid 1px #000080;'>{$schedule['time_id']}</td>";
                    // Format the time to 12-hour format
                    $formattedClassTime = date("h:i A", strtotime($schedule['classtime']));
                    $formattedEndTime = date("h:i A", strtotime($schedule['endtime']));
                    echo "<td style='border: solid 1px #000080;'>{$formattedClassTime}</td>";
                    echo "<td style='border: solid 1px #000080;'>{$formattedEndTime}</td>";
                    echo "<td align='center' style='border: solid 1px #000080;' width='100'><button><a href='?delete_schedule={$schedule['time_id']}'>Delete</a></button></td>";
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
