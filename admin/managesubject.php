<?php
session_start();
// Check if the user is logged in and has the correct usertype (admin)
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'sysadmin') {
    header('Location: ../login.php');
    exit();
}
include("../dbconfig.php");
include("globalsorter.php");

// Fetch subjects from the database for display
$sql = "SELECT * FROM subjects";
$result = $db->query($sql);
$subjects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;

    }
}


// Add a subject
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectname = $_POST["subjectname"];
    $subjectcode = $_POST["subjectcode"];
    if (!empty($subjectname) && !empty($subjectcode)) {
        // Construct SQL Query before insertion of subject into the database
        $tableName = "subjects";
        $IDColumn = "subject_id";
        $missingID = findMissingID($db, $tableName, $IDColumn);
        $sql = "INSERT INTO subjects (subject_id, subject_name, subject_code) VALUES ($missingID, '$subjectname','$subjectcode')";
        $result = $db->query($sql);
        if ($result) {
            echo "Subject added successfully.";
            header("Location: {$_SERVER['PHP_SELF']}");
        } else {
            echo "Error: " . $db->error;
        }
        
    }
}

// Delete a subject
if (isset($_GET["delete_subject"])) {
    $subjectIdToDelete = $_GET["delete_subject"];
    // Construct SQL Query to delete the subject
    $sql = "DELETE FROM subjects WHERE subject_id = $subjectIdToDelete";
    $db->query($sql);
    header("Location: {$_SERVER['PHP_SELF']}");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subjects</title>
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
    <div style="width:1000px; height:1000px; border: solid 2px #000080;" align="left">
    
        <div style="background-color:#000080; color:#FFFFFF; padding:3px;">
            <p style="font-size:x-large; margin: 10px;">Manage Subjects</p>
            <a href="index.php" align = 'left'><button>Back</button></a>
            <form action="" method="post">
                <label>Subject Name: </label>
                <input type="text" id="subjectname" name="subjectname" required>
                <label>Subject Code: </label>
                <input type="text" id="subjectcode" name="subjectcode" required>
                <input type="submit" value="Add">
            </form>
            
        </div>

        <!-- Table Display: Stuff actually inside the box -->
        <table width='999' align='center'>
            <tr height = '25'>
                <th width = '100'>Subject ID</th>
                <th width = '100'>Subject Code</th>
                <th align = 'left'>Subject Name</th>
                <th width = '100'>Action</th>
            </tr>
            <tr>
            <?php
                foreach ($subjects as $subject) {
                    echo "<tr>";
                    echo "<td height = '25' width = '100' align = 'center' style = 'border: solid 1px #000080;'>{$subject['subject_id']}</td>";
                    echo "<td style = 'border: solid 1px #000080;' width = '100' align = 'center'> {$subject['subject_code']}</td>";
                    echo "<td style = 'border: solid 1px #000080;'>{$subject['subject_name']}</td>";
                    echo "<td align = 'center' style = 'border: solid 1px #000080;' width = '100'><button><a href='?delete_subject={$subject['subject_id']}'>Delete</a></button></td>";
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
