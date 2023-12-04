<?php
    // First Database Connection
    define('DB_SERVER_1', 'localhost');
    define('DB_USERNAME_1', 'root');
    define('DB_PASSWORD_1', '');
    define('DB_DATABASE_1', 'group2db');
    $db = mysqli_connect(DB_SERVER_1, DB_USERNAME_1, DB_PASSWORD_1, DB_DATABASE_1);

    // Check the first database connection
    if (mysqli_connect_errno()) {
        echo "Connection to Main Database Failed: " . mysqli_connect_error();
        exit();
    }

    // Second Database Connection
    define('DB_SERVER_2', 'localhost');
    define('DB_USERNAME_2', 'root');
    define('DB_PASSWORD_2', '');
    define('DB_DATABASE_2', 'group2dbttables');
    $dbtables = mysqli_connect(DB_SERVER_2, DB_USERNAME_2, DB_PASSWORD_2, DB_DATABASE_2);

    // Check the second database connection
    if (mysqli_connect_errno()) {
        echo "Connection to Schedule Database Failed: " . mysqli_connect_error();
        exit();
    }

?>
