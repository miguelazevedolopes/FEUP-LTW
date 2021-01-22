<?php
  include_once("../includes/session.php");
  include_once("../database/db_user.php");

  $username = $_POST['username'];
  $password = $_POST['password'];

  if($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../pages/home.php');
  }
  
  if(checkUserPassword($username, $password)){
    $_SESSION['username'] = $username;
    header('Location: ../pages/profilePage.php');
  }
  else {
    $_SESSION['login_error'] = 'Invalid username or password!';
    header('Location: ../pages/login.php');
  }

?>