<?php
// Start the session
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'manager') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'db.php';

// Check if an ID is provided

$user_id = $_GET['id'];
$l=$_GET['lang'];

    // SQL query to delete the user
$query = "DELETE FROM users WHERE Id = $user_id";
    
if (mysqli_query($conn, $query)) {
        echo "User deleted successfully!";
} else {
        echo "Error: " . mysqli_error($conn);
}

    // Close the database connection
    mysqli_close($conn);
    
    // Redirect back to the admin dashboard
    header("Location: admin_main.php?lang=$l");
    exit();

?>
