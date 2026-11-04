<?php
// Include the database connection file
include 'db.php';
session_start();
// Fetch regions from the database



$query = "SELECT * FROM Regions";
$regions = mysqli_query($conn, $query);


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
        'dashboard' => 'Your travel guide',
        'Region'=> 'Region',
        'Your' => 'Your travel guide',
        'Important'=> 'Important information during your visit',
        'Visiting' => 'Visiting the Western Region of Saudi Arabia is a great opportunity to enjoy its authentic heritage, hospitality, stunning scenery and visit religious cultural sites. To help you discover the Western Region of Saudi Arabia with pleasure and ease, we have collected some information that will benefit you during your travel, shopping and communication with the residents.',
        'A' => 'A Guide to Saudi’s Seasons',
        'When' => 'When are you visiting?',
        'Summer' => 'Summer - Marine Adventures',
        'Despite' => 'Despite the summer heat, the Western Region offers a unique experience. Enjoy the golden sun on the beaches of Jeddah and Dhahab, where you can go diving and see the amazing coral reefs. Temperatures can reach 45 degrees Celsius, but the high humidity gives a refreshing feeling when relaxing by the sea.',
        'Winter' => 'Winter - The Magic of the Mountains',
        'Do' => 'Do not forget the winter in the western region, where the weather is cold and moderate. Temperatures range between 10-20 degrees Celsius, giving you the opportunity to explore the mountains in a magical atmosphere. You can visit parks such as King Faisal Park in Taif and enjoy the distinctive winter atmosphere.',
        'Spring' => 'Spring - The Time of Flowers',
        'When2' => 'When spring blooms between the Sarawat Mountains and the Red Sea coast, flowers bloom and fill the air with their fragrance. Visitors enjoy mild weather and temperatures ranging from 15-30 degrees Celsius, making it the perfect time to explore places like Taif, where you can visit rose farms and enjoy the beauty of nature.',
        'Autumn'=>'Autumn - The Colors of Nature',
        'As'=>'As autumn begins, the colors change and temperatures begin to drop. The weather becomes pleasant, making it the perfect time to wander through the traditional markets of Medina or explore the historical landmarks of Mecca. The moderate climate (20-30 degrees Celsius) invites you to enjoy unique cultural experiences',
        'How'=>'How to Pay in Saudi?',
        'Currency' => 'Currency',
        'The' => 'The national currency of Saudi Arabia is the Saudi Riyal (SAR), which is divided into 100 halalas. Paper notes are available in denominations of 1, 5, 20, 50, 100, 200 and 500 riyals, while coins are available in denominations of 1 or 2 riyals, and 1, 5, 10, 25 and 50 halalas.',
        'Exchange'=>'Exchange rate in Saudi Arabia',
        'The2' => 'The US dollar is equivalent to 3.75 Saudi Riyals (fixed rate). Check out this (website link in words) (Saudi Riyal conversion calculator site) to help you calculate the exchange rate and plan your travel budget. All banks in Saudi Arabia offer currency exchange services. You can also find exchange offices at airports, some shopping malls, and other locations throughout the Kingdom. Banking hours are usually from 9:30 am to 4:30 pm Saturday to Thursday. Exchange offices are often open later, but may charge higher commission fees.',
        'Can' => 'Can I use credit cards in Saudi Arabia?',
        'All' => 'All banks in the Kingdom offer currency exchange services, and you can also find currency exchange offices at airports, some shopping malls, and various other locations throughout the Kingdom. Banks are generally open Saturday through Thursday between 9:30 a.m. and 4:30 p.m. (Currency exchange offices are open later, and may charge higher fees.) ATMs are widely available, and credit cards, including Visa, MasterCard, and American Express, are accepted throughout the Kingdom, and many businesses also accept digital payment methods, such as Apple Pay.',
        'Saudi' => 'Saudi Healthcare Tips',
        'Information' => 'Information about healthcare in the Kingdom',
        'If' => 'If you need medical assistance, you can visit any hospital, clinic or dispensary, many of which have English-speaking staff. You can also contact your embassy for assistance, and be sure to ensure that your travel insurance covers healthcare expenses.',
        'Where' => 'Where can I buy medicines in Saudi Arabia?',
        'Common' => 'Common medicines such as pain relievers, cough syrups and allergy medications can be purchased without a prescription in most pharmacies (which cover all areas and neighborhoods in Saudi Arabia, but more effective medicines may require a prescription).',
        'Healthcare' => 'Healthcare app',
        'Emergency' => 'Emergency Numbers',
        'Select' => 'Select Emergency Service',
        'Police'=>'Police',
        'Ambulance' => 'Ambulance',
        'Fire' => 'Fire Department',
        'For' => 'For Police assistance, dial 999 ',
        'For2'=>'For Ambulance services, dial 997 ',
        'For3' => 'For Fire Department, dial 998 ',
        'Useful' => 'Useful Numbers',
        'Tourism'=>'Tourism Call Center',
        'Tourism2' => 'Tourism Call Center: ',
        'International' => 'International Tourism Call Center: ',
        'Ministry' => 'Ministry of Hajj and Umrah Customer Service: .',
        'Public' => 'Public Security',
        'Saudi2'=>'Saudi Public Security: ',
        'General' => 'General Department of Passports: ',
        'Emergency2' => 'Emergency Medical Consultations: ',
        'Najm' => 'Najm Company: ',
        'Other'=>'Other useful numbers',
        'Municipality' => 'Municipality services: ',
        'Ministry2' => 'Ministry of Transport emergencies: ',
        'Ministry3'=>'Ministry of Commerce Consumer Contact Center: ',
        'General2' => 'General inquiries: ',
        'About'=>'About Us',
        'Footer'=>'© 2024 Discover KSA. All rights reserved.',
    ],
    'ar' => [
    
        'dashboard' => 'دليل سقرك',
        'Region'=> 'المدن',
        'Your' => 'دليلك للسفر',
        'Important'=> 'معلومات هامة أثناء سفرك',
        'Visiting' => 'تعتبر زيارة المنطقة الغربية من المملكة العربية السعودية فرصة رائعة للاستمتاع بتراثها الأصيل وكرم ضيافتها ومناظرها الخلابة وزيارة المعالم الدينية والثقافية، ولمساعدتك على اكتشاف المنطقة الغربية من المملكة العربية السعودية بكل متعة وسهولة، جمعنا لك بعض المعلومات التي ستفيدك أثناء سفرك وتسوقك وتواصلك مع السكان.',
        'A' => 'فصول السنة في المنطقة الغربية',
        'When' => 'متى ستقوم بالزيارة؟',
        'Summer' => 'الصيف - المغامرات البحرية',
        'Despite' => 'رغم حرارة الصيف، تقدم المنطقة الغربية تجربة فريدة من نوعها، استمتع بأشعة الشمس الذهبية على شواطئ جدة ودهب، حيث يمكنك ممارسة رياضة الغوص ومشاهدة الشعاب المرجانية المذهلة، حيث تصل درجات الحرارة إلى 45 درجة مئوية، لكن الرطوبة العالية تمنح شعوراً بالانتعاش عند الاسترخاء بجانب البحر.',
        'Winter' => 'الشتاء - سحر الجبال',
        'Do' => 'ولا تنس فصل الشتاء في المنطقة الغربية حيث الطقس البارد والمعتدل حيث تتراوح درجات الحرارة بين 10-20 درجة مئوية مما يتيح لك فرصة استكشاف الجبال في أجواء ساحرة ويمكنك زيارة الحدائق مثل حديقة الملك فيصل في الطائف والاستمتاع بالأجواء الشتوية المميزة.',
        'Spring' => 'الربيع - وقت الزهور',
        'When2' => 'عندما يزهر الربيع بين جبال السروات وساحل البحر الأحمر تتفتح الأزهار وتملأ الأجواء بعطرها، ويستمتع الزوار بالطقس المعتدل ودرجات الحرارة التي تتراوح بين 15 و30 درجة مئوية، ما يجعله الوقت المثالي لاستكشاف أماكن مثل الطائف، حيث يمكنك زيارة مزارع الورد والاستمتاع بجمال الطبيعة.',
        'Autumn'=>'الخريف - ألوان الطبيعة',
        'As'=>'مع بداية فصل الخريف تتغير الألوان وتبدأ درجات الحرارة في الانخفاض، ويصبح الطقس لطيفًا، مما يجعله الوقت المثالي للتجول في الأسواق التقليدية في المدينة المنورة أو استكشاف المعالم التاريخية في مكة المكرمة. ويدعوك المناخ المعتدل (20-30 درجة مئوية) إلى الاستمتاع بتجارب ثقافية فريدة من نوعها.',
        'How'=>'كيفية الدفع في السعودية؟',
        'Currency' => 'العملة',
        'The' => 'العملة الوطنية للمملكة العربية السعودية هي الريال السعودي (SAR)، والذي ينقسم إلى 100 هللة. العملات الورقية متوفرة بفئات 1 و5 و20 و50 و100 و200 و500 ريال، بينما العملات المعدنية متوفرة بفئات 1 أو 2 ريال، و1 و5 و10 و25 و50 هللة.',
        'Exchange'=>'سعر الصرف في السعودية',
        'The2' => 'الدولار الأمريكي يعادل 3.75 ريال سعودي (سعر ثابت). تحقق من هذا (رابط الموقع بالكلمات) (موقع حاسبة تحويل الريال السعودي) لمساعدتك في حساب سعر الصرف والتخطيط لميزانية سفرك. تقدم جميع البنوك في المملكة العربية السعودية خدمات صرف العملات. يمكنك أيضًا العثور على مكاتب الصرافة في المطارات وبعض مراكز التسوق وغيرها من المواقع في جميع أنحاء المملكة. تكون ساعات العمل المصرفية عادةً من الساعة 9:30 صباحًا إلى 4:30 مساءً من السبت إلى الخميس. غالبًا ما تفتح مكاتب الصرافة في وقت لاحق، ولكنها قد تفرض رسوم عمولة أعلى.',
        'Can' => 'هل يمكنني استخدام بطاقات الائتمان في السعودية؟',
        'All' => 'تقدم جميع البنوك في المملكة خدمات صرف العملات، كما يمكنك العثور على مكاتب صرف العملات في المطارات وبعض مراكز التسوق والعديد من المواقع الأخرى في جميع أنحاء المملكة. تفتح البنوك عمومًا من السبت إلى الخميس بين الساعة 9:30 صباحًا و4:30 مساءً (تفتح مكاتب صرف العملات في وقت لاحق، وقد تفرض رسومًا أعلى). تتوفر أجهزة الصراف الآلي على نطاق واسع، ويتم قبول بطاقات الائتمان، بما في ذلك Visa وMasterCard وAmerican Express، في جميع أنحاء المملكة، وتقبل العديد من الشركات أيضًا طرق الدفع الرقمية، مثل Apple Pay.',
        'Saudi' => 'نصائح الرعاية الصحية في السعودية',
        'Information' => 'معلومات عن الرعاية الصحية في المملكة',
        'If' => 'إذا كنت بحاجة إلى مساعدة طبية، يمكنك زيارة أي مستشفى أو عيادة أو صيدلية، حيث يوجد في العديد منها موظفون يتحدثون الإنجليزية. يمكنك أيضًا الاتصال بسفارتك للحصول على المساعدة، وتأكد من أن تأمين السفر الخاص بك يغطي نفقات الرعاية الصحية.',
        'Where' => 'أين يمكنني شراء الأدوية في السعودية؟',
        'Common' => 'يمكن شراء الأدوية الشائعة مثل مسكنات الألم وشراب السعال وأدوية الحساسية دون وصفة طبية في معظم الصيدليات (التي تغطي جميع المناطق والأحياء في المملكة العربية السعودية، ولكن الأدوية الأكثر فعالية قد تتطلب وصفة طبية).',
        'Healthcare' => 'تطبيق الرعاية الصحية',
        'Emergency' => 'أرقام الطوارئ',
        'Select' => 'اختر خدمة الطوارئ',
        'Police'=>'الشرطة',
        'Ambulance' => 'الاسعاف',
        'Fire' => 'الإطفاء',
        'For' => 'للحصول على مساعدة الشرطة، اتصل بالرقم 999 ',
        'For2'=>'للحصول على مساعدة الاسعاف اتصل بالرقم 997 ',
        'For3' => 'للحصول على مساعدة الإطفاء اتصل بالرقم 998 ',
        'Useful' => 'ارقام تهمك',
        'Tourism'=>'مركز الاتصال السياحي',
        'Tourism2' => 'مركز الاتصال السياحي: ',
        'International' => 'مركز الاتصال السياحي الدولي: ',
        'Ministry' => 'وزارة الحج والعمرة خدمة العملاء: .',
        'Public' => 'الأمن العام',
        'Saudi2'=>'الأمن العام السعودي: ',
        'General' => 'الإدارة العامة للجوازات: ',
        'Emergency2' => 'الاستشارات الطبية الطارئة: ',
        'Najm' => 'شركة نجم: ',
        'Other'=>'أرقام مفيدة أخرى',
        'Municipality' => 'خدمات البلدية: ',
        'Ministry2' => 'طوارئ وزارة النقل: ',
        'Ministry3'=>'مركز الاتصال للمستهلك بوزارة التجارة: ',
        'General2' => 'الاستفسارات العامة: ',
        'About'=>'من نحن',
        'Footer'=>'© 2024 اكتشف المملكة العربية السعودية. جميع الحقوق محفوظة.',
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
    <title>Useful Information for Your Visit</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
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
            justify-content: left;
            color: white;
            text-align: center;
            
        }
        .hero-section img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .hero-section .hero-text {
            font-family: Showcard Gothic;
            padding: 20px;
            border-radius: 8px;
            padding-left: 50px;
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

        .info-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .info-item:hover {
            transform: scale(1.05);
        }

        .contact-section {
            padding: 50px 20px;
            text-align: center;
            background-color: #f9f9f9;
        }

        .contact-section input,
        .contact-section textarea,
        .contact-section button {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #A089A9;
        }

        .contact-section button {
            background-color: #004A77;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .contact-section button:hover {
            background-color: #0073A8;
        }

        .section-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .section-item {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            
        }

        .section-item:hover {
            transform: scale(1.05);
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
        select {

/* styling */
background-color: white;
border: thin solid blue;
border-radius: 4px;
display: inline-block;
font: inherit;
line-height: 1.5em;
padding: 0.5em 3.5em 0.5em 1em;
width: 50%;

/* reset */

margin: 0;      
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
-webkit-appearance: none;
-moz-appearance: none;
}


/* arrows */

select.classic {
background-image:
  linear-gradient(45deg, transparent 50%, blue 50%),
  linear-gradient(135deg, blue 50%, transparent 50%),
  linear-gradient(to right, skyblue, skyblue);
background-position:
  calc(100% - 20px) calc(1em + 2px),
  calc(100% - 15px) calc(1em + 2px),
  100% 0;
background-size:
  5px 5px,
  5px 5px,
  2.5em 2.5em;
background-repeat: no-repeat;
}

select.classic:focus {
background-image:
  linear-gradient(45deg, white 50%, transparent 50%),
  linear-gradient(135deg, transparent 50%, white 50%),
  linear-gradient(to right, gray, gray);
background-position:
  calc(100% - 15px) 1em,
  calc(100% - 20px) 1em,
  100% 0;
background-size:
  5px 5px,
  5px 5px,
  2.5em 2.5em;
background-repeat: no-repeat;
border-color: grey;
outline: 0;
}

        .select-box-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .select-box {
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #A089A9;
            width: 300px;
            background-color: #ffffff;
        }

        .emergency-info {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .emergency-info h1 {
            color: green;
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
    <!-- Navbar with jump links -->
    <header class="navbar">
        <div class="logo">
        <a href="visitor_dashboard.php?lang=<?php echo $_GET['lang'];?>"> <img src="uploads/logo1.png" alt="Logo" style="width:200px;height:90px"></a>
        </div>
        <div class="links">
            
            <div class="dropdown">
                <p style="font-size:20px;"><?php echo $text['Region']; ?></p>
                <div class="dropdown-content">
                <?php while($region = mysqli_fetch_assoc($regions)): 
                    ?>
                    
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
            <a href="?lang=en" class="logout-icon"><img src="uploads\\lang.png" style="width:50px;height:50px; alt="Heritage Site 2"></a>
<?php } ?>
            <?php if($_SESSION['user_type']=='manager'){?>
                <a href="admin_main.php" style="font-size:20px;" class="logout-icon">Dashboard</a><?php } ?>

            <?php if($_SESSION['user_type']!='manager'){?>
                <a href="edit_profile.php?lang= <?php echo $_GET['lang'];?>"><img src="uploads\\user.png" style="width:40px;height:40px" alt="Heritage Site 2"></a><?php } ?>
            
            <a href="logout.php" class="logout-icon"><img src="uploads\\logout.png" style="width:40px;height:40px" alt="Heritage Site 2"></a>
            
        
        </div>
        
    </div>
    </header>
    <section>
    <div class="hero-section">
        <img src="uploads\\6.jpg">
        <div class="hero-text">
            <h1 style="font-size:80px"><?php echo $text['Your']; ?></h1>
            
        </div>
        </section><br>
        <div style=" margin: 40px; height:100px; width:1420px; ">
        <p style=" font-size: 35px; font-family: Algerian"><?php echo $text['Important']; ?></p>
        <p style=" font-size: 22px; padding-left: 15px; font-family: Bahnschrift Condensed"><?php echo $text['Visiting']; ?></p>
        
    </div><br><br>
        <!-- Useful Information for Your Visit Section -->
    <section id="useful-info" class="useful-info-section">
        <h1><?php echo $text['A']; ?></h1>
        <h3><?php echo $text['When']; ?></h3>
        <div class="info-container">
            <div class="info-item" id="weather">
                <h3><?php echo $text['Summer']; ?></h3>
                <img src="uploads/s.png" style="width:50px; height:50px;">
                <p><?php echo $text['Despite']; ?> </p>
            </div>
            <div class="info-item" id="visa">
                <h3><?php echo $text['Winter']; ?></h3>
                <img src="uploads/w.png" style="width:50px; height:50px;">
                <p><?php echo $text['Do']; ?></p>
            </div>
            <div class="info-item" id="transportation">
                <h3><?php echo $text['Spring']; ?> </h3>
                <img src="uploads/t.png" style="width:50px; height:50px;">
                <p><?php echo $text['When2']; ?> </p>
            </div>
            <div class="info-item" id="safety">
                <h3><?php echo $text['Autumn']; ?></h3>
                <img src="uploads/f.png" style="width:50px; height:50px;">
                <p><?php echo $text['As']; ?> </p>
            </div>
        </div>
    </section>

    <!-- How to Pay in Saudi Section -->
    <section id="how-to-pay" class="useful-info-section">
        <h2><?php echo $text['How']; ?></h2>
        <div class="section-container">
            <div class="section-item">
                <h2><?php echo $text['Currency']; ?></h2>
                <p><?php echo $text['The']; ?> </p>
                
            </div>
            <div class="section-item">
                <h2><?php echo $text['Exchange']; ?></h2>
                <p><?php echo $text['The2']; ?> </p>
                
            </div>
            <div class="section-item">
                <h2><?php echo $text['Can']; ?> </h2>
                <p><?php echo $text['All']; ?> </p>
                
            </div>
        </div>
    </section>

    <!-- Saudi Healthcare Tips Section -->
    <section id="healthcare-tips" class="useful-info-section">
        <h2><?php echo $text['Saudi']; ?></h2>
        <div class="section-container">
            <div class="section-item">
                <h2><?php echo $text['Information']; ?></h2>
                <img src="uploads/Health.png" style="width: 80px; height:80px" alt="Health Insurance">
                <p><?php echo $text['If']; ?></p>
                
            </div>
            <div class="section-item">
                <h2><?php echo $text['Where']; ?> </h2>
                <img src="uploads/p.png" style="width: 80px; height:80px" alt="Health Insurance">
                <p><?php echo $text['Common']; ?> </p>
                
            </div>
            
        </div>
    </section>
    <div >
        <h1 style=" text-align: center;width:23%"><?php echo $text['Healthcare']; ?></h1>
        <a href="https://apps.apple.com/sa/app/%D8%B5%D8%AD%D8%AA%D9%8A-sehhaty/id1459266578"><img src="uploads\\seh.jpg" style=" width: 450px; height:450px"></a>


    </div>
    <!-- Emergency Numbers Section with Custom Select Box -->
    <section id="emergency-numbers" class="useful-info-section">
        <h2><?php echo $text['Emergency']; ?> </h2>
        <div class="select-box-container">
            <select id="emergency-select" class="classic">
                <option value="" disabled selected><?php echo $text['Select']; ?> </option>
                <option value="police"><?php echo $text['Police']; ?> </option>
                <option value="ambulance"><?php echo $text['Ambulance']; ?> </option>
                <option value="fire"><?php echo $text['Fire']; ?> </option>
            </select>
        </div>
        <div id="emergency-info" class="emergency-info">
            <h1 id="emergency-details"></h1>
        </div>
    </section>

    <!-- Useful Numbers Section -->
    <section id="useful-numbers" class="useful-info-section">
        <h2><?php echo $text['Useful']; ?></h2>
        <div class="section-container">
            <div class="section-item">
                <h2><?php echo $text['Tourism']; ?></h2>
                <p><?php echo $text['Tourism']; ?><span style="color: green"> 930</span></p>
                    <p><?php echo $text['International']; ?>  <span style="color: green">966920000890</span></p>
                    <p><?php echo $text['Ministry']; ?>  <span style="color: green">966920002814.</span></p>
            </div>
            <div class="section-item">
                <h2><?php echo $text['Public']; ?></h2>
                <p><?php echo $text['Saudi2']; ?> <span style="color: green">989</span></p>
<p><?php echo $text['General']; ?> <span style="color: green">992</span></p>
<p><?php echo $text['Emergency2']; ?> <span style="color: green">937</span></p>
<p><?php echo $text['Najm']; ?> <span style="color: green">920000560</span></p>
            </div>
            <div class="section-item">
                <h2><?php echo $text['Other']; ?></h2>
                <p><?php echo $text['Municipality']; ?> <span style="color: green"> 940</span></p>
                <p><?php echo $text['Ministry2']; ?>  <span style="color: green">938</span></p>
                <p><?php echo $text['Ministry3']; ?>  <span style="color: green">1900</span></p>
                <p><?php echo $text['General']; ?><span style="color: green">905</span></p>
            </div> 
        </div>
    </section>

    <script>
        // JavaScript for displaying emergency number details
        document.getElementById('emergency-select').addEventListener('change', function () {
            const emergencyInfo = document.getElementById('emergency-info');
            const emergencyDetails = document.getElementById('emergency-details');

            switch (this.value) {
                case 'police':
                    emergencyDetails.textContent = '<?php echo $text['For']; ?>';
                    break;
                case 'ambulance':
                    emergencyDetails.textContent = '<?php echo $text['For2']; ?>';
                    break;
                case 'fire':
                    emergencyDetails.textContent = '<?php echo $text['For3']; ?>';
                    break;
                default:
                    emergencyDetails.textContent = '';
            }

            emergencyInfo.style.display = 'block';
        });
    </script>
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
