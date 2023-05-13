<?php
    $username = "c21patrick";
    $password = "Udinese2020";
    $host = "localhost";
    $dbname = "c21MoneyManager";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Connection failed";
    }
    else {
    }
?>