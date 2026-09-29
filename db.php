<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "xyrell-login";

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database
);

if ($conn->connect_error) {
    die("DATABASE CONNECTION FAILED: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>