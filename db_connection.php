<?php
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP has no password
$database = "justonefitness"; // Update with your actual database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
