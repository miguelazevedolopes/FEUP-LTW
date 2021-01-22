<?php function draw_home($username) { 
/**
 * Draws the home page.
 */ ?>
<div id="landing-page">
    <img id="cute-img" src="../img/6.jpg" alt="img">
    <h2 id="img-title">Buddy Resc</h2>
    <h2 id="img-subtitle">RESCUE PETS FOR ADOPTION. CREATE HAPINESS. SAVE LIVES</h2>
    <a id="button1" class="button" href="../pages/gallery.php"> SEE MORE</a>
</div>

<div id="about-us">
    <div id=title-banner>
        <h2 class=title>WHAT WE DO</h2>
        <h2 class=long-text>Here at Buddy Resc we help people find new pets and
            if for some reason you can't keep your pet, we help you find a new home for him.</h2>
    </div>
</div>

<div id="about-us-img">
    <div class=flip-card id="flip1">
        <div class=flip-card-inner>
            <div class=flip-card-front>
                <h2>We've got just the right buddy for you.</h2>
                <img id="adopt-eg" src="../img/1.jpg" alt="">
            </div>
            <div id=animal_choice class=flip-card-back>
                <label for="animal_choice-dog">Dogs</label>
                <a href="../pages/rehome.php?id=0"><img id="animal_choice-dog" src="../img/7.jpg" alt="dog"></a>
                <label for="animal_choice-cat">Cats</label>
                <a href="../pages/rehome.php?id=1"><img id="animal_choice-cat" src="../img/2.jpg" alt="cat"></a>
                <label for="animal_choice-pig">Pigs</label>
                <a href="../pages/rehome.php?id=2"><img id="animal_choice-pig" src="../img/3.jpg" alt="pig"></a>
                <label for="animal_choice-other">All Animals</label>
                <a href="../pages/rehome.php?id=99"><img id="animal_choice-other" src="../img/4.jpg" alt="sheep"></a>
            </div>
        </div>
    </div>

    <div class=flip-card id="flip2">
        <div class=flip-card-inner>
            <div class=flip-card-front>
                <h2>Let's find a new home for your pet.</h2>
                <img id="give-eg" src="../img/5.jpg" alt="">
            </div>
            <div class=flip-card-back>
                <?php if(isset($username)){ ?>
                <h2> Your pet will be in good hands! </h2><br>
                <a class="button" href="../pages/give.php">Give a Pet </a>
                <?php } ?>
                <?php if(!isset($username)){ ?>
                <h2>It'll take just a few minutes, but first, register or log in.</h2><br>
                <a class="button" href="../pages/login.php">Login/Register</a>
                <?php } ?>
            </div>
        </div>

    </div>
</div>



<?php } ?>