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
$l=$_GET['lang'];

// Fetch region data if the id is provided
$region = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $region_id = $_GET['id'];
    $region_query = "SELECT * FROM Regions WHERE Id = $region_id";
    $result = mysqli_query($conn, $region_query);
    if ($result && mysqli_num_rows($result) > 0) {
        $region = mysqli_fetch_assoc($result);
    } else {
        echo "No region found with the provided ID.";
    }
}

// Handle form submission to update region
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $region_id = $_POST['region_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $namear = mysqli_real_escape_string($conn, $_POST['namear']);
    $descriptionar = mysqli_real_escape_string($conn, $_POST['descriptionar']);
    $image = $_FILES['image']['name'];

    // Update region with or without new image
    if (!empty($image)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $update_query = "UPDATE Regions SET Name = '$name', Name_ar = '$namear', Description = '$description', Description_ar = '$descriptionar', Path = '$image' WHERE Id = $region_id";
        } else {
            echo "Error uploading image.";
            exit;
        }
    } else {
        $update_query = "UPDATE Regions SET Name = '$name', Name_ar = '$namear', Description = '$description', Description_ar = '$descriptionar' WHERE Id = $region_id";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>window.location.href='Manager Control Heritage.php?lang=$l';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
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
    <title>Edit Region</title>
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
            opacity: .7;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="file"] {
            margin-bottom: 20px;
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


<div class="container">
    <h2>Edit Region</h2>
    <?php if ($region): ?>
        <form action="edit_region.php?id=<?php echo $region['Id']; ?>&lang=<?php echo $_GET['lang'];?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="region_id" value="<?php echo $region['Id']; ?>">
            <label for="name">Region Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($region['Name']); ?>" required>

            <label for="name">Region Name:</label>
            <input type="text" name="namear" id="name" value="<?php echo htmlspecialchars($region['Name_ar']); ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($region['Description']); ?></textarea>

            <label for="description">Description:</label>
            <textarea name="descriptionar" id="description" rows="4" required><?php echo htmlspecialchars($region['Description_ar']); ?></textarea>

            <label for="image">Update Image (Optional):</label>
            <input type="file" name="image" id="image" accept="image/*">
            <img src="uploads/<?php echo htmlspecialchars($region['Path']); ?>" alt="Current Image" style="width: 100%; height: 100px; margin-top: 10px;">
            <br><br>

            <input type="submit" value="Update Region">
        </form>
        <div class="back-link">
            <p><a href="Manager%20Control%20Heritage.php?lang=<?php echo $_GET['lang'];?>">Back to Control</a></p>
        </div>
    <?php else: ?>
        <p>No region found with the provided ID.</p>
    <?php endif; ?>
</div>

</body>
</html>
