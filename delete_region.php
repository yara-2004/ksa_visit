<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'manager') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'db.php';

// Check if region ID is provided in the URL
if (isset($_GET['id'])) {
    $region_id = $_GET['id'];
    $l=$_GET['lang'];

    // Delete the region from the database
    $delete_query = "DELETE FROM Regions WHERE Id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, 'i', $region_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Region deleted successfully!'); window.location.href='Manager%20Control%20Heritage.php?lang=$l';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    // Close the statement and the connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
