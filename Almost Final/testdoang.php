<?php
$mysqli = new mysqli("localhost", "root", "Saufan");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
echo "Connected successfully";
?>
