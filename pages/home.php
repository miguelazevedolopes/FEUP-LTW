<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_home.php');

    if (isset($_SESSION['username'])){
      draw_header($_SESSION['username'], "home");
      draw_home($_SESSION['username']);
    }  
    else{
      draw_header(null, "home");
      draw_home(null);
    }   

    draw_footer();
?>
