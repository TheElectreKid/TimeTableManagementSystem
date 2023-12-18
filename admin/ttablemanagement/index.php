<?php
session_start();

// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../../dbconfig.php"); // Connects to the MySQL Database

// Retrieve data from the ttable table
$sql = "SELECT * FROM timetableid";
$result = $db->query($sql);
$timetables = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $timetables[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>

<header>
    <div style="background-color:#000080; color:#FFFFFF;">
        <p align='center' style="font-size:50px;"></p>
    </div>
    <style>html {font-family: Arial, sans-serif;}</style>
</header>

<div align="center" class="nav">
    <div class="navbar">
        <p style="font-size:x-large; margin: 10px;">Timetable Management: </p>
        <a href="../index.php">Back to Main Dashboard</a>
        <a href="createtimetable.php">Create New Timetable</a>
    </div>
    <div>
    <!-- Display timetables -->
    <?php if (!empty($timetables)) : ?>
        <table align='center'>
            <thead>
                <tr>
                    <th>Timetable ID</th>
                    <th>Table Name </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timetables as $timetable) : ?>
                    <tr>
                        <td height='25' width='100' align='center' style='border: solid 1px #000080;'><?php echo $timetable['ttable_id']; ?></td>
                        <td height='25' width='100' align='center' style='border: solid 1px #000080;'><?php echo $timetable['tablename']; ?></td>
                        <!-- Add other table data as needed -->
                        <td style='border: solid 1px #000080;' width='200' align='center'>
                            <a href="deletetimetable.php?ttable_id=<?php echo $timetable['ttable_id']; ?>"
                            onclick="return confirm('Are you sure you want to delete this timetable?');"">
                                <button>Delete</button>
                            </a>
                            <a href="edittimetable.php?ttable_id=<?php echo $timetable['ttable_id']; ?>"><button>Edit</button> </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p align="center">No Timetables</p>
    <?php endif; ?>
    </div>
</div>



<footer style="text-align: center;">
    &copy; 2023 All Rights Reserved
</footer>

</body>
</html>
