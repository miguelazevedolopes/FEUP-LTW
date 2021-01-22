<?php function draw_header($username, $page) {
/**
 * Draws the header section.
 */ ?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Coiny&family=Roboto&family=Varela+Round&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous" />
    <title>Buddy Rescue</title>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/tinylogo.jpg" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <script src="../js/utils.js"></script>
    <script src="../js/responsiveHeader.js" defer></script>
    <?php if($page == "petProfile"){?>
    <script src="../js/petProfile.js" defer></script>
    <script src="../js/photoFile.js" defer></script>
    <script src="../js/photoSlideshow.js" defer></script>
    <?php }?>
    <?php if($page == "profilePage" || $page == "seeCollaborators"){?>
    <script src="../js/personProfile.js" defer></script>    
    <?php }?>
    <?php if($page == "give" || $page == "editProfile" || $page == "gallery"){?>
    <script src="../js/photoFile.js" defer></script>
    <?php }?>

    <?php if($page == "home"){?> <script src="../js/header.js" defer></script> <?php }?>
    
    <?php if($page == "rehome"){?>
        <script src="../js/rehome.js" defer></script>
    <?php }?>

    <?php if($page == "userspets"){?>
    <script src="../js/petsgiven.js" defer></script>
    <?php }?>
    
    <?php if($page == "rescuerTasks"){?>
    <script src="../js/slideshow.js" defer></script>
    <script src="../js/rescuerTasks.js" defer></script>
    <?php }?>

    <?php if($page == "notifications"){?>
    <script src="../js/notifications.js" defer></script>
    <?php }?>
</head>

<body>
    <header>
        <div id="bar">
            <div class="responsive-bar-menu">
                <img id="hamburger" src="../img/hamburguer.png" alt="">
                <div class="hamburger-bar-content">
                    <a class="bar-menu-item" id="bar-menu-item-1" href="../index.php#about-us">ABOUT US</a>
                    <a class="bar-menu-item" id="bar-menu-item-2" href="rehome-intro.php">REHOME A PET</a>
                    <a class="bar-menu-item" id="bar-menu-item-3" href="give.php">GIVE A PET</a>
                    <?php if($username == NULL){?>
                    <a class="bar-menu-item" id="bar-menu-item-4" href="login.php">LOGIN</a>
                    <?php } ?>
                    <?php if($username != NULL){ ?>
                    <a href="profilePage.php">PROFILE</a>
                    <a href="userspets.php?id=2">FAVOURITES</a>
                    <a href="rescuerTasksPage.php">RESCUER TASKS</a>
                    <a href="notificationsPage.php">NOTIFICATIONS</a>
                    <a href="../actions/action_logout.php">LOGOUT</a>
                    
                    <?php } ?>
                </div>
            </div>
            <div id=logo-container>
                <a href="../index.php"><img id="logo" src="../img/13.png" alt="logo"></a>
            </div>
            <div id="bar-menu">
                <a class="bar-menu-item" id="bar-menu-item-1" href="../index.php#about-us">ABOUT US</a>
                <a class="bar-menu-item" id="bar-menu-item-2" href="rehome-intro.php">REHOME A PET</a>
                <a class="bar-menu-item" id="bar-menu-item-3" href="give.php">GIVE A PET</a>
                <?php if($username == NULL){?>
                <a class="bar-menu-item" id="bar-menu-item-4" href="login.php">LOGIN</a>
                <?php } ?>
                <?php if($username != NULL){ ?>

                <div class="dropdownProfile">
                    <a class="bar-menu-item" id="bar-menu-item-4"
                        href="../pages/userspets.php?id=0"><?=htmlspecialchars($username)?></a>
                    <ul class="dropdownProfile-content">
                        <li><a href="profilePage.php">Profile</a></li>
                        <li><a href="userspets.php?id=2">Favourites</a></li>
                        <li><a href="rescuerTasksPage.php">Rescuer Tasks</a></li>
                        <li><a href="notificationsPage.php">Notifications</a></li>
                        <li><a href="../actions/action_logout.php">Logout</a></li>
                    </ul>
                </div>

                <?php } ?>

            </div>

        </div>
        <div id="bar-1"></div>
    </header>
    <?php } ?>

    <?php function draw_footer() {
/**
 * Draws the footer section.
 */ ?>
    <footer id="footer">
        <div class="mainText">
            <h1>Buddy Resc</h1>
            <p>We're always available to answer your questions, hoping to deliver the best service to you and these
                lovely animals.</p>
            <p>Share with your friends, help us build this community</p>
            <p>Create Hapiness. Save lives.</p>
            <h4>Any questions? Write us to something@something.com </h4>
        </div>
        <div class="aditionalInfo">
            <ul>
                <li class="TalkWithUs">
                    <h2>Talk with us</h2>
                    <p>(+351)  22 508 1400</p>
                    <p>something@something.com</p>
                </li>
                <li class="VisitUs">
                    <h2>Visit us</h2>
                    <p>4200-465 Porto, Portugal</p>
                    <p>Rua Dr. Roberto Frias</p>
                    <p>Edificio I, Faculdade de Engenharia da Universidade do Porto</p>
                </li>

            </ul>
        </div>
    </footer>
</body>

</html>

<?php } ?>

<?php function draw_message() { 
/**
 * Draws a message to be displayed if the user is not logged in.
 */ ?>
<main id="notLoggedIn">
    <div id="notLoggedIn-content">
        <p> To access this funcionality you have to be logged-in ...</p><br>
        <p> You can do this <a href="login.php">here</a></p>
        <p> OR </p>
        <p> If you don't have an account, you can create one <a href="register.php">here</a></p>
    </div>
</main>
<?php } ?>

<?php function draw_message_not_exists() { 
/**
 * Draws a message to be displayed if the user is not logged in.
 */ ?>
<main id="notLoggedIn">
    <!-- just to use the same css -->
    <div id="notLoggedIn-content">
        <p> You're trying to access an invalid page ...</p><br>
        <p> Please go back to normal flow, <a href="home.php">here</a> </p>
    </div>
</main>
<?php } ?>