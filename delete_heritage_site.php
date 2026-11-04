<?php
include 'db.php';
session_start();

// Check if an ID is provided
if (isset($_GET['id'])) {
    $heritage_id = $_GET['id'];
    $l=$_GET['lang'];

    // Delete query
    $query = "DELETE FROM HeritageSites WHERE Id = '$heritage_id'";

    if (mysqli_query($conn, $query)) {
        echo "Heritage site deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Redirect to the supervisor main page
    if( $_SESSION['user_type'] != 'manager'){
    header("Location: supervisor_main.php?lang=$l");
    } else {
        header("Location: Manager%20Control%20Heritage.php?lang=$l");
    }
    
    exit();
}

// Close the connection
mysqli_close($conn);
?>
