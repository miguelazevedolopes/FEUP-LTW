<?php 
    include_once('../utils/pet_utils.php');
    include_once('../database/db_pets.php');
    include_once("../database/db_questions.php");
    include_once("../database/db_proposal.php");

    function draw_notifications($id, $questions, $proposals) { 
        
        if(!((count($questions) > 0) || (count($proposals) > 0))){
            draw_no_notification();
            return;
        }
?>

<main id="notifications">
        <h3> Notifications </h3>
        <?php
            foreach($questions as $question){
                draw_question_notification($question);
            }
            foreach($proposals as $proposal){
                draw_proposal_notification($proposal);
            }
        ?>
</main>

<?php
    } ?>

<?php function draw_question_notification($question){ 
    $pet = getPetInfoById($question['petID']);
    list($name_p, $race_p) = parseNameRace($pet['name']);
    ?>
<div id="notification" data-link="../pages/petProfile.php?id=<?=$question['petID']?>">
        <span> Your question for <?= htmlspecialchars(ucfirst($name_p)) ?> was answered. </span>
        <span id="questionNotification"> Click here to see it!</span>
</div>
<?php
}
?>

<?php function draw_proposal_notification($proposal){ 
    $pet = getPetInfoById($proposal['petID']);
    $rescuer = getUserByID($pet['rescuer']);
    list($name_p, $race_p) = parseNameRace($pet['name']);
    ?>
<div id="notification">
        <?php if($proposal['confirmed'] != 0) {?>
        <span> Your proposal for <?= htmlspecialchars(ucfirst($name_p)) ?> was rejected. </span>
        <span id="proposalNotification"> Click here to see it!</span>
        <?php } ?>

        <?php if($proposal['confirmed'] == 0) {?>
        <span> Your proposal for <?= htmlspecialchars(ucfirst($name_p)) ?> was accepted. </span>
        <span id="proposalNotification"> Click here to see it! </span>
        <span>  Please contact <?=$rescuer['contact']?> to procede with the adoption process. </span>
        <?php } ?>
</div>
<?php
}
?>

<?php function draw_no_notification(){ ?>
<main id="notLoggedIn">
    <div id="notLoggedIn-content">
        <p> There are no notifications to display!</p>
    </div>
</main>
<?php
}
?>