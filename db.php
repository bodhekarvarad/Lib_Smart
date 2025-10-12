<?php
$host = "localhost";
$user = "root";   // default in XAMPP
$pass = "root";       // default in XAMPP is empty
$dbname = "library";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>