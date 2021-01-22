<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_pets.php');
    include_once('../database/db_proposal.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_pet_card.php');
    include_once('../templates/tpl_adoption_card.php');

    if (isset($_SESSION['username'])) {
        draw_header($_SESSION['username'],"userspets");

        $userID = getIdByUsername($_SESSION['username']);
        $id=$_GET['id'];
        $pets = getPetsByUser($userID);
        $proposals = getProposalsByUserID($userID);
        $favPets = getFavoritePetsByUser($userID);
        ?>



<main class="userspets" id="userspets<?= $id ?>">
    <div id="userspets-navbar">
        <a href="profilePage.php">
            <div>
                <h2>Profile</h2>
            </div>
        </a>
        <a href="userspets.php?id=1" id="pets-given-click">
            <div>
                <h2>Pets Given</h2>
            </div>
        </a>
        <a href="userspets.php?id=0" id="adoption-proposals-click">
            <div>
                <h2>Adoption Proposals</h2>
            </div>
        </a>
        <a href="userspets.php?id=2" id="adoption-proposals-click">
            <div>
                <h2>Favorite Pets</h2>
            </div>
        </a>
    </div>
    <div id="pets-given">
        <div id="pets-given-title">
            <h1>PETS GIVEN</h1>
            <?php if(count($pets)==0) { ?>
            <p> No pets given to show ....</p>
            <?php } ?>
        </div>
        <div id="pets-given-animals">
            <?php

                if(count($pets)>0){
                    foreach($pets as $pet) {
                        drawPetCardNoFav($pet['petID']);
                    }
                }
                
            ?>


        </div>
    </div>


    <div id="adoption-proposals">
        <div id="adoption-proposals-title">
            <h1>ADOPTION PROPOSALS</h1>
            <?php if(count($proposals)==0) { ?>
            <p> No adoption proposals to show ....</p>
            <?php } ?>
        </div>
        <div id="pets-proposals-container">
            <?php
                        

                if(count($proposals)>0){
                    foreach ($proposals as $proposal) {
                    draw_adoption_card($proposal);
                    }
                }
                
            ?>


        </div>
    </div>

    <div id="favorite-pets">
        <div id="favorite-pets-title">
            <h1>FAVORITE PETS</h1>
            <?php if(count($favPets)==0) { ?>
            <p> No favorite pets to show ....</p>
            <?php } ?>
        </div>
        <div id="favorite-pets-container">
            <?php
                        
                if(count($favPets)>0){
                    foreach ($favPets as $favpet) {
                        drawPetCard($favpet['petID']);
                    }
                }
                
            ?>


        </div>
    </div>


</main>

<?php


    } else {
        draw_header(null,"userpets");
        draw_message();
    }

    draw_footer();
?>