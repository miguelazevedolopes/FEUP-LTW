<?php
  include_once("../includes/session.php");
  include_once("../database/db_pets.php");
  include_once("../database/db_questions.php");
  include_once("../database/db_proposal.php");

  $id = $_GET['id'];
  
  if(!preg_match('/^[0-9]+$/', $id)){
    die(header('Location: ../pages/home.php'));
  }

  deletePet($id);


  
  header('Location: ../pages/home.php');
?>