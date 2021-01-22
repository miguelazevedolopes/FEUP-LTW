<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../database/db_pets.php');
    include_once('../database/db_user.php');
    include_once('../templates/tpl_pet_card.php');
    include_once('../utils/pet_utils.php');
    if (isset($_SESSION['username']))
      draw_header($_SESSION['username'], "rehome");
    else draw_header(null, "rehome");
    if(isset($_GET['id']))
      $filter = $_GET['id'];
    else die(header('Location: ../pages/home.php'));
    $shelters = getAllShelters();
    $numberPets = getNumberOfPets();

?>

<main class="getFilterID" id="rehome<?=$filter?>"> 
  <div id="filter-display-container">
    <div id="filters">
      <div id="responsive-filter">
        <h2 id="filter-show">FILTER</h2>
        <h2 id="search-show">SEARCH</h2>
      </div>
      <div class="search-container">
        <input id="searchInput" type="text">
        <div class="search"></div>
      </div>
      <div class="filter" id="filter-type">
        <h3 class="filter-title">TYPE OF ANIMAL</h3>
        <input class="filter-1" type="checkbox" name="type" id="dog" value="dog">
        <label for="dog">Dog</label><br>
        <input class="filter-1" type="checkbox" name="type" id="cat" value="cat">
        <label for="cat">Cat</label><br>
        <input class="filter-1" type="checkbox" name="type" id="pig" value="pig">
        <label for="Pig">Pig</label><br>
        <input class="filter-1" type="checkbox"  name="type" id="other animals" value="other animals">
        <label for="other animals">Other Animals</label><br>
      </div>
      <div class="filter" id="filter-type">
        <h3 class="filter-title">SIZE</h3>
        <input class="filter-2" type="checkbox" name="size" id="small"  value="small">
        <label for="small">Small</label><br>
        <input class="filter-2" type="checkbox" name="size" id="medium" value="medium">
        <label for="medium">Medium</label><br>
        <input class="filter-2" type="checkbox" name="size" id="big" value="big">
        <label for="big">Big</label><br>
      </div>
      <div class="filter" id="filter-type">
        <h3 class="filter-title">SEX</h3>
        <input class="filter-3" type="checkbox" name="sex"  id="male" value="Male">
        <label for="male">Male</label><br>
        <input class="filter-3" type="checkbox" name="sex" id="female"  value="Female">
        <label for="female">Female</label><br>
      </div>
      <?php if(count($shelters)!=0){
        
        ?>
        <div class="filter" id="filter-type">
          <h3 class="filter-title">SHELTER</h3>
          <?php 
            foreach($shelters as $s){ 
          ?>
              <input class="filter-4" type="checkbox" name="shelter" value="<?= strtolower($s['username'])?>">
              <label for="shelter"><?= $s['username'] ?></label><br>
          <?php }?>
        </div>
      <?php }?>

    </div>

    <div id="display-animals">
        <?php 
          if($numberPets!=0){
            for($id = 1; $id <= $numberPets; $id++){
              if(petExistsAvailable($id)) drawPetCard($id);
            }
          } 
        ?>
    </div>

    </div>
    
  </div>

</main>

<?php 
    draw_footer();
?>