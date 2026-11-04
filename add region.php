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
$u=$_GET['lang'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $namear = mysqli_real_escape_string($conn, $_POST['namear']);
    $descriptionar = mysqli_real_escape_string($conn, $_POST['descriptionar']);
    $image = $_FILES['image']['name'];

    // Set the target directory for the image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert the new region into the database
        $query = "INSERT INTO Regions (Name, Name_ar, Description, Description_ar, Path) VALUES ('$name','$namear', '$description','$descriptionar', '$image')";
        
        if (mysqli_query($conn, $query)) {

            echo "<script>window.location.href='visitor_dashboard.php?lang=$u';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Explore Region</title>
    <link rel="stylesheet" href="style.css">
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
            z-index: 1;
        }

        body::before {
            content: "";
            background: url('uploads\\A1.jpg') center/cover no-repeat;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.5;
        }

        .navbar {
            background-color: #9CB1A7;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
            opacity: 0.7;
        }
        h2 {
            text-align: center;
            color: #617460;
            font-size: 28px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #7D5884;
        }
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #A089A9;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #9CB1A7;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #FF8C00;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #602179;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav>
    <div class="container">
        <h2>Add Explore Region</h2>
        <form action="add region.php" method="post" enctype="multipart/form-data">
            <label for="name">Region Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="name">Region Name in Arabic:</label>
            <input type="text" name="namear" id="name" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>

            <label for="description">Description in Arabic:</label>
            <textarea name="descriptionar" id="description" rows="4" required></textarea>

            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <input type="submit" value="Add Region">

        </form>
        <div class="back-link">
        <p><a href="Manager%20Control%20Heritage.php?lang=<?php echo $_GET['lang'];?>">Back to Control</a></p>
        </div>
    </div>
</body>
</html>
