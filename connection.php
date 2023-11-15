<?php
    // Enable error reporting for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // Hostname
    $host = "localhost";

    // Username
    $user = "root";

    // Password
    $pass = "";

    // Database Name
    $db   = "crud_search";


    $con = new mysqli("localhost","root","","crud_search");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }