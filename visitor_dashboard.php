<?php
// Include the database connection file
include 'db.php';
session_start();
// Fetch regions from the database

if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] != 'visitor' && $_SESSION['user_type'] != 'manager')) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM Regions";
$regions = mysqli_query($conn, $query);

$v="SELECT * FROM video";
$vresult=mysqli_query($conn, $v);

$heritages_query = "SELECT * FROM HeritageSites where Display= 1";
$heritages_result = mysqli_query($conn, $heritages_query);

$event = "SELECT * FROM events where Display= 1";
$eventss = mysqli_query($conn, $event);


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
        'dashboard' => 'Visitor Dashboard',
        'Region' => 'My Region',
        'Welcom'=> 'Welcome to the heart of the Western Region',
        'Where' => 'where the charm of history meets the beauty of nature and the magic of authenticity. Discover our rich cultural diversity, warm Arabian hospitality, and breathtaking landmarks that tell timeless stories. Whether you seek adventure, relaxation, or a journey through heritage, you’ll find an unforgettable experience at every corner. Let us take you on an inspiring journey to a land that proudly celebrates its heritage and amazes its visitors with its beauty.',
        'Famous' => 'Famous places',
        'Explore' => 'Explore Regions',
        'How' => 'How to Pay in Saudi?',
        'Currency' => 'Currency',
        'Exchnge' => 'Exchnge rate in Saudi Arabia',
        'ATM' => 'ATM Location',
        'Currencyd' => 'The national currency of Saudi Arabia is the Saudi Riyal (SAR), which is divided into 100 halalas. Paper notes are available.....',
        'Exchnged' => 'The national currency in the Kingdom of Saudi Arabia is the Saudi Riyal (SAR), 1 US Dollar equivalent 3.75 Saudi Riyals (fixed rate)...',
        'ATMd'=>'ATMs are spread all over the Kingdom of Saudi Arabia, check Google Maps to find the nearest ATM to you.',
        'More'=>'More details',
        'MAP'=>'Google Map',
        'Footer'=>'The page of the administrator responsible for adding cultural and entertainment places',
        'About'=>'About Us',
    ],
    'ar' => [
        'dashboard' => 'واجهة الزائر',
        'Region' => 'المدن',
        'Welcom'=> 'مرحباً بكم في قلب المنطقة الغربية',
        'Where' => 'حيث يلتقي سحر التاريخ بجمال الطبيعة وسحر الأصالة. اكتشف تنوعنا الثقافي الغني وكرم الضيافة العربية ومعالمنا الخلابة التي تحكي قصصًا خالدة. سواء كنت تبحث عن المغامرة أو الاسترخاء أو رحلة عبر التراث، فستجد تجربة لا تُنسى في كل زاوية. دعنا نأخذك في رحلة ملهمة إلى أرض تحتفل بفخر بتراثها وتدهش زوارها بجمالها.',
        'Famous' => 'الاماكن الشهيرة',
        'Explore' => 'تصفح المدن',
        'How' => 'كيف يمكنك الدفع بالسعودية؟',
        'Currency' => 'العملة',
        'Exchnge' => 'الصرف',
        'ATM' => 'مواقع اجهزة صراف آلي',
        'Currencyd' => 'العملة الوطنية للمملكة العربية السعودية هي الريال السعودي (SAR)، والذي ينقسم إلى 100 هللة. تتوفر الأوراق النقدية.....',
        'Exchnged' => 'العملة الوطنية في المملكة العربية السعودية هي الريال السعودي (SAR)، 1 دولار أمريكي يعادل 3.75 ريال سعودي (سعر ثابت)...',
        'ATMd'=>'تنتشر أجهزة الصراف الآلي في كافة أنحاء المملكة العربية السعودية، يمكنك التحقق من خرائط جوجل للعثور على أقرب جهاز صراف آلي إليك.',
        'More'=>'لمزيد من التفاصيل',
        'MAP'=>'قوقل ماب',
        'Footer'=>'© 2024 اكتشف المملكة العربية السعودية. جميع الحقوق محفوظة.',
        'About'=>'من نحن',
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
    <title><?php echo $text['dashboard']; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
            direction: <?php echo $current_lang === 'ar' ? 'rtl' : 'ltr'; ?>;
            text-align: <?php echo $current_lang === 'ar' ? 'right' : 'left'; ?>;
        }
        .language-switcher {
            display: flex;
            gap: 10px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #9CB1A7;
            padding: 15px 30px;
            color: white;
        }
        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .navbar .links {
            display: flex;
            align-items: center;
        }
        .navbar .links a, .navbar .links .dropdown {
            color: black;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .navbar .links .dropdown {
            position: relative;
            cursor: pointer;
        }
        .navbar .links .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .navbar .links .dropdown:hover .dropdown-content {
            display: block;
        }
        .navbar .links .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .navbar .links .dropdown-content a:hover {
            background-color: #ddd;
        }
        .hero-section {
            position: relative;
            height: 500px;
            background-image: url('hero_video_placeholder.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .section-item {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            
        }

        .section-item:hover {
            transform: scale(1.02);
        }

        .section-item h2,
        .section-item h1 {
            margin: 10px 0;
            color: #004A77;
        }
       

        .section-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .hero-section video {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .useful-info-section {
            padding: 50px 20px;
            background-color: #f3f3f3;
            text-align: center;
        }

        .useful-info-section h2 {
            color: #004A77;
            margin-bottom: 40px;
        }
        .section-container {
            display: grid;
            grid-template-columns: 400px 400px 400px;
            gap: 80px;
            margin:30px;
            height:530px;
        }
        .hero-section .hero-text {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 8px;
        }
        .heritage-container, .regions-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 20px;
        }
        .card-content h3 {
            color: #2b2d42;
            margin: 0;
        }
        .card-content p {
            color: #333;
        }
        .footer {
            background-color: #9CB1A7;
            color: black;
            padding: 40px 0;
            text-align: center;
        }
        .footer-links {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 0;
            margin: 20px 0;
        }
        .footer-links li a {
            color: black;
            text-decoration: none;
            font-weight: bold;
        }
        .footer-links li a:hover {
            text-decoration: underline;
        }
        .about-us-box {
        position: fixed;
        bottom: -100%;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2);
        padding-right: 50px;
        transition: bottom 0.4s ease-in-out;
        z-index: 999;
    }

    .about-us-box h2 {
        color: #004A77;
        text-align: center;
        margin-top: 0;
    }

    .about-us-box p {
        color: #333;
        text-align: center;
        font-size: 16px;
    }

    .about-us-box .close-btn {
        position: absolute;
        top: 0px;
        right: 50px;
        color: #FF3E3E;
        font-size: 50px;
        font-weight: bold;
        cursor: pointer;
        text-align: center;
        line-height: 1;
    }

    .about-us-box .close-btn:hover {
        color: #FF0000;
    }

    .about-us-box.open {
        bottom: 0;
    }
    </style>
</head>
<body>
    <div class="navbar">
    <img src="uploads/logo1.png" alt="Logo" style="width:200px;height:90px">
        <div class="links">
            
            <div class="dropdown">
                <p style="font-size:20px;"><?php echo $text['Region']; ?></p>
                <div class="dropdown-content">
                <?php while($region = mysqli_fetch_assoc($regions)): ?>
                    <?php if ($_GET['lang'] == 'en' ) { ?>
                    <a href="region_details.php?id=<?php echo $region['Id'];?>&lang=<?php echo $_GET['lang'];?>" style="width:50px;height:50px"><?php echo $region['Name'];?></a>
                    <?php } else { ?>
                        <a href="region_details.php?id=<?php echo $region['Id'];?>&lang=<?php echo $_GET['lang'];?>" style="width:50px;height:50px"><?php echo $region['Name_ar'];?></a>
<?php } ?>
                    <?php endwhile; ?>
                    
                </div>
            </div>
            <?php if ($_GET['lang'] == 'en' ) { ?>
        <a href="?lang=ar" class="logout-icon"><img src="uploads\\lang.png" style="width:50px;height:50px; "alt="Heritage Site 2"></a>
        <?php } else{ ?>
            <a href="?lang=en" class="logout-icon"><img src="uploads\\lang.png" style="width:50px;height:50px;" alt="Heritage Site 2"></a>
<?php } ?>
            <a href="d.php?lang=<?php echo $_GET['lang'];?>"><img src="uploads\\travel.png" style="width:40px;height:40px" alt="Heritage Site 2"></a>

            <?php if($_SESSION['user_type']=='manager'){?>
                <a href="admin_main.php?lang=<?php echo $_GET['lang'];?>" style="font-size:20px;" class="logout-icon">Dashboard</a><?php } ?>

            <?php if($_SESSION['user_type']!='manager'){?>
            <a href="edit_profile.php?lang=<?php echo $_GET['lang'];?>"><img src="uploads\\user.png" style="width:40px;height:40px" alt="Heritage Site 2"></a><?php } ?>
            <a href="logout.php" class="logout-icon"><img src="uploads\\logout.png" style="width:40px;height:40px" alt="Heritage Site 2"></a>
            
        
        </div>
    </div>

    <div class="hero-section">
        <video autoplay muted loop controls preload="auto">
            <?php $vs = mysqli_fetch_assoc($vresult)?>
            <source src="uploads\\<?php echo $vs['name'];?>" type="video/mp4">
            <h2><?php echo $vs['name'];?> </h2>
        </video>
        <div class="hero-text">
            <?php if ($_GET['lang'] == 'en' ) { ?>
            <h1><?php echo $vs['text']?></h1>
            <p><?php echo $vs['text2']?></p>
            <?php } else { ?>
                <h1><?php echo $vs['text_ar']?></h1>
            <p><?php echo $vs['text2_ar']?></p>
            <?php } ?>
        </div>
    </div>
    <div style=" margin: 30px; height:90px; width:1420px; ">
        <p style=" font-size: 35px; font-family: Algerian"><?php echo $text['Welcom']; ?></p>
        <p style=" font-size: 22px; padding-left: 10px; font-family: Bahnschrift Condensed"><?php echo $text['Where']; ?></p>
        </div><br><br><br>
    <h2>&ensp;&ensp;&ensp;&ensp;&ensp;<?php echo $text['Famous']; ?></h2>
    <div class="heritage-container">
    <?php while($heritage = mysqli_fetch_assoc($heritages_result)): 
         if ($_GET['lang'] == 'en' ) { ?>
        
        <div class="card">
        <a href="DetailsAndCommentsPage_h.php?id=<?php echo $heritage['Id']; ?>&lang=<?php echo $_GET['lang'];?>" style="text-decoration:none">
            <img src="uploads/<?php echo $heritage['Image']; ?>" alt="Image">
            <div class="card-content">
                <h3><?php echo htmlspecialchars($heritage['Name']); ?></h3>
               
            </div>
            
            </a>
            <?php } else { ?>
                <div class="card">
        <a href="DetailsAndCommentsPage_h.php?id=<?php echo $heritage['Id']; ?>&lang=<?php echo $_GET['lang'];?>" style="text-decoration:none">
            <img src="uploads/<?php echo $heritage['Image']; ?>" alt="Image">
            <div class="card-content">
                <h3><?php echo htmlspecialchars($heritage['Name_ar']); ?></h3>
               
            </div>
            <?php } ?>
            </a>
        </div>
        <?php endwhile; ?>
        
    </div>
    <div class="heritage-container">
    <?php while($eventsss = mysqli_fetch_assoc($eventss)): 
         if ($_GET['lang'] == 'en' ) { ?>
        
        <div class="card">
        <a href="DetailsAndCommentsPage_e.php?id=<?php echo $eventsss['Id']; ?>&lang=<?php echo $_GET['lang'];?>" style="text-decoration:none">
            <img src="uploads/<?php echo $eventsss['Image']; ?>" alt="Image">
            <div class="card-content">
                <h3><?php echo htmlspecialchars($eventsss['Name']); ?></h3>
               
            </div>
            
            </a>
            <?php } else { ?>
                <div class="card">
        <a href="DetailsAndCommentsPage_e.php?id=<?php echo $eventsss['Id']; ?>&lang=<?php echo $_GET['lang'];?>" style="text-decoration:none">
            <img src="uploads/<?php echo $eventsss['Image']; ?>" alt="Image">
            <div class="card-content">
                <h3><?php echo htmlspecialchars($eventsss['Name_ar']); ?></h3>
               
            </div>
            <?php } ?>
            </a>
        </div>
        <?php endwhile; ?>
        
    </div>
    <h2>&ensp;&ensp;&ensp;&ensp;&ensp;<?php echo $text['Explore']; ?></h2>
    <div class="regions-container">
        
        <?php 
        $query1 = "SELECT * FROM Regions";
        $regions1 = mysqli_query($conn, $query1);
        
        
        while($region1 = mysqli_fetch_assoc($regions1)): 
            if ($_GET['lang'] == 'en' ) {?>
            <a href="region_details.php?id=<?php echo $region1['Id']; ?>&lang=<?php echo $lang ?>">
            <div class="card">
                <img src="uploads/<?php echo $region1['Path']; ?>" alt="<?php echo $region1['Name']; ?>">
                <div class="card-content">
                    <h3><?php echo $region1['Name']; ?></h3>
                    
                </div>
                <?php } else { ?>
                    <a href="region_details.php?id=<?php echo $region1['Id']; ?>&lang=<?php echo $lang ?>">
            <div class="card">
                <img src="uploads/<?php echo $region1['Path']; ?>" alt="<?php echo $region1['Name_ar']; ?>">
                <div class="card-content">
                    <h3><?php echo $region1['Name_ar']; ?></h3>
                    
                </div><?php } ?>
            </div></a>
        <?php endwhile; ?>
    </div>
    <h2>&ensp;&ensp;&ensp;&ensp;&ensp;<?php echo $text['How']; ?></h2>
    <section id="how-to-pay" class="useful-info-section">
        
        <div class="section-container">
        
            <div class="section-item">
            <a href="d.php?lang=<?php echo $_GET['lang'];?>" style="color: black; text-decoration:none;">
                <h2><?php echo $text['Currency']; ?></h2>
                <p style="font-size: 20px"><?php echo $text['Currencyd']; ?><span style="color: #004A77;"><?php echo $text['More']; ?></span></p>
                <img src="uploads/c.jpg" style="width:375px; height:300px;" alt="Credit Card">
                </a></div>
            <div class="section-item">
            <a href="d.php?lang=<?php echo $_GET['lang'];?>" style="color: black; text-decoration:none;">
                <h2><?php echo $text['Exchnge']; ?></h2>
                <p style="font-size: 20px"><?php echo $text['Exchnged']; ?><span style="color: #004A77;"><?php echo $text['More']; ?></span</p>
               <br><br> <img src="uploads/sell.jpg" style="width:375px; height:300px;" alt="Credit Card">
                </a></div>
            <div class="section-item">
            <a href="https://www.google.com/maps/search/atm/@24.4349302,39.6444278,14z/data=!3m1!4b1?entry=ttu&g_ep=EgoyMDI0MTIwNC4wIKXMDSoASAFQAw%3D%3D" style="color: black; text-decoration:none;">
                <h2><?php echo $text['ATM']; ?></h2>
                <p style="font-size: 20px"><?php echo $text['ATMd']; ?><span style="color: #004A77;"><?php echo $text['MAP']; ?></span</p>
               <br><br><br> <img src="uploads/ATM.jpeg" style="width:375px; height:300px;" alt="Credit Card">
            </a></div>
        </div>
    </section>
    

    <div class="footer">
    <ul class="footer-links">
        <li><a href="#"><img src="uploads\insta.png" style=" width:35px; height:35px"></a></li>
        <li><a href="#"><img src="uploads\what.png" style=" width:35px; height:35px"></a></li>
        <li><a href="#"><img src="uploads\x.png" style=" width:35px; height:35px"></a></li>
        <li style="padding-top: 10px;">
            <a href="#" onclick="toggleAboutUs(event)"><?php echo $text['About']; ?></a>
        </li>
    </ul>
    <p><?php echo $text['Footer']; ?></p>
</div>

<!-- Hidden About Us Box -->
<div id="about-us-box" class="about-us-box">
<?php if ($_GET['lang'] == 'en' ) { ?>
    <span class="close-btn" onclick="toggleAboutUs(event)">×</span>
    <h2><?php echo $text['About']; ?></h2>
    <p>We are your digital gateway to discovering the beauty of the western region of Saudi Arabia. We provide a comprehensive guide showcasing the top entertainment and cultural destinations in the region.

Our goal is to enhance your travel experience by offering accurate and detailed information about tourist attractions, activities, and festivals. We also provide a complete travel guide to help you plan your journey effortlessly, ensuring a rich and enjoyable experience.

Whether you’re looking to relax on beaches, explore cultural heritage, or immerse yourself in family-friendly activities, we are here to be your perfect travel companion.</p>
<?php } else { ?>
    <span class="close-btn" onclick="toggleAboutUs(event)">×</span>
    <h2><?php echo $text['About']; ?></h2>
    <p>نحن بوابة السفر الرقمية الخاصة بك لاكتشاف جمال المنطقة الغربية من المملكة العربية السعودية. نقدم دليلاً شاملاً يعرض أفضل الوجهات الترفيهية والثقافية في المنطقة.

هدفنا هو تعزيز تجربة سفرك من خلال تقديم معلومات دقيقة ومفصلة حول المعالم السياحية والأنشطة والمهرجانات. كما نقدم دليل سفر كامل لمساعدتك في التخطيط لرحلتك دون عناء، وضمان تجربة غنية وممتعة.

سواء كنت تبحث عن الاسترخاء على الشواطئ ، أو استكشاف التراث الثقافي، أو الانغماس في الأنشطة المناسبة للعائلة، فنحن هنا لنكون رفيق سفرك المثالي.</p>
    <?php } ?>
</div>

<script>
    // Function to toggle the About Us box
     // Function to toggle the About Us box
     function toggleAboutUs(event) {
        event.preventDefault(); // Prevent default anchor behavior
        const aboutUsBox = document.getElementById('about-us-box');
        aboutUsBox.classList.toggle('open');
    }
</script>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
