<?php
  include_once("../includes/session.php");
  include_once("../database/db_user.php");

  $uid = $_GET['id'];

  if(!preg_match('/^[0-9]+$/', $uid)){
    die(header('Location: ../pages/home.php'));
  }

  if(isShelter($uid)) unsetAllColaborators($uid);

  deleteUser($uid);
  
  session_destroy();

  header('Location: ../pages/home.php');
?>