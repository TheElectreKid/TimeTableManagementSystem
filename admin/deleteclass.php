<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}

include("../dbconfig.php"); // SQL Connection

if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    
    // Check if a confirmation form has been submitted, then delete
    if (isset($_POST['confirm_delete'])) {
        // Delete the class from the database
        $delete_sql = "DELETE FROM class WHERE class_id = $class_id";
        if ($db->query($delete_sql)) {
            header("Location: manageclass.php"); // Redirect to the class management page after deletion
            exit();
        } else {
            echo "Error deleting class: " . $db->error; //Error handling
            exit();
        }
    }

    // Fetch class details for confirmation
    $sql = "SELECT classname FROM class WHERE class_id = $class_id";
    $result = $db->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        $classname = $row['classname'];
    } else {
        echo "Error fetching class details.";
        exit();
    }
} else {
    echo "Class ID not provided for deletion.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Class</title>
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
            <p style="font-size:x-large; margin: 10px;">Delete Class</p>       
        </div>


        <!-- Confirmation form before deletion -->
        <form method="POST" align='center'>
            <p>Are you sure you want to delete the class "<?php echo $classname; ?>"?</p>
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            <button type="submit" name="confirm_delete">Confirm Delete</button>
            <button type="button" onclick="history.go(-1);">Back</button>
        </form>

    </div>
</div>

</body>
</html>
