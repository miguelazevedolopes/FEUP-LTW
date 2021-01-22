<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_rescuer_tasks.php');
    include_once('../database/db_pets.php');
    include_once('../database/db_user.php');
    include_once('../database/db_questions.php');
    include_once('../database/db_proposal.php');
    
    if (isset($_SESSION['username'])){
        draw_header($_SESSION['username'], "rescuerTasks");
        
        $rescuer = getIdByUsername($_SESSION['username']);
        $pets = getPetsByUser($rescuer);
        
        if(count($pets) > 0)
            draw_questions_proposals_all_pets($pets);
        else
            draw_no_pets();
    }
    else {
        draw_header(null, "rescuerTasks");
        draw_message();
    }
    draw_footer();
?>
