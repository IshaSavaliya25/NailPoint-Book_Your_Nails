<?php
$host = "localhost";
$user = "root"; // default for XAMPP
$password = ""; // default for XAMPP
$dbname = "ish_nails";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
