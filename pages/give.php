<?php 
    include_once('../includes/session.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_give.php');
    
    if (isset($_SESSION['username']))
      draw_header($_SESSION['username'], "give");
    else draw_header(null, "give");

    if (isset($_SESSION['username'])){
        draw_give();
     } 
    else{
        draw_message();
    }
    
    draw_footer();
?>