<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    if (isset($_SESSION['username']))
      draw_header($_SESSION['username'],"rehome-intro");
    else draw_header(null,"rehome-intro")
?>

<h2 id="rehome-intro-text">WHAT KIND OF PET ARE YOU LOOKING FOR?</h2>
<div id=banner-select-animal>

    <div id=banner-select-animal-option>
        <a href='rehome.php?id=0'><img id="animal_choice-dog" src="../img/7.jpg" alt="dog"></a>
        <h2>DOGS</h2>
    </div>
    <div id=banner-select-animal-option>

        <a href="rehome.php?id=1"><img id="animal_choice-cat" src="../img/2.jpg" alt="cat"></a>
        <h2>CATS</h2>
    </div>

    <div id=banner-select-animal-option>
        <a href="rehome.php?id=2"><img id="animal_choice-pig" src="../img/3.jpg" alt="pig"></a>
        <h2>PIGS</h2>
    </div>
    <div id=banner-select-animal-option>
        <a href="rehome.php?id=99"><img id="animal_choice-other" src="../img/4.jpg" alt="sheep"></a>
        <h2>ALL ANIMALS</h2>
    </div>
</div>


<?php 
    draw_footer();
?>