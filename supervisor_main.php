<?php
session_start();
include 'db.php'; // Database connection

$n=$_SESSION['nameuser'];

// Fetch all heritage sites
$heritages_query = "SELECT * FROM HeritageSites";
$heritages_result = mysqli_query($conn, $heritages_query);

// Fetch all events
$events_query = "SELECT * FROM Events";
$events_result = mysqli_query($conn, $events_query);

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
        'dashboard' => 'Supervisor Dashboard',
        'heritage_sites' => 'Cultural places',
        'welcom'=> 'Welcom',
        'events' => 'Events',
        'name' => 'Name',
        'description' => 'Description',
        'image' => 'Image',
        'actions' => 'Actions',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'update' => 'Update',
        'logout' => 'Logout',
        'date'=>'date',
        'addh'=>'Add New Cultural places',
        'adde'=>'Add New Event',
        'footer'=>'The page of the administrator responsible for adding cultural and entertainment places',
        'show'=>'Show more',
    ],
    'ar' => [
        'dashboard' => 'الصفحة الرئيسية',
        'heritage_sites' => 'المواقع الثقافية',
        'welcom'=> 'مرحبا',
        'events' => 'الأماكن الترفيهية',
        'name' => 'الاسم',
        'description' => 'الوصف',
        'image' => 'الصورة',
        'actions' => 'الإجراءات',
        'edit' => 'تعديل',
        'delete' => 'حذف',
        'update' => 'تحديث',
        'logout' => 'تسجيل الخروج',
        'date'=>'الوقت',
        'addh'=>'اضافة مكان ثقافي',
        'adde'=>'اضافة مكان ترفيهي',
        'footer'=> 'صفحة المشرف المسؤول عن اضافة الاماكن الثقافية و الترفيهية',
        'show'=>'إظهار المزيد',
    ],
];

$current_lang = $_SESSION['lang'];
$text = $translations[$current_lang];

?>

