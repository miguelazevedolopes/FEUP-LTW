<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_person_profile.php');
    include_once('../database/db_user.php');

    if (isset($_SESSION['username'])) {
      draw_header($_SESSION['username'],"seeCollaborators");
      draw_see_collaborators($_SESSION['username']);
    }
    else {
      draw_header(null,"seeCollaborators");
      draw_message();
    }
    
    draw_footer();
?>