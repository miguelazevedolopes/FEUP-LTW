<?php 
    include_once('../utils/pet_utils.php');
    include_once('../database/db_pets.php');
    include_once("../database/db_questions.php");
    include_once("../database/db_proposal.php");

    function draw_questions_proposals_all_pets($pets) { ?>
<main id="rescuerTasks">
    <h1> Rescuer Tasks </h1>
    <?php
        
        for ($i = 0; $i < sizeof($pets)*2; $i+=2) {?>
    <div id="pet_section">
        <?php
                $pet = $pets[$i/2];
                draw_questions_card($pet, $i);
                draw_pet_card($pet);
                draw_proposals_card($pet, $i+1);
                ?>
    </div>
    <?php
        }
        ?>
</main>

<?php
    } ?>

<?php function draw_pet_card($pet){
    list($name_p, $race_p) = parseNameRace($pet['name']);
    $photo = getPhotosById($pet['petID']);
    ?>

<div id="petInfo" data-link='petProfile.php?id=<?=$pet['petID']?>'>
    <img src="<?= urlencode($photo[0]['url'])?>" alt="pet-image" id="petLink">
    <h2 id="petLink"> <?= htmlspecialchars(ucfirst($name_p))?> </h2>
    <i class="fas fa-paw"></i>
    <span><?= ucfirst($pet['species'])?>
        <?php
            if($race_p != null){
          ?>
        - <?= htmlspecialchars(ucfirst($race_p))?> </span>
    <?php } ?>

    <br>
    <i class="fas fa-venus-mars"></i>
    <span><?= htmlspecialchars(ucfirst(intToSex($pet['sex'])))?></span>
    <br>
    <i class="far fa-clock"></i>
    <span> <?= htmlspecialchars($pet['age'])?> </span>
    <br>
    <i class="fas fa-map-marker-alt"></i>
    <span><?= htmlspecialchars(ucfirst($pet['location']))?></span>
    <br>
    <i class="fas fa-weight-hanging"></i>
    <span><?= htmlspecialchars(ucfirst(intToSize($pet['size'])))?></span>
</div>
<?php
}
?>

<?php function draw_questions_card($pet, $index){
    $questions = getQuestionsforPet($pet['petID']); 
    ?>
<div class="slideshow questions"> <?php
        if(sizeof($questions) > 0){
            foreach ($questions as $question) {
                draw_question($question);
            }
            if(sizeof($questions) > 1){
            ?>
    <a class="prevTask" onclick="plusDivs(-1, <?=$index?>)">&#10094;</a>
    <a class="nextTask" onclick="plusDivs(1, <?=$index?>)">&#10095;</a>
    <?php
        }}
        else {
            draw_no_tasks_message("questions");
        }
        
        ?>
</div>
<?php
}
?>

<?php function draw_question($question){ 
    $username = getUsernameById($question['userID']);
    $answer = getAnswerForQuestion($question['questionID']);
    ?>
<div class="slideshow-content question" data-questionid=<?=$question['questionID']?>>
    <h3> Question by <?= htmlspecialchars($username)?> </h3>
    <p id="date"><?= htmlspecialchars($question['date'])?></p>
    <p id="questionText"><?= htmlspecialchars($question['questionText'])?> </p>
    <?php if($answer != false){
        ?>
    <p id="answerText"><?= htmlspecialchars($answer['answerText'])?></p>
    <div class="buttons" data-answerid="<?=$answer['answerID']?>" data-answer="<?=$answer['answerText']?>">
        <button id="editAnswer">Edit Answer</button>
        <button id="deleteQuestion">Delete</button>
    </div>
    <?php
        }else {
        ?>
    <form method="get" id="answerSection">
        ​<textarea id="answerArea" name="answerArea" rows="4" cols="40" placeholder="Answer this question here"
            maxlength="100"></textarea>
        <p id="answer">(Maximum characters: 100)</p>
        <div class="buttons">
            <button id="answerbutton" value="Answer">Answer</button>
            <button id="deleteQuestion">Delete</button>
        </div>
    </form>
    <?php
        }?>
</div>
<?php
}
?>

<?php function draw_proposals_card($pet, $index){
    $proposals = getProposalForPet($pet['petID']);
    ?>
<div class="slideshow proposals"> <?php
        if(sizeof($proposals) > 0){
            foreach ($proposals as $proposal) {
                draw_proposal($proposal);
            }
            if(sizeof($proposals) > 1){
            ?>
    <a class="prevTask" onclick="plusDivs(-1, <?=$index?>)">&#10094;</a>
    <a class="nextTask" onclick="plusDivs(1, <?=$index?>)">&#10095;</a>
    <?php
        }}
        else {
            draw_no_tasks_message("proposals");
        }
        
        ?>
</div>

<?php
}
?>


<?php function draw_proposal($proposal){ 
    $username = getUsernameById($proposal['userID']);
    ?>
<div class="slideshow-content proposal" data-proposalid=<?=$proposal['proposalID']?>>
    <h3> Proposal by <?= htmlspecialchars($username)?> </h3>
    <p id="date"><?= htmlspecialchars($proposal['date'])?></p>
    <p id="text"><?= htmlspecialchars($proposal['text'])?> </p>


    <?php if($proposal['confirmed'] == 2){ //rejected
        ?>
    <div class="buttons">
        <button id="rejected">Rejected</button>
    </div>
    <?php
    }
    ?>
    <?php if($proposal['confirmed'] == 0){ //accepted
        ?>
    <div class="buttons">
        <p id="accepted">Accepted</p>
    </div>
    <?php
    }
    ?>
    <?php if($proposal['confirmed'] == 3){ //
        ?>
    <div class="buttons">
        <p id="rejectedP">Rejected</p>
    </div>
    <?php
    }
    ?>
    <?php if($proposal['confirmed'] == 1){ //waiting for answer
        ?>
    <div class="buttons">
        <button id="reject">Reject</button>
        <button id="accept">Accept</button>
    </div>
    <?php
    }
    ?>
</div>
<?php
}
?>

<?php function draw_no_tasks_message($string){ ?>
<div id="message">
    <p> This pet has no <?=$string?> yet!</p>
</div>
<?php
}
?>

<?php function draw_no_pets(){ ?>
    <main id="notLoggedIn">
    <div id="notLoggedIn-content">
        <p> You don't have any pets yet!</p>
    </div>
</main>
<?php
}
?>