<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $text['dashboard']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            
            margin: 0;
            padding: 0;
            direction: <?php echo $current_lang === 'ar' ? 'rtl' : 'ltr'; ?>;
            text-align: <?php echo $current_lang === 'ar' ? 'right' : 'left'; ?>;
            
        }
        body::before {
            
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('uploads\\S.jpg') ;
            opacity: 0.4; /* Set the opacity of the background image */
            z-index: -1; 
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
        .navbar img {
            height: 50px;
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
        td img {
            width: 70px;
            height: auto;
            border-radius: 4px;
        }
        
        .add-link,  .action-link {
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
        .add-link:hover, .action-link:hover {
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
            transition: background-color 0.3s;
        }
        .action-link:hover {
            background-color: white;
            color: black;
        }
        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 50px;
            background-color: #9CB1A7;
            color: #ffffff;
        }
         .language-switcher {
            display: flex;
            gap: 10px;
        }
        .hidden-row {
        display: none;
    }
    .hidden-row2 {
        display: none;
    }
    .b:hover{
        cursor: pointer;
        display: block;
        
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
    </style>
</head>
<body >

<div class="navbar">
    <!-- Logo aligned to the left -->
    <a href="supervisor_main.php?lang=<?php echo $_GET['lang'];?>"  class="logo">
        <img src="uploads/logo1.png" alt="Logo" style="width:200px;height:90px">
    </a>
    
    <!-- Icons aligned to the right -->
    <div class="links">
        
        
        <?php if ($_GET['lang'] == 'en') { ?>
            <a href="supervisor_main.php?lang=ar" class="logout-icon">
                <img src="uploads/lang.png" style="width:50px;height:50px;" alt="Switch to Arabic">
            </a>
        <?php } else { ?>
            <a href="supervisor_main.php?lang=en" class="logout-icon">
                <img src="uploads/lang.png" style="width:50px;height:50px;" alt="Switch to English">
            </a>
        <?php } ?>
        <a href="logout.php" class="logout-icon">
            <img src="uploads/logout.png" style="width:40px;height:40px;" alt="Logout">
        </a>
    </div>
</div>

<div class="container">
    <h2><?php echo $text['welcom']; ?>, <?php echo $n?></h2>

    <!-- Heritage Sites Section -->
    <div class="section">
        <h3><?php echo $text['heritage_sites']; ?></h3>
        <table>
            <thead>
                <tr>
                <th><?php echo $text['name']; ?></th>
                <th><?php echo $text['description']; ?></th>
                <th><?php echo $text['image']; ?></th>
                <th><?php echo $text['actions']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count2 = 0;
                while($heritage = mysqli_fetch_assoc($heritages_result)): 
                    $count2++;
                    if ($_GET['lang'] == 'en' ) { ?>
                <tr class="<?php echo ($count2 > 4) ? 'hidden-row2' : ''; ?>">
                    <td><?php echo htmlspecialchars($heritage['Name']); ?></td>
                    
                    <td><?php echo htmlspecialchars($heritage['Description']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($heritage['Image']); ?>" alt="Image"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="edit_heritage_site.php?id=<?php echo $heritage['Id']; ?>&lang=<?php echo $_GET['lang'];?>"><?php echo $text['edit']; ?></a>
                            <a class="action-link" href="delete_heritage_site.php?id=<?php echo $heritage['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this heritage site?');"><?php echo $text['delete']; ?></a>
                        </div>
                    </td>
                </tr>
                <?php } else { ?> 
                    <tr class="<?php echo ($count > 4) ? 'hidden-row2' : ''; ?>">
                    <td><?php echo htmlspecialchars($heritage['Name_ar']); ?></td>
                    
                    <td><?php echo htmlspecialchars($heritage['Description_ar']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($heritage['Image']); ?>" alt="Image"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="edit_heritage_site.php?id=<?php echo $heritage['Id']; ?>&lang=<?php echo $_GET['lang'];?>"><?php echo $text['edit']; ?></a>
                            <a class="action-link" href="delete_heritage_site.php?id=<?php echo $heritage['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this heritage site?');"><?php echo $text['delete']; ?></a>
                        </div>
                    </td>
                </tr>
            <?php }
            endwhile; ?>
            </tbody>
        </table>
        <div class="see-more-container" style="text-align: center; margin-top: 20px;">
           <b> <u style="color:cornflowerblue"><a id="see-more-button2" style="color:cornflowerblue" class="b" onclick="showAllRows2()"><?php echo $text['show']; ?></a></u></b>
        </div>
        <br>

        <a class="add-link" href="add_heritage_site.php?lang=<?php echo $_GET['lang'];?>"><?php echo $text['addh']; ?></a>
    </div>

    <!-- Events Section -->
    <div class="section">
        <h3><?php echo $text['events']; ?></h3>
        <table>
            <thead>
                <tr>



                    
                    <th><?php echo $text['name']; ?></th>
                <th><?php echo $text['description']; ?></th>
                <th><?php echo $text['date']; ?></th>
                <th><?php echo $text['image']; ?></th>
                <th><?php echo $text['actions']; ?></th>
                </tr>
            </thead>
            <tbody>
           
                <?php 
                $count = 0;
                while($event = mysqli_fetch_assoc($events_result)):
                    $count++;
                    if ($_GET['lang'] == 'en' ) { ?>
                <tr class="<?php echo ($count > 4) ? 'hidden-row' : ''; ?>">
                    <td><?php echo htmlspecialchars($event['Name']); ?></td>

                    <td><?php echo htmlspecialchars($event['Description']); ?></td>
                    <td><?php echo htmlspecialchars($event['Date']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($event['Image']); ?>" alt="Image"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="edit_event.php?id=<?php echo $event['Id']; ?>&lang=<?php echo $_GET['lang'];?>"><?php echo $text['edit']; ?></a>
                            <a class="action-link" href="delete_event.php?id=<?php echo $event['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this event?');"><?php echo $text['delete']; ?></a>
                        </div>
                    </td>
                    
                </tr>
                <?php } else { ?>
                    <tr class="<?php echo ($count > 4) ? 'hidden-row' : ''; ?>">
                    <td><?php echo htmlspecialchars($event['Name_ar']); ?></td>

                    <td><?php echo htmlspecialchars($event['Description_ar']); ?></td>
                    <td><?php echo htmlspecialchars($event['Date']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($event['Image']); ?>" alt="Image"></td>
                    <td>
                        <div class="action-buttons">
                            <a class="action-link" href="edit_event.php?id=<?php echo $event['Id']; ?>&lang=<?php echo $_GET['lang'];?>"><?php echo $text['edit']; ?></a>
                            <a class="action-link" href="delete_event.php?id=<?php echo $event['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this event?');"><?php echo $text['delete']; ?></a>
                        </div>
                    </td>
                    
                </tr>
                    
                    
                    <?php } endwhile; ?>
            </tbody>
        </table>
        <div class="see-more-container" style="text-align: center; margin-top: 20px;">
           <b> <u style="color:cornflowerblue"><a id="see-more-button" style="color:cornflowerblue" class="b" onclick="showAllRows()"><?php echo $text['show']; ?></a></u></b>
        </div>
        <br>
        <a class="add-link" href="add_event.php?lang=<?php echo $_GET['lang'];?>"><?php echo $text['adde']; ?></a>
    </div>
</div>

<div class="footer">
    <p><?php echo $text['footer']; ?></p>
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
    function showAllRows2() {
        // Get all rows with the class 'hidden-row' and set their display to table-row
        const hiddenRows = document.querySelectorAll('.hidden-row2');
        hiddenRows.forEach(row => row.style.display = 'table-row');
        
        // Hide the "Show More" button after all rows are visible
        document.getElementById('see-more-button2').style.display = 'none';
    }
</script>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
