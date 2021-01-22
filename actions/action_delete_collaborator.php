
<?php
  include_once("../includes/session.php");
  include_once("../database/db_user.php");
 
  $uid = $_GET['id'];

  if(!preg_match('/^[0-9]+$/', $uid)){
    die(header('Location: ../pages/home.php'));
  }

  unsetShelter($uid);

  header('Location: ../pages/seeCollaborators.php');
?>