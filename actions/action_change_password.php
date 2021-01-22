<?php
  include_once("../includes/session.php");
  include_once("../database/db_user.php");

  if($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../pages/home.php');
  }

  $password = $_POST['password'];
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];


  if(!checkUserPassword($_SESSION['username'], $password)) {
    $_SESSION['password_error'] = 'Current Password is not correct!';
    die(header('Location: ../pages/changePassword.php'));
  }
  if($newPassword != $confirmPassword){
    $_SESSION['confirm_password_error'] = '  Passwords do not match!';
    die(header('Location: ../pages/changePassword.php'));
  }
  
  try {
    updatePassword($_SESSION['username'], $newPassword);  
  } catch (PDOException $e) {
    $_SESSION['new_password_error'] = '  Password is not valid!';
    die(header('Location: ../pages/changePassword.php'));
  }


  header('Location: ../pages/profilePage.php');
    
  
?>