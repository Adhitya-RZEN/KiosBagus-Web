<?php
$host = "localhost";
$user = "root";
$pass = "Saufan";
$db = "db_kios";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>