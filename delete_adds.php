<?php
include 'db.php';

// Check if an ID is provided
if (isset($_GET['id'])) {
    $adds_id = $_GET['id'];
    $l=$_GET['lang'];

    // Delete query
    $query = "DELETE FROM advertisements WHERE Id = '$adds_id'";

    if (mysqli_query($conn, $query)) {
        echo "Event deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Redirect to the supervisor main page
    header("Location: Manager%20Control%20Heritage.php?lang=$l");
    exit();
}

// Close the connection
mysqli_close($conn);
?>