<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_gallery.php');

    if (isset($_SESSION['username'])) {
      draw_header($_SESSION['username'],'gallery');

      $profile = getUserByUsername($_SESSION['username']);

      draw_add_post($profile['userID']);

    }
    else {
      draw_header(null,'gallery');
    }

    draw_gallery();
    
    draw_footer();
?>