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
$l=$_GET['lang'];
// Include the database connection file
include 'db.php';

// Fetch heritage sites, regions, video, and advertisements from the database
$heritages_query = "SELECT * FROM HeritageSites";
$heritages_result = mysqli_query($conn, $heritages_query);

$regions_query = "SELECT * FROM Regions";
$regions_result = mysqli_query($conn, $regions_query);

$video_query = "SELECT * FROM video";
$videor = mysqli_query($conn, $video_query);

$adds_query ="SELECT * FROM `advertisements`";
$addre = mysqli_query($conn, $adds_query);

$eventsQuery = "SELECT * FROM Events ";
$events = mysqli_query($conn, $eventsQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $text1 = $_POST['text'];
    $text2 = $_POST['text2'];
    $text1ar = $_POST['textar'];
    $text2ar = $_POST['text2ar'];
    $video = $_FILES['video']['name'];

    // Define target directory and target file path
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($video); // Define $target_file

    // Move uploaded file to target directory
    if (!empty($video) && move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
        // Update query with the new video file
        $updateQuery = "UPDATE `video` SET `name` = '$video', `text` = '$text1', `text_ar` = '$text1ar', `text2` = '$text2', `text2_ar` = '$text2ar' WHERE `ID` = 1";

        if (mysqli_query($conn, $updateQuery)) {
            $updateMessage = "Hero section updated successfully!";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        // Update query without changing the video file
        $updateQuery = "UPDATE `video` SET `text` = '$text1', `text_ar` = '$text1ar', `text2` = '$text2', `text2_ar` = '$text2ar' WHERE `ID` = 1";

        if (mysqli_query($conn, $updateQuery)) {
            $updateMessage = "Hero section updated successfully!";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    // Update displayed heritage sites
    mysqli_query($conn, "UPDATE HeritageSites SET display = ''");

    if (isset($_POST['display_sites'])) {
        $display_sites = $_POST['display_sites'];
        foreach ($display_sites as $site_id) {
            mysqli_query($conn, "UPDATE HeritageSites SET display = TRUE WHERE Id = $site_id");
        }
    }

    mysqli_query($conn, "UPDATE events SET display = ''");

    if (isset($_POST['display_sitese'])) {
        $display_sitese = $_POST['display_sitese'];
        foreach ($display_sitese as $site_ide) {
            mysqli_query($conn, "UPDATE events SET display = TRUE WHERE Id = $site_ide");
        }
    }

    // Update Left advertisements
    mysqli_query($conn, "UPDATE advertisements SET LeftAdPath = ''");

    if (isset($_POST['display_sitesl'])) {
        $display_sitesl = $_POST['display_sitesl'];
        foreach ($display_sitesl as $site_idl) {
            mysqli_query($conn, "UPDATE advertisements SET LeftAdPath = TRUE WHERE Id = $site_idl");
        }
    }

    // Update Right advertisements
    mysqli_query($conn, "UPDATE advertisements SET RightAdPath = ''");

    if (isset($_POST['display_sitesr'])) {
        $display_sitesr = $_POST['display_sitesr'];
        foreach ($display_sitesr as $site_idr) {
            mysqli_query($conn, "UPDATE advertisements SET RightAdPath = TRUE WHERE Id = $site_idr");
        }
    }

    echo "<script>window.location.href='visitor_dashboard.php?lang=$l';</script>";
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
        'dashboard' => 'Admin control panel',
        'Hero' => 'Hero Section',
        'Hero_video'=> 'Change Hero Video:',
        'Hero_text' => 'Update Hero Text in English:',
        'Hero_text2' => 'Update Hero Text2 in English:',
        'Hero_textar' => 'Update Hero Text in Arabic:',
        'Hero_text2ar' => 'Update Hero Text2 in Arabic:',
        'Famous' => 'Famous places',
        'Select' => 'Select',
        'Name' => 'Name',
        'Des' => 'Description',
        'Image' => 'Image',
        'Action' => 'Action',
        'Delete' => 'delete',
        'Addsl'=>'Select Left',
        'Addsr'=>'Select Right',
        'Update'=>'Update',
        'Addsa'=>'Add New Adds',
        'Exr'=>'Explore regions',
        'Addr'=>'Explore regions',
        'Footer'=>'Managing the content of the Visitor Dashboard to ensure the best experience for all users',
        'More'=>'Show more',
        'Edit'=>'Edit',
    ],
    'ar' => [
        'dashboard' => 'صفحة تعديل الواجهة الرئيسية للمستخدم ',
        'Hero' => 'تغير الفيديو',
        'Hero_video' => 'تغير الفيديو',
        'Hero_text'=> 'تغير النص العلوي باللغة الانجليزية للفيديو ',
        'Hero_text2' => 'تغير النص السفلي باللغة الانجليزية للفيديو',
        'Hero_textar'=> 'تغير النص العلوي باللغة العربية للفيديو ',
        'Hero_text2ar' => 'تغير النص السفلي باللغة العربية للفيديو',
        'Famous' => 'اكثر الاماكن شهرة',
        'Select' => 'تحديد',
        'Name' => 'الأسم',
        'Des' => 'الوصف',
        'Image' => 'الصورة',
        'Action' => 'الاجراء',
        'Delete' => 'حذف',
        'Addsl' => 'إظهار الاعلان في الجهة اليسرى',
        'Addsr'=>'إظهار الاعلان في الجهة اليمنى',
        'Update'=>'تحديث صفحة الزائر',
        'Addsa'=>'إضافة اعلان جديد',
        'Exr'=>'تصفح المدن',
        'Addr'=>'إضافة مدينة جديدة',
        'Footer'=> 'إدارة محتوى لوحة معلومات الزوار لضمان أفضل تجربة لجميع المستخدمين',
        'More'=>'إظهار المزيد',
        'Edit'=>'تحديث',
    ],
];

$current_lang = $_SESSION['lang'];
$textt = $translations[$current_lang];

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $textt['dashboard']; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        direction: <?php echo $current_lang === 'ar' ? 'rtl' : 'ltr'; ?>;
        text-align: <?php echo $current_lang === 'ar' ? 'right' : 'left'; ?>;
    }
    .language-switcher {
            display: flex;
            gap: 10px;
        }
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('uploads\\A2.jpg');
        opacity: 0.4;
        z-index: -1; 
        background-repeat: no-repeat;
        background-size: 100%;
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
    /* Specific Styling for Change Hero Video Inputs */
    input[type="file"] {
        width: 70%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #4CAF50;
        border-radius: 8px;
        box-sizing: border-box;
        background-color: #f0f0f0;
        font-size: 16px;
    }
    input[type="file"]:hover {
        border-color: #FF8C00;
    }
    textarea {
        width: 70%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #4CAF50;
        border-radius: 8px;
        background-color: #f0f0f0;
        font-size: 16px;
    }
    textarea:focus {
        border-color: #FF8C00;
        background-color: #ffffff;
    }
    .container {
        max-width: 1200px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    h2, h3 {
        color: #333;
        text-align: center;
    }
    .section {
        margin-top: 40px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    table, th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    th {
        background-color: #9CB1A7;
        color: white;
    }
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    .action-link {
        padding: 8px 15px;
        border-radius: 5px;
        background-color: #9CB1A7;
        color: white;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    .action-link:hover {
        color: black;
    }
    .b:hover{
        cursor: pointer;
        display: block;
        
    }
    .add-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #9CB1A7;
        text-decoration: none;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 5px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s;
    }
    .add-link:hover {
        background-color: #9CB1A7;
        color: black;
    }
    .footer {
        text-align: center;
        padding: 20px;
        margin-top: 50px;
        background-color: #9CB1A7;
        color: #ffffff;
    }
    .hidden-row {
        display: none;
    }
    
</style>

</head>
<body>

<div class="navbar">
    <!-- Logo aligned to the left -->
    <a href="admin_main.php?lang=<?php echo $_GET['lang'];?>"  class="logo">
        <img src="uploads/logo1.png" alt="Logo" style="width:200px;height:90px">
    </a>
    
    <!-- Icons aligned to the right -->
    <div class="links">
        
        
        <?php if ($_GET['lang'] == 'en') { ?>
            <a href="Manager%20Control%20Heritage.php?lang=ar" class="logout-icon">
                <img src="uploads/lang.png" style="width:50px;height:50px;" alt="Switch to Arabic">
            </a>
        <?php } else { ?>
            <a href="Manager%20Control%20Heritage.php?lang=en" class="logout-icon">
                <img src="uploads/lang.png" style="width:50px;height:50px;" alt="Switch to English">
            </a>
        <?php } ?>
        <a href="logout.php" class="logout-icon">
            <img src="uploads/logout.png" style="width:40px;height:40px;" alt="Logout">
        </a>
    </div>
</div>

<div class="container">

    <!-- Hero Section Control -->
    <div class="section">
        <h3><?php echo $textt['Hero']; ?></h3>
        <form action="Manager Control Heritage.php?lang=<?php echo $_GET['lang'];?>" method="post" enctype="multipart/form-data">
            <label for="hero-video"><?php echo $textt['Hero_video']; ?></label><br>
            <?php $vs = mysqli_fetch_assoc($videor) ?>
            <input type="file" name="video" id="video" accept="video/*"><br><br>
            <label for="hero-text"><?php echo $textt['Hero_text']; ?></label><br>
            <textarea name="text" rows="4" cols="50"><?php echo $vs['text'] ?></textarea><br><br>
            <label for="hero-text"><?php echo $textt['Hero_textar']; ?></label><br>
            <textarea name="textar" rows="4" cols="50"><?php echo $vs['text_ar'] ?></textarea><br><br>
            <label for="hero-text"><?php echo $textt['Hero_text2']; ?></label><br>
            <textarea name="text2" rows="4" cols="50"><?php echo $vs['text2'] ?></textarea><br><br>
            <label for="hero-text"><?php echo $textt['Hero_text2ar']; ?></label><br>
            <textarea name="text2ar" rows="4" cols="50"><?php echo $vs['text2_ar'] ?></textarea><br><br>
    </div>

    <!-- Heritage Sites Section -->
    <div class="section">
        <h3><?php echo $textt['Famous']; ?></h3>
        <table id="heritage-table">
            <thead>
                <tr>
                    <th><?php echo $textt['Select']; ?></th>
                    <th><?php echo $textt['Name']; ?></th>
                    <th><?php echo $textt['Des']; ?></th>
                    <th><?php echo $textt['Image']; ?></th>
                    <th><?php echo $textt['Action']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 0;
                while($heritage = mysqli_fetch_assoc($heritages_result)):
                    
                    $count++;
                    if ($_GET['lang'] == 'en' ) { ?>
                
                <tr class="<?php echo ($count > 4) ? 'hidden-row' : ''; ?>">
                    <td><input type="checkbox" name="display_sites[]" value="<?php echo $heritage['Id']; ?>" <?php echo ($heritage['display'] ? 'checked' : ''); ?>></td>
                    <td><?php echo htmlspecialchars($heritage['Name']); ?></td>
                    <td><?php echo htmlspecialchars($heritage['Description']); ?></td>
                    <td><img src="uploads/<?php echo $heritage['Image']; ?>" alt="Image" style="width: 70px; height: auto;"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="delete_heritage_site.php?id=<?php echo $heritage['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this heritage site?');"><?php echo $textt['Delete']; ?></a>
                        </div>
                    </td>
                    
                </tr>
                <?php } else { ?> 
                    <tr class="<?php echo ($count > 4) ? 'hidden-row' : ''; ?>">
                    <td><input type="checkbox" name="display_sites[]" value="<?php echo $heritage['Id']; ?>" <?php echo ($heritage['display'] ? 'checked' : ''); ?>></td>
                    <td><?php echo htmlspecialchars($heritage['Name_ar']); ?></td>
                    <td><?php echo htmlspecialchars($heritage['Description_ar']); ?></td>
                    <td><img src="uploads/<?php echo $heritage['Image']; ?>" alt="Image" style="width: 70px; height: auto;"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="delete_heritage_site.php?id=<?php echo $heritage['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this heritage site?');"><?php echo $textt['Delete']; ?></a>
                        </div>
                    </td>
                    <?php } endwhile; ?>
                    
                </tr>
                <?php while($eventss= mysqli_fetch_assoc($events)): 
                    if ($_GET['lang'] == 'en' ) { ?>
                    <tr class="<?php echo ($count > 4) ? 'hidden-row' : ''; ?>">
                
                <td><input type="checkbox" name="display_sitese[]" value="<?php echo $eventss['Id']; ?>" <?php echo ($eventss['display'] ? 'checked' : ''); ?>></td>
                    <td><?php echo htmlspecialchars($eventss['Name']); ?></td>
                    <td><?php echo htmlspecialchars($eventss['Description']); ?></td>
                    <td><img src="uploads/<?php echo $eventss['Image']; ?>" alt="Image" style="width: 70px; height: auto;"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="delete_event.php?id=<?php echo $eventss['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this heritage site?');"><?php echo $textt['Delete']; ?></a>
                        </div>
                    </td>
                    </tr>
                    <?php } else { ?>
                        <tr class="<?php echo ($count > 4) ? 'hidden-row' : ''; ?>">
                
                        <td><input type="checkbox" name="display_sitese[]" value="<?php echo $eventss['Id']; ?>" <?php echo ($eventss['display'] ? 'checked' : ''); ?>></td>
                    <td><?php echo htmlspecialchars($eventss['Name_ar']); ?></td>
                    <td><?php echo htmlspecialchars($eventss['Description_ar']); ?></td>
                    <td><img src="uploads/<?php echo $eventss['Image']; ?>" alt="Image" style="width: 70px; height: auto;"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="delete_event.php?id=<?php echo $eventss['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this heritage site?');"><?php echo $textt['Delete']; ?></a>
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            
                <?php 
                endwhile; ?>
            </tbody>
        </table>

        <div class="see-more-container" style="text-align: center; margin-top: 20px;">
           <b> <u style="color:cornflowerblue"><a id="see-more-button" style="color:cornflowerblue" class="b" onclick="showAllRows()"><?php echo $textt['More']; ?></a></u></b>
        </div>
        
        <!-- Advertisements Section -->
        <table>
            <thead>
                <tr>
                    <th><?php echo $textt['Addsl']; ?></th>
                    <th><?php echo $textt['Addsr']; ?> </th>
                    <th><?php echo $textt['Image']; ?></th>
                    <th><?php echo $textt['Action']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while($ad = mysqli_fetch_assoc($addre)): ?>
                <tr>
                    <td><input type="checkbox" name="display_sitesl[]" value="<?php echo $ad['Id']; ?>" <?php echo ($ad['LeftAdPath'] ? 'checked' : ''); ?>></td>
                    <td><input type="checkbox" name="display_sitesr[]" value="<?php echo $ad['Id']; ?>" <?php echo ($ad['RightAdPath'] ? 'checked' : ''); ?>></td>
                    <td><img src="uploads/<?php echo $ad['Path']; ?>" alt="Image" style="width: 70px; height: auto;"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="delete_adds.php?id=<?php echo $ad['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this heritage site?');"><?php echo $textt['Delete']; ?></a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <input style="background-color: #737CA1; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; width: 20%; font-size: 16px; font-weight: bold; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" type="submit" value="<?php echo $textt['Update']; ?>">
        </form>
        <a class="add-link" href="add adds.php?lang=<?php echo $_GET['lang'];?>"><?php echo $textt['Addsa']; ?></a>
    </div>

    <!-- Regions Section -->
    <div class="section">
        <h3><?php echo $textt['Exr']; ?></h3>
        <table>
            <thead>
                <tr>
                    <th><?php echo $textt['Name']; ?></th>
                    <th><?php echo $textt['Des']; ?></th>
                    <th><?php echo $textt['Image']; ?></th>
                    <th><?php echo $textt['Action']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while($region = mysqli_fetch_assoc($regions_result)):
                    if ($_GET['lang'] == 'en' ) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($region['Name']); ?></td>
                    <td><?php echo htmlspecialchars($region['Description']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($region['Path']); ?>" alt="Image" style="width: 70px; height: auto;"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="edit_region.php?id=<?php echo $region['Id']; ?>&lang=<?php echo $_GET['lang'];?>"><?php echo $textt['Edit']; ?></a>
                            <a class="action-link" href="delete_region.php?id=<?php echo $region['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this region?');"><?php echo $textt['Delete']; ?></a>
                        </div>
                    </td>
                </tr>
                <?php } else { ?> 
                    <tr>
                    <td><?php echo htmlspecialchars($region['Name_ar']); ?></td>
                    <td><?php echo htmlspecialchars($region['Description_ar']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($region['Path']); ?>" alt="Image" style="width: 70px; height: auto;"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="edit_region.php?id=<?php echo $region['Id']; ?>&lang=<?php echo $_GET['lang'];?>"><?php echo $textt['Edit']; ?></a>
                            <a class="action-link" href="delete_region.php?id=<?php echo $region['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this region?');"><?php echo $textt['Delete']; ?></a>
                        </div>
                    </td>
                </tr>
                <?php } endwhile; ?>
            </tbody>
        </table>
        <br>
        <a class="add-link" href="add region.php?lang=<?php echo $_GET['lang'];?>"><?php echo $textt['Addr']; ?></a>
    </div>
</div>

<div class="footer">
    <p><?php echo $textt['Footer']; ?></p>
</div>

</body>
<script>
    function showAllRows() {
        // Get all rows with the class 'hidden-row' and set their display to table-row
        const hiddenRows = document.querySelectorAll('.hidden-row');
        hiddenRows.forEach(row => row.style.display = 'table-row');
        
        // Hide the "Show More" button after all rows are visible
        document.getElementById('see-more-button').style.display = 'none';
    }
</script>
</html>
