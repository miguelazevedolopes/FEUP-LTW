<?php

    include_once('../database/db_pets.php');
    include_once('../utils/pet_utils.php');
    include_once('../utils/proposal_utils.php');

function draw_adoption_card($proposal) {
    $pet = getPetInfoById($proposal['petID']);
    $name = parseNameRace($pet['name']);
    $confirmation = parseConfirmation($proposal['confirmed']);
    $photo = getPhotosById($proposal['petID'])[0];
?>
<label class="proposal-card">
    <input type="checkbox" />
    <div class="proposal-card-flip">
        <div class="proposal-card-front">
            <a href="petProfile.php?id=<?= $proposal['petID'] ?>"><img src=<?=urlencode($photo['url'])?>
                    alt=<?=htmlspecialchars($photo['altText'])?>></a>
            <div class="proposal-card-front-info">
                <h2><?=htmlspecialchars($name[0])?></h2>
                <h2><?=htmlspecialchars($proposal['date'])?></h2>
                <h2><?=htmlspecialchars($pet['location'])?></h2>
                <h2><?=htmlspecialchars($confirmation)?></h2>
                <h3 id="click-more">Click to view more</h3>
            </div>
        </div>
        <div class="proposal-card-back">
            <h2><?=htmlspecialchars($proposal['text'])?></h2>
        </div>
    </div>
</label>


<?php }  ?>