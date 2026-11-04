<?php
// Start the session
session_start();

// Check if user is logged in and is admin (manager)
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'manager') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'db.php';

// Fetch supervisors and managers
$supervisors_query = "SELECT * FROM `users` WHERE UserType = 'supervisor'";
$supervisors_result = mysqli_query($conn, $supervisors_query);

$managers_query = "SELECT * FROM `users` WHERE UserType = 'manager'";
$managers_result = mysqli_query($conn, $managers_query);

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
        'Supervisors' => 'Supervisors',
        'Managers' => 'Managers',
        'addsupervisors' => 'Add supervisor',
        'addmanager' => 'Add manager',
        'control' => 'control visiter Dashbaroad',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'update' => 'Update',
        'logout' => 'Logout',
        'date'=>'date',
        'addh'=>'Add New Cultural places',
        'adde'=>'Add New Event',
        'footer'=>'Managing Supervisors and Managers to enhance the system is effectiveness.',
        'show'=>'Show more',
    ],
    'ar' => [
        'dashboard' => 'الصفحة الرئيسية',
        'heritage_sites' => 'المواقع الثقافية',
        'welcom'=> 'مرحبا',
        'Supervisors' => 'المشرفين',
        'Managers' => 'المدراء',
        'addsupervisors' => 'إضافة مشرف',
        'addmanager' => 'إضافة مدير',
        'control' => 'التحكم في واجهة المستخدم',
        'edit' => 'تعديل',
        'delete' => 'حذف',
        'update' => 'تحديث',
        'logout' => 'تسجيل الخروج',
        'date'=>'الوقت',
        'addh'=>'اضافة مكان ثقافي',
        'adde'=>'اضافة مكان ترفيهي',
        'footer'=> 'إدارة المشرفين والمديرين لتعزيز فعالية النظام.',
        'show'=>'إظهار المزيد',
    ],
];

$current_lang = $_SESSION['lang'];
$text = $translations[$current_lang];


// Close the database connection
mysqli_close($conn);
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
            background: url('uploads\\A32.jpg') ;
            opacity: 0.4; /* Set the opacity of the background image */
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
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        li a {
            color: #9CB1A7;
            text-decoration: none;
            font-weight: bold;
        }
        li a:hover {
            color: black;
            text-decoration: underline;
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
            
            color: black;
        }
        .footer {
            text-align: center;
            padding: 20px;
            margin-bottom: 0px;
            background-color: #9CB1A7;
            color: #ffffff;
            position: bottom;
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="navbar">
    <!-- Logo aligned to the left -->
    <a  class="logo">
        <img src="uploads/logo1.png" alt="Logo" style="width:200px;height:90px">
    </a>
    
    <!-- Icons aligned to the right -->
    <div class="links">
        
        
        <?php if ($_GET['lang'] == 'en') { ?>
            <a href="admin_main.php?lang=ar" class="logout-icon">
                <img src="uploads/lang.png" style="width:50px;height:50px;" alt="Switch to Arabic">
            </a>
        <?php } else { ?>
            <a href="admin_main.php?lang=en" class="logout-icon">
                <img src="uploads/lang.png" style="width:50px;height:50px;" alt="Switch to English">
            </a>
        <?php } ?>
        <a href="logout.php" class="logout-icon">
            <img src="uploads/logout.png" style="width:40px;height:40px;" alt="Logout">
        </a>
    </div>
</div>

<div class="container">
    <h2><?php echo $text['welcom']; ?>, <?php echo $_SESSION['nameuser'];?></h2>

    <!-- Supervisors Section -->
    <div class="section">
        <h3><?php echo $text['Supervisors']; ?></h3>
        <ul>
            <?php while ($supervisor = mysqli_fetch_assoc($supervisors_result)): ?>
                <li>
                    <?php echo htmlspecialchars($supervisor['Name']); ?> (<?php echo htmlspecialchars($supervisor['Email']); ?>)
                    <a href="delete_user.php?id=<?php echo $supervisor['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this supervisor?');"><?php echo $text['delete']; ?></a>
                </li>
            <?php endwhile; ?>
        </ul>
        <a class="add-link" href="add_supervisor.php?lang=<?php echo $_GET['lang'];?>"><?php echo $text['addsupervisors']; ?></a>
    </div>

    <!-- Managers Section -->
    <div class="section">
        <h3><?php echo $text['Managers']; ?></h3>
        <ul>
            <?php while ($manager = mysqli_fetch_assoc($managers_result)): ?>
                <li>
                    <?php echo htmlspecialchars($manager['Name']); ?> (<?php echo htmlspecialchars($manager['Email']); ?>)
                    <a href="delete_user.php?id=<?php echo $manager['Id']; ?>&lang=<?php echo $_GET['lang'];?>" onclick="return confirm('Are you sure you want to delete this manager?');"><?php echo $text['delete']; ?></a>
                </li>
            <?php endwhile; ?>
        </ul>
        <a class="add-link" href="add_manager.php?lang=<?php echo $_GET['lang'];?>"><?php echo $text['addmanager']; ?></a>
    </div>
    <br><br><br>
    <a class="add-link" href="Manager%20Control%20Heritage.php?lang=<?php echo $_GET['lang'];?>"><?php echo $text['control']; ?></a>
</div>

<div class="footer">
    <p><?php echo $text['footer']; ?></p>
</div>

</body>
</html>
