<?php
include 'db.php';

// Check if an ID is provided
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $l=$_GET['lang'];

    // Delete query
    $query = "DELETE FROM Events WHERE Id = '$event_id'";

    if (mysqli_query($conn, $query)) {
        echo "Event deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Redirect to the supervisor main page
    if( $_SESSION['user_type'] != 'manager'){
    header("Location: supervisor_main.php?lang=$l");
} else {
    header("supervisor_main.php?lang=$l");
}

    exit();
}

// Close the connection
mysqli_close($conn);
?>
