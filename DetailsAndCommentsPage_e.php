<?php
session_start();
include 'db.php'; // Database connection

$eventId = intval($_GET['id']);
$useris = $_SESSION['user_id'];

// Fetch event details
$eventQuery = "SELECT * FROM events WHERE Id = '$eventId'";
$eventResult = mysqli_query($conn, $eventQuery);
$event = mysqli_fetch_assoc($eventResult);

// Fetch comments
$comQuery = "SELECT * FROM comments WHERE EventId = '$eventId'";
$comResult = mysqli_query($conn, $comQuery);

// Fetch advertisements
$adslQuery = "SELECT * FROM advertisements WHERE LeftAdPath = 1";
$adslResult = mysqli_query($conn, $adslQuery);
$adsl = mysqli_fetch_assoc($adslResult);

$adsrQuery = "SELECT * FROM advertisements WHERE RightAdPath = 1";
$adsrResult = mysqli_query($conn, $adsrQuery);
$adsr = mysqli_fetch_assoc($adsrResult);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data from POST request and escape for security
    $comm = mysqli_real_escape_string($conn, $_POST['com']);
    $sql = "INSERT INTO comments (UserId, EventId, CommentText) VALUES ('$useris', '$eventId', '$comm')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        header("Location: DetailsAndCommentsPage_e.php?id=$eventId");
        exit();
    }
}
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if (in_array($lang, ['en', 'ar'])) {
        $_SESSION['lang'] = $lang;
    }
}

// Translations for static text
$translations = [
    'en' => [
        'dashboard' => 'Event',
        'Details' => 'Details and Comments',
        'Comments'=> 'Comments',
        'Leave' => 'Leave a Comment:',
        'Submit'=> 'Submit Comment',
        'Advertisement' => 'Advertisement',
        ],
    'ar' => [
        'dashboard' => 'الاماكن الترفيهية',
        'Details' => 'التفاصيل و التعليقات',
        'Comments'=> 'التعليقات',
        'Leave' => 'اترك تعليقك',
        'Submit'=> 'ارسال التعليق',
        'Advertisement' => 'اعلان',
        ],
];

$current_lang = $_SESSION['lang'];
$text = $translations[$current_lang];

?>

<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details and Comments</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
            padding: 0;direction: <?php echo $current_lang === 'ar' ? 'rtl' : 'ltr'; ?>;
            text-align: <?php echo $current_lang === 'ar' ? 'right' : 'left'; ?>;
            
        }
        .language-switcher {
            display: flex;
            gap: 10px;
        }
        .navbar {
    display: flex;
    justify-content: space-between; /* Ensures spacing between logo and icons */
    align-items: center;
    background-color: #9CB1A7;
    padding: 15px 30px;
    color: white;
}

.navbar .logo img {
    max-height: 90px;
    display: block;
}

.navbar .links {
    display: flex;
    align-items: center;
    gap: 15px; /* Adds spacing between icons */
}

