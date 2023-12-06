<?php
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

//Usage example
//Assuming you have a database connection in $db
//$tableName = "datetimes";
//$IDColumn = "time_id";
//$missingID = findMissingID($db, $tableName, $IDColumn);

?>
