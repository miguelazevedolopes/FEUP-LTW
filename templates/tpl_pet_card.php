<?php function drawPetCard($id){
    include_once('../utils/pet_utils.php');
    include_once('../database/db_pets.php');
    include_once('../database/db_user.php');
    
    $animal = getPetInfoById($id);
    $nameAndSpecies = parseNameRace($animal['name']);
    $photo = getPhotosById($id);
    $rescuer = getUsernameById($animal['rescuer']);

    if(isset($_SESSION['username'])){	
        $userID = getIdByUsername($_SESSION['username']);	
        $favPets = getFavoritePetsByUser($userID);	
    }

    if(isShelter($animal['rescuer'])) $res = strtolower($rescuer);
    elseif(($r = getUserShelter($animal['rescuer']))) $res = strtolower(getUsernameById($r));
    else $res = " ";
 
    $info = strtolower($animal['species'])." ".strtolower(intToSize($animal['size']))." ".ucfirst(intToSex($animal['sex']))." ".$res;
?>

<div class="animal-card" id="<?= $animal['species'] ?>" data-info = "<?= $info ?>">
    <a href='petProfile.php?id=<?= $id?>'><img src="<?= urlencode($photo[0]['url'])?>" alt="pet-image"></a>
    <h2>Name: <?= $nameAndSpecies[0] ?></h2>
    <h2>Race: <?= $nameAndSpecies[1] ?></h2>
    <h2>Age: <?= $animal['age'] ?> </h2>
    <h2>Sex: <?= intToSex($animal['sex']) ?></h2>
    <h2>Rescuer: <?= htmlspecialchars($rescuer) ?></h2>
    <a class="button" href="petProfile.php?id=<?= $id?>">View pet profile</a>
    <?php if((isset($_SESSION['username']) && $_SERVER['PHP_SELF']=='/pages/rehome.php')|| (isset($_SESSION['username']) && $_SERVER['PHP_SELF']=='/pages/userspets.php') ){ ?>
        <div class="fav-background">
            <img class="fav-undone" id="fav-undone-<?= $id ?>" src="../img/fav-undone.png" alt="">
            <img class="fav-done" id="fav-done-<?= $id ?>" src="../img/fav-done.png"alt="">
        </div>
    <?php } ?>
</div>

<?php }
function drawPetCardNoFav($id){
    include_once('../utils/pet_utils.php');
    include_once('../database/db_pets.php');
    
    $animal = getPetInfoById($id);
    $nameAndSpecies = parseNameRace($animal['name']);
    $photo = getPhotosById($id);
    $rescuer=getUsernameById($animal['rescuer']);

?>
    
    <div class="animal-card" id="<?= $animal['species'] ?>" >
        <a href='petProfile.php?id=<?= $id?>'><img src="<?= urlencode($photo[0]['url'])?>" alt="pet-image"></a>
        <h2>Name: <?= $nameAndSpecies[0] ?></h2>
        <h2>Race: <?= $nameAndSpecies[1] ?></h2>
        <h2>Age: <?= $animal['age'] ?> </h2>
        <h2>Sex: <?= intToSex($animal['sex'])?></h2>
        <h2>Rescuer: <?= htmlspecialchars($rescuer)?></h2>
        <a class="button" href="petProfile.php?id=<?= $id?>">View pet profile</a>
    </div>

<?php }

?>