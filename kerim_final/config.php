<?php
$servername = "localhost";
$username = "root";
$password = "abc123";
$dbname = "kerim";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
