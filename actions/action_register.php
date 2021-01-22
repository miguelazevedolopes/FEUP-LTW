<?php
  include_once('../includes/session.php');
  include_once('../database/db_user.php');

  $username = trim($_POST['username']);
  $password = $_POST['password'];
  $contact = trim($_POST['contact']);
  $name = trim($_POST['name']);
  $shelter = $_POST['shelter'];
  if($shelter == 'yes') $shelter_n = 1;
  else $shelter_n = 0;

  if($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../pages/home.php');
  }

  $_SESSION['new_name'] = $name;
  $_SESSION['new_contact'] = $contact;
  $_SESSION['new_username'] = $username;


  if (!preg_match ("/^[a-zA-Z -]+$/", $name)) {
    $_SESSION['register_error'] = 'Name can only contain letters!';
    die(header('Location: ../pages/register.php'));
  }
  
  if(preg_match('/\s/', $username)){
    $_SESSION['register_error'] = 'Username can not have whitespaces!';
    die(header('Location: ../pages/register.php'));
  }

  if(!preg_match("/^[1-9][0-9]{8}$/", $contact)){
    $_SESSION['register_error'] = 'Contact must only have 9 digits!';
    die(header('Location: ../pages/register.php'));
  }


  try {
    insertUser($username, $password, $name, $contact, $shelter_n);
    $_SESSION['username'] = $username;
    header('Location: ../pages/profilePage.php');
  } catch (PDOException $e) {
    $_SESSION['register_error'] = 'Username already exists!';
    header('Location: ../pages/register.php');
  }
?>