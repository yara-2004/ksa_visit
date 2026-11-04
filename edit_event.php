<?php
include 'db.php';

// Check if the event ID is passed
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $u=$_GET['lang'];

    // Fetch the current event data
    $query = "SELECT * FROM Events WHERE Id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();
}

// Update the event if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $region_id = $_POST['region'];
    $name = $_POST['name'];
    $namear = $_POST['name_ar'];
    $description = $_POST['description'];
    $descriptionar = $_POST['description_ar'];
    $date = $_POST['date'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = $event['Image']; // Keep the current image if no new image is uploaded
    }

    // Update query using prepared statements
    $query = "UPDATE Events SET RegionId = ?, Name = ?,Name_ar = ?, Description = ?, Description_ar = ?, Date = ?, Image = ? WHERE Id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssssi", $region_id, $name , $namear, $description , $descriptionar, $date, $image, $event_id);

    if ($stmt->execute()) {
        echo "<p class='success-message'>Event updated successfully!</p>";
        header("Refresh:2; url=supervisor_main.php?lang=$u");
    } else {
        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Fetch regions for the dropdown
$regions_query = "SELECT * FROM Regions";
$regions_result = $conn->query($regions_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
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
        input[type="date"],
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
        .success-message, .error-message {
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
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Event</h2>
    <form action="edit_event.php?id=<?php echo $event_id; ?>&lang=<?php echo $_GET['lang'];?>" method="post" enctype="multipart/form-data">
        <label for="region">Select Region:</label>
        <select name="region" id="region" required>
            <?php while($region = mysqli_fetch_assoc($regions_result)): ?>
                <option value="<?php echo htmlspecialchars($region['Id']); ?>" <?php if($region['Id'] == $event['RegionId']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($region['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="name">Event Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($event['Name']); ?>" required>
        <label for="name">Event Name in Arabic:</label>
        <input type="text" name="name_ar" id="name" value="<?php echo htmlspecialchars($event['Name_ar']); ?>" required>


        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($event['Description']); ?></textarea>
        <label for="description">Description in Arabic:</label>
        <textarea name="description_ar" id="description" rows="4" required><?php echo htmlspecialchars($event['Description_ar']); ?></textarea>


        <label for="date">Event Date:</label>
        <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($event['Date']); ?>" >

        <label for="image">Upload New Image (Optional):</label>
        <input type="file" name="image" id="image" accept="image/*">
        <br>
        <img src="uploads/<?php echo htmlspecialchars($event['Image']); ?>" alt="Current Image" style="width: 100px;">

        <input type="submit" value="Update Event">
    </form>
    <div class="back-link">
        <p><a href="supervisor_main.php?lang=<?php echo $_GET['lang'];?>">Back to Dashboard</a></p>
    </div>
</div>
</body>
</html>
