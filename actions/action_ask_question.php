<?php
  include_once('../includes/database.php');
  include_once('../includes/session.php');
  include_once('../database/db_pets.php');
  include_once('../database/db_questions.php');
  include_once('../utils/pet_utils.php');

  $id = $_GET['id'];
  if(!preg_match('/^[0-9]+$/', $id)){
    die(header('Location: ../pages/home.php'));
  }

  $questionText = $_GET['question'];
  
  
  function testQuestion($text){
    if(preg_match('/^[^A-Za-z" "]/',$text))return false;
    if (!preg_match('/\w\?$|\s\?$/', $text)) return false;
    if (preg_match('/(?=[^\w \-\,\;\!\"\(\)\'.?: ])/', $text)) return false;
    if (preg_match('/(?=[\-\,\;\!\"\(\)\'.?:]{2})/', $text)) return false;
    elseif(strlen($text) >= 100 || strlen($text) == 0) return false;
    else return true;
  }

  if(!testQuestion($questionText)){
    $_SESSION['question_error'] = "Invalid input characters";
    die(header('Location: ../pages/petProfile.php?id='.$id));
  }
  
  addQuestion($questionText, $id);

?>