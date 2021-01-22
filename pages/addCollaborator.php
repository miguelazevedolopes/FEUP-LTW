<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_person_profile.php');
    include_once('../database/db_user.php');

    if (isset($_SESSION['username'])) {
      draw_header($_SESSION['username'],'addCollaborator');

      $profile = getUserByUsername($_SESSION['username']); 

      draw_add_collaborator($profile);
    }
    else {
      draw_header(null,'addCollaborator');
      draw_message();
    }
    
    draw_footer();
?>