<?php
// Database connection variables
$host = 'localhost';
$username = 'root'; // Default XAMPP username for MySQL is 'root'
$password = '';     // Default XAMPP password for MySQL is empty
$database = 'visit_ksa';

// Create connection using MySQLi
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>