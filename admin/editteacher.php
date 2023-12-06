<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../dbconfig.php"); // SQL Connection

if (isset($_GET['teacher_id'])) {
    $teacher_id = $_GET['teacher_id'];

    // Fetch teacher details and timetable details
    $sql = "SELECT * FROM teachers WHERE teacher_id = $teacher_id";
    $result = $db->query($sql);
    $sql2 = "SELECT * FROM timetableid";
    $result2 = $db->query($sql2);

    if ($result && $result2) {
        $row = $result->fetch_assoc();
        $userid = $row['user_id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $gender = $row['gender'];
        $ttableid = $row['ttable_id'];
    } else {
        echo "Error fetching teacher details or timetable details.";
        exit();
    }
} else {
    echo "Teacher ID not provided in the URL.";
    exit();
}

// Handle form submission to update teacher details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_firstname = $_POST['firstname'];
    $new_lastname = $_POST['lastname'];
    $new_gender = $_POST['gender'];
    $new_ttableid = $_POST['timetable_id'];

    // Update the database
    $update_sql = "UPDATE teachers SET firstname = '$new_firstname', lastname = '$new_lastname', gender = '$new_gender', ttable_id = '$new_ttableid' WHERE teacher_id = $teacher_id";
    if ($db->query($update_sql)) {
        // Redirect back to the same page after a successful update
        header("Location: editteacher.php?teacher_id=$teacher_id");
        exit();
    } else {
        echo "Error updating teacher details: " . $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
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
        <!-- Stuff inside the box header -->
        <div style="width:1000px; height:500px; border: solid 2px #000080;" align="left">

            <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
                <p style="font-size:x-large; margin: 10px;">Edit Teacher</p>
                <a href="manageteachers.php" align='left'><button>Back</button></a>
            </div>

            <!-- Form for editing teacher details -->
            <form method="POST">
                <table width='999' align='center'>
                    <tr>
                        <td>First Name: <input type="text" name="firstname" value="<?php echo $firstname; ?>"></td>
                        <td>Last Name: <input type="text" name="lastname" value="<?php echo $lastname; ?>"></td>
                        <td>Gender: <input type="text" name="gender" value="<?php echo $gender; ?>"></td>
                    </tr>
                    <tr>
                        <td>User ID: <?php echo $userid; ?></td>
                        <td>Teacher ID: <?php echo $teacher_id; ?></td>
                        <td>Timetable ID:
                            <select name="timetable_id">
                                <?php
                                // Display timetable options
                                while ($row2 = $result2->fetch_assoc()) {
                                    echo "<option value='{$row2['ttable_id']}'";
                                    if ($row2['ttable_id'] == $ttableid) {
                                        echo " selected";
                                    }
                                    echo ">{$row2['ttable_id']}</option>";
                                    echo "<option value='0'>0</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
                    <button type="submit">Apply</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
