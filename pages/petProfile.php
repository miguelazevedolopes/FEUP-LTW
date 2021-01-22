<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_pet_profile.php');
    include_once('../database/db_pets.php');
    
    if (isset($_SESSION['username'])){
      draw_header($_SESSION['username'], "petProfile");
      $id = $_GET['id'];
      $res = draw_pet_profile($id);
      if($res == -1) draw_message_not_exists() ;//not an allowed page
    }
    else {
      draw_header(null, "petProfile");
      draw_message();
    }
    draw_footer();
?>
