<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../database/db_pets.php');
    include_once('../database/db_user.php');
    include_once('../database/db_questions.php');
    include_once('../database/db_proposal.php');
    include_once('../templates/tpl_notifications.php');

    
    if (isset($_SESSION['username'])){
        draw_header($_SESSION['username'], "notifications");
        
        $id = getIdByUsername($_SESSION['username']);
        $questions = getAnsweredQuestions($id);
        $proposals = getAnsweredProposalsByUserID($id);
        draw_notifications($id, $questions, $proposals);
    }
    else{

        draw_header(null, "notifications");
        draw_message();
    }
    draw_footer();
?>
