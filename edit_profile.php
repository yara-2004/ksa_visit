<?php
session_start();
include 'db.php'; // Database connection


// Check if the user is logged in and is a visitor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'visitor') {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch current user data
$userId = $_SESSION['user_id'];
$query = "SELECT * FROM Users WHERE Id = '$userId'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$updateMessage = ""; // Initialize message

// Update profile on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $l=$_GET['lang'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Update query
    $updateQuery = "UPDATE Users SET Name='$name', Email='$email', Password='$password', PhoneNumber='$phone' WHERE Id='$userId'";
    if (mysqli_query($conn, $updateQuery)) {
        $updateMessage = "Profile updated successfully!";
        header("Location:visitor_dashboard.php?lang=$l");
    } else {
        $updateMessage = "Error updating profile: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        position: relative;
    }

    /* Create a pseudo-element to handle the background image with opacity */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('uploads\\set.png'); /* Replace with the path to your image */
        background-position: center;
        background-size: cover;
        background-attachment: fixed;
        opacity: 0.3; /* Set the opacity of the background image */
        z-index: -1; /* Make sure the background is behind all other content */
    }

    .register-container {
        background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        z-index: 1; /* Make sure this container is above the background */
    }

    h2 {
        text-align: center;
        color: #617460; /* Main title color */
        font-size: 28px;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-size: 14px;
        color: #7D5884; /* Label color */
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #A089A9;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #9CB1A7; /* Submit button color */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #D0D0C4; /* Hover effect */
    }

    .register-footer {
        text-align: center;
        margin-top: 20px;
    }

    .register-footer a {
        color: #602179;
        text-decoration: none;
    }

    .register-footer a:hover {
        text-decoration: underline;
    }
</style>

    <script>
        // Fade out message after 3 seconds
        window.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const messageDiv = document.querySelector('.message');
                if (messageDiv) {
                    messageDiv.style.opacity = '0';
                }
            }, 3000);
        });
    </script>
</head>
<body>
    <div class="register-container">
        <h2>Edit Profile</h2>
        
        <!-- Success message -->
        <?php if ($updateMessage): ?>
            <div class="message"><?php echo $updateMessage; ?></div>
        <?php endif; ?>

        <!-- Profile edit form -->
        <form action="edit_profile.php?lang=<?php echo $_GET['lang']; ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($user['Password']); ?>" required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['PhoneNumber']); ?>" required>

            <input type="submit" value="Update Profile">
        </form>
        <div class="register-footer">
        <p><a href="visitor_dashboard.php?lang=<?php echo $_GET['lang'];?>">Back to Main page</a></p></div>
    </div>
</body>
</html>
