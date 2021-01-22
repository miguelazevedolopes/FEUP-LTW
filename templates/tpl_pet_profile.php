<?php function draw_pet_profile($id) { 
/**
 * Draws the pet profile section.
 */ 
    include_once('../utils/pet_utils.php');

    $id = $_GET['id'];
    if(!petExists($id)) return -1;

    $pet = getPetInfoById($id);
    $uid = getIdByUsername($_SESSION['username']);

    //collaborators can edi shelter pets and vice-versa
    if($uid === $pet['rescuer'] || isCollaboratorOfShelter($uid, $pet['rescuer'])|| isCollaboratorOfShelter($pet['rescuer'], $uid)) draw_editable_pet_profile($id, $pet);
    else{
      draw_pet_info($id, $pet);
      draw_pet_cards($id, $pet);
      draw_pet_about_info($pet);
      draw_questions($id);
    }
    
  }
?>
<?php function draw_edit_pet_profile($id) { 
/**
 * Draws the edit pet profile section.
 */
    include_once('../database/db_pets.php');

    $id = $_GET['id'];
    if(!petExists($id)) return -1;

    $pet = getPetInfoById($id);
    $uid = getIdByUsername($_SESSION['username']);

    if($uid != $pet['rescuer'] && !isCollaboratorOfShelter($uid, $pet['rescuer']) && !isCollaboratorOfShelter($pet['rescuer'], $uid)) return;

    draw_pet_info($id, $pet);
    draw_edit_pet_cards($id, $pet);
    draw_editable_profile($id, $pet);
  }
?>

<?php function draw_editable_pet_profile($id, $pet) {
/**
 * Draws the editable pet profile section.
 */ 
    draw_pet_info($id, $pet);
    draw_edit_pet_cards($id, $pet);
    draw_editable_pet_about_info($id,$pet);

  }
?>


<?php function draw_pet_info($id, $pet) {
/**
 * Draws the pet info section.
 */ 
    include_once('../utils/pet_utils.php');
    include_once('../database/db_pets.php');
    include_once("../database/db_questions.php");
    include_once("../database/db_proposal.php");

    list($name_p, $race_p) = parseNameRace($pet['name']);

    $photos = getPhotosById($id)
?>
<main id="pet-profile">
    <div id="petPresentation">
        <div id="smallInfo">
            <h3>Hello, I'm <?= htmlspecialchars($name_p)?> !</h3>
            <p>I'm a <?= htmlspecialchars($pet['age'])?> old
                <?php if($race_p!= null) { echo htmlspecialchars($race_p); } ?>
                from <?= htmlspecialchars($pet['location'])?> rehome center and I'm looking for a home.</p>
            <p>Please read my profile to find out more about me...</p>
        </div>
        <div class="slideshow-container">
            <?php
          foreach($photos as $photo){
            draw_photo($photo);
          }
          if(sizeof($photos) > 1){?>
            <a class="prev" id="prev">&#10094;</a>
            <a class="next" id="next">&#10095;</a>
            <?php } ?>
        </div>
    </div>

    <?php } ?>

    <?php function draw_photo($photo){ ?>

    <div class="slideshow-content photos">
        <img id="petPhoto" src=" <?php
          if(file_exists($photo['url'])) echo urlencode($photo['url']);
          else echo '../uploads/pet/defaultImage.png';?> " alt="">
    </div>

    <?php }?>

