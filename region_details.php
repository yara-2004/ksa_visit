<?php
session_start();
include 'db.php';

$regionId = intval($_GET['id']);



// Fetch region details
$regionQuery = "SELECT * FROM Regions WHERE Id = '$regionId'";
$regionResult = mysqli_query($conn, $regionQuery);
$region = mysqli_fetch_assoc($regionResult);

if (!$region) {
    echo "Region not found.";
    exit();
}

// Fetch heritage sites in this region
$heritageQuery = "SELECT * FROM HeritageSites WHERE RegionId = '$regionId'";
$heritageSites = mysqli_query($conn, $heritageQuery);

// Fetch events in this region
$eventsQuery = "SELECT * FROM Events WHERE RegionId = '$regionId'";
$events = mysqli_query($conn, $eventsQuery);

// Close the database connection
mysqli_close($conn);

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
        'Places' => 'Cultural places',
        'Event'=> 'Events',
        'Footer' => 'Explore more regions to discover the rich heritage of the Western Region.',
        ],
    'ar' => [
        'dashboard' => 'واجهة الزائر',
        'Places' =>  'الأماكن الثقافية',
        'Event'=> 'الاماكن الترفيهية',
         'Footer' => 'استكشف المزيد من المناطق لاكتشاف التراث الغني للمنطقة الغربية.',
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
    <title><?php echo htmlspecialchars($region['Name']); ?> - Region Details</title>
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
 
<?php if($regionId==8){?>
            background: url('uploads\\AU.jpg') no-repeat ;
            <?php } elseif($regionId==1){?>
                background: url('uploads\\TII.jpg') no-repeat ;
                <?php } elseif($regionId==2){?>
                background: url('uploads\\Jed.jpg') no-repeat ;
                <?php }elseif($regionId==3){?>
                background: url('uploads\\MAD.jpg') no-repeat ;
                <?php }elseif($regionId==9){?>
                background: url('uploads\\MKK.jpg') no-repeat ;
                <?php }elseif($regionId==10){?>
                    background: url('uploads\\YUU.jpg') no-repeat ;
                <?php } else{?>

                    <?php } ?>
            background-size: 100%;
            opacity: 0.4; /* Set the opacity of the background image */
            z-index: -1; 
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
            gap: 15px;
        }

        .navbar .links img {
            width: 40px;
            height: 40px;
            cursor: pointer;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .heritage-container, .events-container {
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
            color: white;
            padding: 40px 0;
            text-align: center;
            position: bottom;
            width: 100%;
            bottom:0;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="navbar">
<a href="visitor_dashboard.php?lang=<?php echo $_GET['lang']?>">
        <img src="uploads/logo1.png" alt="Logo" style="width: 200px; height: 90px;">
    </a>
    <div class="links">
    <a href="edit_profile.php?lang= <?php echo $_GET['lang'];?>"><img src="uploads\\user.png" alt="Edit Profile"></a>
        
        <?php if ($_GET['lang'] == 'en') { ?>
        <a href="region_details.php?id=<?php echo $regionId; ?>&lang=ar">
            <img src="uploads\\lang.png" alt="Switch to Arabic">
        </a>
        <?php } else { ?>
        <a href="region_details.php?id=<?php echo $regionId; ?>&lang=en">
            <img src="uploads\\lang.png" alt="Switch to English">
        </a>
        <?php } ?>
        <a href="logout.php"><img src="uploads\\logout.png" alt="Logout"></a>
    </div>
    </div>
    
<div class="container">
<?php if ($_GET['lang'] == 'en' ) { ?>
    <h1><?php echo htmlspecialchars($region['Name']); ?>
    <?php if ($region['Id']==1){ ?>
    <a href="https://goo.gl/maps/wLcYvpExJ7HLuwd59"><?php }
    elseif($region['Id']==2){?><a href="https://goo.gl/maps/2vbNqT4PQPey7kM97"><?php }
    elseif($region['Id']==3){?><a href="https://goo.gl/maps/dsuCMweVptbGxNXj7"><?php }
    elseif($region['Id']==8){?><a href="https://goo.gl/maps/C9uJthtEGBBzXgeb8"><?php }
    elseif($region['Id']==9){?><a href="https://goo.gl/maps/ce4nUHAryu29fQnd7"><?php }
    elseif($region['Id']==10){?><a href="https://goo.gl/maps/Q2stiNEn7hYgUimu8"><?php }?>
          <img src="uploads\map.png" style=" width:50px; height:50px; margin:-8px 2px;"></a></a></a></a></a></a></h1>
    <p><?php echo htmlspecialchars($region['Description']); ?></p>
    <?php } else { ?>
        <h1><?php echo htmlspecialchars($region['Name_ar']); ?>
    <?php if ($region['Id']==1){ ?>
    <a href="https://goo.gl/maps/wLcYvpExJ7HLuwd59"><?php }
    elseif($region['Id']==2){?><a href="https://goo.gl/maps/2vbNqT4PQPey7kM97"><?php }
    elseif($region['Id']==3){?><a href="https://goo.gl/maps/dsuCMweVptbGxNXj7"><?php }
    elseif($region['Id']==8){?><a href="https://goo.gl/maps/C9uJthtEGBBzXgeb8"><?php }
    elseif($region['Id']==9){?><a href="https://goo.gl/maps/ce4nUHAryu29fQnd7"><?php }
    elseif($region['Id']==10){?><a href="https://goo.gl/maps/Q2stiNEn7hYgUimu8"><?php }?>
          <img src="uploads\map.png" style=" width:50px; height:50px; margin:-8px 2px;"></a></a></a></a></a></a></h1>
    <p><?php echo htmlspecialchars($region['Description_ar']); ?></p>
    <?php } ?>


    <h2><?php echo $text['Places']; ?></h2>
    <div class="heritage-container">
        <?php while ($site = mysqli_fetch_assoc($heritageSites)): ?>
            <?php if ($_GET['lang'] == 'en' ) { ?>
            <div class="card">
                <a href="DetailsAndCommentsPage_h.php?id=<?php echo $site['Id']; ?>&lang=<?php echo $_GET['lang'];?>" style="text-decoration: none; color: inherit;">
                    <img src="uploads/<?php echo htmlspecialchars($site['Image']); ?>" alt="<?php echo htmlspecialchars($site['Name']); ?>">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($site['Name']); ?></h3>
                    </div>
                    <?php } else { ?>
                        <div class="card">
                <a href="DetailsAndCommentsPage_h.php?id=<?php echo $site['Id']; ?>&lang=<?php echo $_GET['lang'];?>" style="text-decoration: none; color: inherit;">
                    <img src="uploads/<?php echo htmlspecialchars($site['Image']); ?>" alt="<?php echo htmlspecialchars($site['Name']); ?>">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($site['Name_ar']); ?></h3>
                    </div> <?php } ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>

    <h2><?php echo $text['Event']; ?></h2>
    <div class="events-container">
        <?php while ($event = mysqli_fetch_assoc($events)): ?>
            <?php if ($_GET['lang'] == 'en' ) { ?>
            <div class="card">
                <a href="DetailsAndCommentsPage_e.php?id=<?php echo $event['Id']; ?>&lang=<?php echo $_GET['lang'];?>" style="text-decoration: none; color: inherit;">
                    <img src="uploads/<?php echo htmlspecialchars($event['Image']); ?>" alt="<?php echo htmlspecialchars($event['Name']); ?>">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($event['Name']); ?></h3>
                    </div>
                    <?php } else { ?>
                        <div class="card">
                <a href="DetailsAndCommentsPage_e.php?id=<?php echo $event['Id']; ?>&lang=<?php echo $_GET['lang'];?>" style="text-decoration: none; color: inherit;">
                    <img src="uploads/<?php echo htmlspecialchars($event['Image']); ?>" alt="<?php echo htmlspecialchars($event['Name']); ?>">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($event['Name_ar']); ?></h3>
                    </div> <?php } ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="footer">
    <p><?php echo $text['Footer']; ?></p>
</div>

</body>
</html>
