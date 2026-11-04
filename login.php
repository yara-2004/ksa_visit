<?php
session_start();
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from the POST request, escape to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Simple SQL query to fetch user based on email and password
    $query = "SELECT * FROM Users WHERE Email = '$email' AND Password = '$password'"; // Use hashing for passwords in real apps

    // Execute the query
    $result = mysqli_query($conn, $query);


    // Check if user exists
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Debugging line to check the user type
        echo "User type: " . $user['UserType']; // This line helps in debugging
        $type=$user['UserType'];
        // Store user type and ID in session
        $_SESSION['user_type'] = $user['UserType'];
        $_SESSION['user_id'] = $user['Id'];
        $_SESSION['nameuser']=$user['Name'];

        // Redirect based on user type
        if ($user['UserType'] === 'supervisor') {
            header("Location: supervisor_main.php?lang=en");
        } elseif ($user['UserType'] === 'visitor') {
            header("Location: visitor_dashboard.php?lang=en");
        } elseif ($user['UserType'] === 'manager') {
            echo 5;
            header("Location: admin_main.php?lang=en");
        } else {
            echo "Unknown user type.";
        }
        exit(); // Make sure to exit after redirection
    } else {
        echo "Invalid email or password.";
    }
}
// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-image: url('uploads\\background.png'); /* Replace with the path to your logo image */
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-attachment: fixed;
            background-size: 100% 100%;
        }


        /* Container for the login form */
        .login-container {
             background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #617460; /* Main color from the palette */
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #7D5884; /* From palette */
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #A089A9;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #9CB1A7; /* Button color */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #D0D0C4; /* Lighter hover effect */
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
        }

        .login-footer a {
            color: #602179;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login to Visit KSA</h2>
        <form action="login.php" method="post">
            <label>Email: <input type="email" name="email" required></label><br>
            <label>Password: <input type="password" name="password" required></label><br>
            <input type="submit" value="Login">
        </form>
        <div class="login-footer">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>
