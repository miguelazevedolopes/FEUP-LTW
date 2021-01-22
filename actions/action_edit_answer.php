<?php
  include_once('../includes/database.php');
  include_once('../includes/session.php');
  include_once('../database/db_user.php');
  include_once('../database/db_questions.php');
  
  
  $id = $_GET['id'];
  if(!preg_match('/^[0-9]+$/', $id)){
    die(header('Location: ../pages/home.php'));
  }

  function testAnswer($text){
    if(preg_match('/^[^\w" "]/',$text))return false;
    if (preg_match('/(?=[^\w \-\,\;\!\"\(\)\'.?: ])/', $text)) return false;
    if (preg_match('/(?=[\-\,\;\!\"\(\)\'.?:]{2})/', $text)) return false;
    elseif(strlen($text) >= 100 || strlen($text) == 0) return false;
    else return true;
  }

  $answerText = trim($_GET['answer']);

  if(!testAnswer($answerText)){
    die(header('Location: ../pages/petProfile.php?id='.$id));
  }

  updateAnswerText($answerText, $id);

?>