<?php function draw_pet_cards($id, $pet) {
/**
 * Draws the pet cards section.
 */ 
    include_once('../utils/pet_utils.php');

    list($name_p, $race_p) = parseNameRace($pet['name']);

    $uid = getIdByUsername($_SESSION['username']);

    $proposals = getProposalsByUserID($uid);
    $hasProposal  = false;

    if ($proposals != false) {
        foreach($proposals as $proposal){
            if($proposal['petID'] == $pet['petID']){
                $hasProposal = true;
            }
        }
    }

?>
    <div id="petProfileCards">
        <div id="rehomeCard">
            <?php if($pet['state'] == 1) { ?>
                <h3>We're sorry!</h3>
                <p><?= htmlspecialchars($name_p)?> has already been adopted!</p>
                <p>If you're looking for a pet, why not consider rehoming another one?</p>
                <button id="goToRehome"> See all available pets </button>
            <?php } 
            else { ?> 
            <h3>Give <?= htmlspecialchars($name_p)?> a home</h3>
            <p>All these animals want is a home</p>
            <p>If you're looking for a pet, why not consider rehoming them?</p>
            <?php
             if($hasProposal) {?>
                <button id="goToProposals"> See the proposal you have made for this pet </button>
            <?php
            } else {?>
                <button id="makeProposalButton" data-id=<?=$id?> value="Rehome"> Make an adoption proposal for <?= htmlspecialchars($name_p)?></button>
            <?php }
            }?>   

        </div>
        <div id="questionCard" data-id=<?=$id?>>
            <h3>Ask a question</h3>
            <form method="get" id="questionCardForm">
                ​<textarea id="question" name="question" rows="6" cols="40" placeholder="Make short questions, please"
                    maxlength="100"></textarea>
                <button id="questionbutton" type="submit" value="Ask">Ask</button><br>
                <p id="font" size="1">(Maximum characters: 100)</p>
            </form>

        </div>
    </div>

    <?php } ?>

<?php function draw_edit_pet_cards($id, $pet) {
/**
 * Draws the pet cards section on edit pet profile
 */ 
    include_once('../utils/pet_utils.php');
    
    list($name_p, $race_p) = parseNameRace($pet['name']);

?>
    <div id="petProfileCards">
        <div id="manageCard">
            <h3>Manage your proposal/questions</h3>
            <p>Check the proposals, you can accept, decline or postpone it for now</p>
            <p>Answer the questions about your pet</p>
            <form action="rescuerTasksPage.php">
                <button type="submit" value="Manage">Manage your pet </button>
            </form>
        </div>
        <div id="uploadCard">
            <h3>Upload more photos</h3>
            <p>There is no such thing as too many photos</p>
            <p>Add some more photos to <?= htmlspecialchars($name_p)?> profile</p>
            <form action="../actions/action_upload_photos.php?id=<?= $id ?>" method="post"
                enctype="multipart/form-data">
                <input type="file" id="petPhotos" name="petPhotos[]" class="custom-file-input"
                    accept=".jpeg,.jpg,.png,.gif" multiple hidden>
                <label for="petPhotos" id="selector">Upload more Photos</label><br>

                <button type="submit" value="Upload">Upload</button><br>
            </form>
        </div>
    </div>

    <?php } ?>
<?php function draw_pet_about_info($pet) {
/**
 * Draws the pet about me section.
 */ 
    include_once('../utils/pet_utils.php');

    list($name_p, $race_p) = parseNameRace($pet['name']);
?>

    <div id="petFullInfo">
        <div id="petAboutMe">
            <h3>About me ...</h3>
            <p><?= $pet['aboutmeText']?></p>
        </div>
        <div id="petInfo">
            <ul>
                <li>
                    <div>
                        <i class="fas fa-paw"></i>
                        <p><?= htmlspecialchars(ucfirst($pet['species']))?>
                            <?php
                if($race_p != null){
              ?>
                            - <?= htmlspecialchars(ucfirst($race_p))?> </p>
                        <?php } ?>
                    </div>
                </li>
                <li>
                    <div>
                        <i class="fas fa-venus-mars"></i>
                        <p><?= htmlspecialchars(ucfirst(intToSex($pet['sex'])))?></p>
                    </div>
                </li>
                <li>
                    <div>
                        <i class="far fa-clock"></i>
                        <p> <?= htmlspecialchars($pet['age'])?> </p>
                    </div>
                </li>
                <li>
                    <div>
                        <i class="fas fa-map-marker-alt"></i>
                        <p><?= htmlspecialchars(ucfirst($pet['location']))?></p>
                    </div>

                </li>
                <li>
                    <div>
                        <i class="fas fa-weight-hanging"></i>
                        <p><?= htmlspecialchars(ucfirst(intToSize($pet['size'])))?></p>
                    </div>

                </li>
            </ul>
        </div>
    </div>

    <?php } ?>


