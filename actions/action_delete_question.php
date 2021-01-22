<?php
  include_once("../includes/session.php");
  include_once("../database/db_questions.php");

  $id = $_GET['id'];
  
  if(!preg_match('/^[0-9]+$/', $id)){
    die(header('Location: ../pages/rescuerTasksPage.php'));
  }

  deleteQuestion($id);

  if(getAnswerForQuestion($id) != false){
    deleteAnswerByQuestionID($id);
  }
  
  header('Location: ../pages/rescuerTasksPage.php');
?>