.navbar .links a img {
    display: block;
    cursor: pointer;
}

        .ad-container {
            width: 150px;

            padding: 20px;
            margin-top: 70px;
            margin: 10px;
            border-radius: 8px;
            text-align: center;
            flex-shrink: 0;
        }
        .content-container {
            flex-grow: 1;
            max-width: 70%;
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 90px; /* Account for the navbar height */
        }
        h2 {
            color: #617460;
            text-align: center;
        }
        .details {
            margin-bottom: 20px;
        }
        .details img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .details p {
            color: #333;
            margin: 5px 0;
        }
        .comments-section {
            margin-top: 30px;
        }
        .comment {
            background-color: #e8e8e8;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }
        .comment h4 {
            margin: 0;
            color: #617460;
        }
        .comment-form {
            margin-top: 20px;
        }
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .comment-form input[type="submit"] {
            margin-top: 10px;
            background-color: #7D5884;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .comment-form input[type="submit"]:hover {
            background-color: #B0C89A;
        }
        .main-content {
            display: flex;
            margin-top: 70px; /* Account for the navbar height */
        }
    </style>
</head>
<body>
<div class="navbar">
    <!-- Logo aligned to the left -->
    <a href="visitor_dashboard.php?lang=<?php echo $lang ?>" class="logo">
        <img src="uploads/logo1.png" alt="Logo" style="width:200px;height:90px">
    </a>
    
    <!-- Icons aligned to the right -->
    <div class="links">
        <a href="edit_profile.php?lang=<?php echo $_GET['lang']; ?>">
            <img src="uploads/user.png" style="width:40px;height:40px;" alt="Edit Profile">
        </a>
        
        <?php if ($_GET['lang'] == 'en') { ?>
            <a href="DetailsAndCommentsPage_e.php?id=<?php echo $eventId; ?>&lang=ar" class="logout-icon">
                <img src="uploads/lang.png" style="width:50px;height:50px;" alt="Switch to Arabic">
            </a>
        <?php } else { ?>
            <a href="DetailsAndCommentsPage_e.php?id=<?php echo $eventId; ?>&lang=en" class="logout-icon">
                <img src="uploads/lang.png" style="width:50px;height:50px;" alt="Switch to English">
            </a>
        <?php } ?>
        <a href="logout.php" class="logout-icon">
            <img src="uploads/logout.png" style="width:40px;height:40px;" alt="Logout">
        </a>
    </div>
</div>


    <div class="main-content">
        <!-- Left Advertisement -->
        <div class="ad-container">
            <h4><?php echo $text['Advertisement']; ?></h4>
            <img src="uploads/<?php echo htmlspecialchars($adsl['Path']); ?>" alt="Left Ad" style="width: 100%; height: 1000px;">
        </div>

        <!-- Content Container -->
        <div class="content-container">
            <h2><?php echo $text['Details']; ?></h2>
            <?php  if ($_GET['lang'] == 'en' ) { ?>
            <div class="details">
                <img src="uploads/<?php echo htmlspecialchars($event['Image']); ?>" alt="Image" style="width: 130%; height: 550px;">
                <h3><?php echo htmlspecialchars($event['Name']); ?></h3>
                <?php if ($event['Date']== '0000-00-00 00:00:00'){ } else {?>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($event['Date']); ?></p>
                <?php } ?>
                <p><?php echo htmlspecialchars($event['Description']); ?></p>
            </div><?php } else { ?>
                <div class="details">
                <img src="uploads/<?php echo htmlspecialchars($event['Image']); ?>" alt="Image" style="width: 130%; height: 550px;">
                <h3><?php echo htmlspecialchars($event['Name_ar']); ?></h3>
                <?php if ($event['Date']== '0000-00-00 00:00:00'){ } else {?>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($event['Date']); ?></p>
                <?php } ?>
                <p><?php echo htmlspecialchars($event['Description_ar']); ?></p>
                </div> <?php } ?>

            <div class="comments-section">
                <h3><?php echo $text['Comments']; ?></h3>
                <?php while ($com = mysqli_fetch_assoc($comResult)): ?>
                    <div class="comment">
                        <?php
                        $userQuery = "SELECT Name FROM users WHERE Id = '" . $com['UserId'] . "'";
                        $userResult = mysqli_query($conn, $userQuery);
                        $user = mysqli_fetch_assoc($userResult);
                        ?>
                        <h4><?php echo htmlspecialchars($user['Name']); ?></h4>
                        <p><?php echo htmlspecialchars($com['CommentText']); ?></p>
                    </div>
                <?php endwhile; ?>

                <!-- Comment Form -->
                <div class="comment-form">
                    <h4><?php echo $text['Leave']; ?></h4>
                    <form action="DetailsAndCommentsPage_e.php?id=<?php echo $eventId; ?>" method="POST">
                        <textarea name="com" rows="4" required></textarea>
                        <input type="submit" value="<?php echo $text['Submit']; ?>">
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Advertisement -->
        <div class="ad-container">
            <h4><?php echo $text['Advertisement']; ?></h4>
            <img src="uploads/<?php echo htmlspecialchars($adsr['Path']); ?>" alt="Right Ad" style="width: 100%; height: 1000px;">
        </div>
    </div>
</body>
</html>