<?php function draw_editable_pet_about_info($id,$pet) {
/**
 * Draws the pet about me section on editable mode
 */ 

    include_once('../database/db_pets.php');
    draw_pet_about_info($pet);
?>

    <div id="petActions" data-link1="../actions/action_delete_pet_profile.php?id=<?= $id ?>"
        data-link2="../pages/petProfile.php?id=<?=$id ?>#petProfileCards">
        <a href="../pages/editPetProfile.php?id=<?=$id?>">Edit </a>
        <a id="deleteButton" href="#">Delete </a>

    </div>

    <?php } ?>


<?php function draw_questions($id) {
/**
 * Draws the pet questions section.
 */
    include_once('../database/db_pets.php');
    include_once('../database/db_user.php');
?>
    <div id="faqPetProfile">
        <h3>Questions already answered ...</h3>
        <div id="faq">
            <?php
            $questions = getAnsweredQuestionsforPet($id);
            if(count($questions)==0) echo "No questions have been made yet! Be the first to ask something!";
            else
              foreach($questions as $question){
                  $answer = getAnswerForQuestion($question['questionID']);
        ?>
            <details>
                <summary><?= htmlspecialchars($question['questionText']) ?>
                    <svg class="control-icon control-icon-expand" width="24" height="24" role="presentation">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#expand-more" />
                    </svg>
                    <svg class="control-icon control-icon-close" width="24" height="24" role="presentation">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#close" />
                    </svg>
                </summary>
                <p id="questionInfo">By <?= htmlspecialchars(getUsernameById($question['userID']))?> at <?=htmlspecialchars($question['date'])?></p>
                <p><?php
                        if($answer != false) echo $answer['answerText'] ;
                        else echo "No answer yet";?>
                </p>

            </details>
            <?php } ?>
        </div>
    </div>
</main>

<?php } ?>



