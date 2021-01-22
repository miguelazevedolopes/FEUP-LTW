<?php
  include_once('../includes/session.php');
  include_once('../database/db_proposal.php');
  include_once('../database/db_user.php');
  

  $id = $_GET['id'];
  if(!preg_match('/^[0-9]+$/', $id)){
    die(header('Location: ../pages/home.php'));
  }

  $text = trim($_GET['text']);

  function testProposal($text){
    if(preg_match('/^[^\w" "]/', $text)) return false;
    if (preg_match('/(?=[^\w \-\,\;\!\"\(\)\'.?: ])/', $text)) return false;
    if (preg_match('/(?=[\-\,\;\!\"\(\)\'.?:]{2})/', $text)) return false;
    if(strlen($text) >= 300 || strlen($text) == 0) return false;
    return true;
  }

  if(!testProposal($text)){
    die(header('Location: ../pages/petProfile.php?id='.$id));
  }

  
  addProposal($text, $id);

?>