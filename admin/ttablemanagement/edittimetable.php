<?php
session_start();

// Check if the user is logged in and has the correct usertype (sysadmin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../../dbconfig.php"); // Connects to the MySQL Database
include("../globalsorter.php"); // Sorter for consistent deletion and insertion to the database




// Fetch timetable ID from the URL parameter
$ttableIDToShow = isset($_GET['ttable_id']) ? intval($_GET['ttable_id']) : null;

$sqltablename = "SELECT * FROM timetableid WHERE ttable_id = $ttableIDToShow";
$result = $db->query($sqltablename);
if ($result) {
    $row = $result->fetch_assoc();
    $tablename = $row['tablename'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newtablename = $_POST['tablename'];
    $sqlupdatetablename = "UPDATE timetableid SET tablename = '$newtablename' WHERE ttable_id = $ttableIDToShow";
    if ($db->query($sqlupdatetablename)) {
        header("Location:edittimetable.php?ttable_id=$ttableIDToShow");
        exit();
    } else {
        echo "Error updating tablename" . $db->error;
    }
    
}


if ($ttableIDToShow !== null) {
    // Step 1: Check if the timetable exists
    $sqlCheckTimetable = "SELECT * FROM timetableid WHERE ttable_id = $ttableIDToShow";
    $resultCheckTimetable = $db->query($sqlCheckTimetable);

    if ($resultCheckTimetable->num_rows > 0) {
        // Step 2: Fetch data from the corresponding timetable table
        $sqlFetchTimetableData = "SELECT * FROM table_$ttableIDToShow";
        $resultFetchTimetableData = $dbtables->query($sqlFetchTimetableData);

        if (!$resultFetchTimetableData) {
            // Handle the case where fetching data from the table failed
            die("Error fetching timetable data: " . $dbtables->error);
        }

        // Step 3: Display timetable data
?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>View Timetable</title>
            <style>
                html {
                    font-family: Arial, sans-serif;
                }
            </style>
        </head>
        <body>
            <div align="center">
                <div style="width:1000px; height:1000px; border: solid 2px #000080;" align="left">
                    <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
                        <p style="font-size:x-large; margin: 10px;">Edit Timetable</p>
                        <a href="index.php"><button> Back </button></a>
                        <a href="assignclasses.php?ttable_id=<?php echo $_GET['ttable_id']; ?>"><button>Add Classes</button></a>
                        <form method='POST'> Timetable Name: <input type="text" name="tablename" value="<?php echo $tablename; ?>"> <button type="submit">Rename</button> </form>
                    </div>

                    <?php if ($resultFetchTimetableData->num_rows > 0) : ?>
                        <table align='center' style="width:1000px;">
                            <tr>
                                <th>Class ID</th>
                                <th>Class Name</th>
                                <th>Teacher ID</th>
                                <th>Time ID</th>
                                <th>Subject ID</th>
                                <th>Action</th> <!-- New column for delete action -->
                            </tr>
                            <?php while ($row = $resultFetchTimetableData->fetch_assoc()) : ?>
                                <tr>
                                    <td height='25' width='100' align='center' style='border: solid 1px #000080;'><?php echo $row['class_id']; ?></td>
                                    <td style='border: solid 1px #000080;' width='200' align='center'><?php echo $row['classname']; ?></td>
                                    <td style='border: solid 1px #000080;' width='200' align='center'><?php echo $row['teacher_id']; ?></td>
                                    <td style='border: solid 1px #000080;' width='200' align='center'><?php echo $row['time_id']; ?></td>
                                    <td style='border: solid 1px #000080;' width='200' align='center'><?php echo $row['subject_id']; ?></td>
                                    <td style='border: solid 1px #000080;' width='100' align='center'>
                                        <a href="deleteclass.php?ttable_id=<?php echo $_GET['ttable_id']; ?>&class_id=<?php echo $row['class_id']; ?>">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </table>
                    <?php else : ?>
                        <p align='center'>No data available for the selected timetable.</p>
                    <?php endif; ?>
                </div>
            </div>
        </body>
        </html>

        <?php
    } else {
        // Handle the case where the timetable does not exist
        die("Timetable not found");
    }
} else {
    // Handle the case where ttable_id is not provided in the URL
    die("Timetable ID not provided");
}
?>