<?php function draw_editable_profile($id, $pet) {
/**
 * Draws the pet profile editable section.
 */ 
    include_once('../utils/pet_utils.php');

    list($name_p, $race_p) = parseNameRace($pet['name']);

    $size = strtolower(intToSize($pet['size']));
    $sex = strtolower(intToSex($pet['sex']));
    $species = $pet['species'];

?>
<div id="edit">
    <div id="editPetFullInfo">

        <div id="petAboutMe">
            <form action="../actions/action_edit_pet_profile.php?id=<?=$id?>" method="post">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <h3>About me ...</h3>
                ​<textarea id="aboutme" name="aboutme" rows="6" cols="40"
                    placeholder="Write a brief description about your pet!" maxlength="500"></textarea>
                <p id="font">(Maximum characters: 500)</p>
        </div>

        <div id="previousInfo">
            <div class="petNameAndPhoto">
                <i class="fas fa-paw"></i>
                <label for="petName"> Name</label>
                <input id="petName" name="petName" type="text" placeholder="<?=htmlspecialchars($pet['name'])?>"><br>
            </div>

            <div class="petAge">
                <i class="far fa-clock"></i>
                <label for="petAge"> Age</label>
                <input id="petAge" name="petAge" type="text" placeholder="<?=htmlspecialchars($pet['age'])?>"><br>
            </div>
            <div id="petCity">
                <i class="fas fa-map-marker-alt"></i>
                <label for="petCity"> City</label>
                <input id="petCity" name="petCity" type="text"
                    placeholder="<?=htmlspecialchars($pet['location'])?>"><br>
            </div>
            <diV class="petSpecies">
                <i class=""></i>
                <label for="petSpecies"> Species</label>
                <?php if($species == "dog"){?>
                <input id="petSpeciesDog" name="petSpecies" type="radio" value="dog" checked>
                <?php }?>
                <?php if($species != "dog"){?>
                <input id="petSpeciesDog" name="petSpecies" type="radio" value="dog">
                <?php }?>
                <label for="petSpeciesDog" class="config-select">Dog</label>
                <?php if($species == "cat"){?>
                <input id="petSpeciesCat" name="petSpecies" type="radio" value="cat" checked>
                <?php }?>
                <?php if($species != "cat"){?>
                <input id="petSpeciesCat" name="petSpecies" type="radio" value="cat">
                <?php }?>
                <label for="petSpeciesCat" class="config-select">Cat</label>
                <?php if($species == "pig"){?>
                <input id="petSpeciesPig" name="petSpecies" type="radio" value="pig" checked>
                <?php }?>
                <?php if($species != "pig"){?>
                <input id="petSpeciesPig" name="petSpecies" type="radio" value="pig">
                <?php }?>
                <label for="petSpeciesPig" class="config-select">Pig</label>
                <?php if($species == "other animals"){?>
                <input id="petSpeciesOtherAnimals" name="petSpecies" type="radio" value="other animals" checked>
                <?php }?>
                <?php if($species != "other animals"){?>
                <input id="petSpeciesOtherAnimals" name="petSpecies" type="radio" value="other animals">
                <?php }?>
                <label for="petSpeciesOtherAnimals" class="config-select">Other animals</label><br>
            </diV>
            <diV class="petSize">
                <i class="fas fa-weight-hanging"></i>
                <label for="petSize"> Size</label>
                <?php if($size == "small"){?>
                <input id="petSizeSmall" name="petSize" type="radio" value="small" checked>
                <?php }?>
                <?php if($size != "small"){?>
                <input id="petSizeSmall" name="petSize" type="radio" value="small">
                <?php }?>
                <label for="petSizeSmall" class="config-select">Small</label>
                <?php if($size == "medium"){?>
                <input id="petSizeMedium" name="petSize" type="radio" value="medium" checked>
                <?php }?>
                <?php if($size != "medium"){?>
                <input id="petSizeMedium" name="petSize" type="radio" value="medium">
                <?php }?>
                <label for="petSizeMedium" class="config-select">Medium</label>
                <?php if($size == "big"){?>
                <input id="petSizeBig" name="petSize" type="radio" value="big" checked>
                <?php }?>
                <?php if($size != "big"){?>
                <input id="petSizeBig" name="petSize" type="radio" value="big">
                <?php }?>
                <label for="petSizeBig" class="config-select">Big</label><br>
            </diV>
            <diV class="petSex">
                <i class="fas fa-venus-mars"></i>
                <label for="petSex"> Sex</label>
                <?php if($sex == "male"){?>
                <input id="petSexMale" name="petSex" type="radio" value="male" checked>
                <?php }?>
                <?php if($sex != "male"){?>
                <input id="petSexMale" name="petSex" type="radio" value="male">
                <?php }?>
                <label for="petSexMale" class="config-select">Male</label>
                <?php if($sex == "female"){?>
                <input id="petSexFemale" name="petSex" type="radio" value="female" checked>
                <?php }?>
                <?php if($sex != "female"){?>
                <input id="petSexFemale" name="petSex" type="radio" value="female">
                <?php }?>
                <label for="petSexFemale" class="config-select">Female</label><br>
                <p>Anything you don't want to change, you can leave it blank</p>
                <p><?php if(isset( $_SESSION['edit_error'])) echo "<span class='edit_error'>" .  $_SESSION['edit_error'] . "</span>";?></p>
                <?php
                    unset( $_SESSION['edit_error']);
                ?>
            </diV>

            <div id="editButtons">
                <button type="submit" name="submit">Save</button>
                <a href="../pages/petProfile.php?id=<?=urlencode($id)?>">Cancel </a>
            </div>
        </div>
        </form>
        
    </div>
</div>
</main>
<?php } ?>