<?php
include 'db.php';

// Check if the heritage ID is passed
if (isset($_GET['id'])) {
    $heritage_id = intval($_GET['id']);

    // Fetch the current heritage site data
    $query = "SELECT * FROM HeritageSites WHERE Id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $heritage_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $heritageSite = $result->fetch_assoc();
    $stmt->close();
}

// Update the heritage site if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $name_ar = $_POST['name_ar'];
    $description = $_POST['description'];
    $description_ar = $_POST['description_ar'];
    $region_id=$_POST['region'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = $heritageSite['Image']; // Keep the current image if no new image is uploaded
    }

    // Update query using prepared statements
    $query = "UPDATE HeritageSites SET RegionId = ?, Name = ?, Name_ar = ?, Description = ?, Description_ar = ?, Image = ? WHERE Id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssi",$region_id, $name, $name_ar, $description, $description_ar, $image, $heritage_id);

    if ($stmt->execute()) {
        echo "<p class='success-message'>Heritage site updated successfully!</p>";
        header("Refresh:2; url=supervisor_main.php?lang=" . $_GET['lang']);
    } else {
        echo "<p class='error-message'>Error updating heritage site: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$regions_query = "SELECT * FROM Regions";
$regions_result = $conn->query($regions_query);
// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Cultural places</title>
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

        body::before {
            background: url('uploads\\SU.jpg');
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
            color: #617460;
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #7D5884;
        }

        input[type="text"],
        textarea,
        select,
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

        .success-message,
        .error-message {
            text-align: center;
            font-weight: bold;
            padding: 10px;
            border-radius: 4px;
        }

        .success-message {
            color: #fff;
            background-color: #4CAF50;
        }

        .error-message {
            color: #fff;
            background-color: #f44336;
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
    <h2>Edit Cultural places</h2>
    <?php if ($heritageSite): ?>
        <form action="edit_heritage_site.php?id=<?php echo $heritage_id; ?>&lang=<?php echo $_GET['lang']; ?>" method="post" enctype="multipart/form-data">
        <label for="region">Select Region:</label>
        <select name="region" id="region" required>
            <?php while($region = mysqli_fetch_assoc($regions_result)): ?>
                <option value="<?php echo htmlspecialchars($region['Id']); ?>" <?php if($region['Id'] == $heritageSite['RegionId']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($region['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label for="site_name">Site Name (English):</label>
            <input type="text" name="name" id="site_name" value="<?php echo htmlspecialchars($heritageSite['Name']); ?>" required>

            <label for="site_name_ar">Site Name (Arabic):</label>
            <input type="text" name="name_ar" id="site_name_ar" value="<?php echo htmlspecialchars($heritageSite['Name_ar']); ?>" required>
            
            <label for="description">Description (English):</label>
            <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($heritageSite['Description']); ?></textarea>

            <label for="description_ar">Description (Arabic):</label>
            <textarea name="description_ar" id="description_ar" rows="4" required><?php echo htmlspecialchars($heritageSite['Description_ar']); ?></textarea>
            
            <label for="image">Image:</label>
            <input type="file" name="image" id="image">
            <small>(Leave empty if you don't want to change the image)</small>
            <?php if ($heritageSite['Image']): ?>
                <img src="uploads/<?php echo htmlspecialchars($heritageSite['Image']); ?>" alt="Current Image" style="width: 100px; margin-top: 10px;">
            <?php endif; ?>
            
            <input type="submit" value="Update Heritage Site">
        </form>
        <div class="back-link">
            <p><a href="supervisor_main.php?lang=<?php echo $_GET['lang']; ?>">Back to Dashboard</a></p>
        </div>
    <?php else: ?>
        <p>No heritage site found for the provided ID.</p>
    <?php endif; ?>
</div>

</body>
</html>
