<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_pet_profile.php');
    include_once('../database/db_user.php');

    if (isset($_SESSION['username'])) {
      $id = $_GET['id'];
      draw_header($_SESSION['username'], "editPetProfile");
      $res = draw_edit_pet_profile($id);
      if($res == -1) draw_message_not_exists() ;//not an allowed page
    }
    else {
      draw_header(null, "editPetProfile");
      draw_message();
    }
    
    draw_footer();
?>