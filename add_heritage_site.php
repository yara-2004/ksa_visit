<?php
// Start the session
session_start();

// Check if user is logged in and is supervisor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'supervisor') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'db.php';

// Fetch regions for the dropdown
$regions_query = "SELECT * FROM Regions";
$regions_result = mysqli_query($conn, $regions_query);

// Insert the heritage site if the form is submitted



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $region_id = $_POST['region'];
    $name = $_POST['name'];
    $name_ar = $_POST['name_ar'];
    $description = $_POST['description'];
    $description_ar = $_POST['description_ar'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO HeritageSites (RegionId, Name,Name_ar, Description,Description_ar, Image) VALUES (?, ?,?,?, ?, ?)");
        $stmt->bind_param("isssss", $region_id, $name,$name_ar, $description,$description_ar ,$image);

        if ($stmt->execute()) {
            echo "<p class='success-message'>Cultural places added successfully!</p>";
        } else {
            echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='error-message'>Error uploading image.</p>";
    }

    // Close the database connection
    $conn->close();
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Heritage Site</title>
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
            
        }

        body::before{
            background: url('uploads\\SU.jpg') ;
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            
           
            opacity: 0.6;
            z-index: -1;
            background-repeat: no-repeat;
            background-size: 100%;

        }
        

        .navbar {
            background-color: #617460;
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
            opacity: .7;
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
        select,
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
            background-color: #9CB1A7;
            color: black;
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
        <h2>Add Cultural places</h2>
        <form action="add_heritage_site.php?lang=<?php echo $_GET['lang'];?>" method="post" enctype="multipart/form-data">

            <label for="region">Select Region:</label>
            <select name="region" id="region" required>
                <?php while($region = mysqli_fetch_assoc($regions_result)): ?>
                    <option value="<?php echo htmlspecialchars($region['Id']); ?>">
                        <?php echo htmlspecialchars($region['Name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
            <label for="name">Name in Arabic:</label>
            <input type="text" name="name_ar" id="name" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>
            <label for="description">Description in Arabic:</label>
            <textarea name="description_ar" id="description" rows="4" required></textarea>

            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <input type="submit" value="Add Heritage Site">

        </form>
        <div class="back-link">
            <p><a href="supervisor_main.php?lang=<?php echo $_GET['lang'];?>">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>
