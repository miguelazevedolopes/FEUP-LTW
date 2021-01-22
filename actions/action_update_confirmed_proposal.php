<?php
  include_once('../includes/database.php');
  include_once('../includes/session.php');
  include_once('../database/db_user.php');
  include_once('../database/db_pets.php');
  include_once('../database/db_proposal.php');
  

  $id = $_GET['id'];
  if(!preg_match('/^[0-9]+$/', $id)){
    die(header('Location: ../pages/home.php'));
  }

  $confirmed = $_GET['confirmed'];
  if(!preg_match('/^[0-9]+$/', $confirmed) || ($confirmed < 0) || ($confirmed > 3)){
    die(header('Location: ../pages/home.php'));
  }

  updateConfirmedFieldProposal($confirmed, $id);
  if($confirmed == 0){ 
    $petID = getPetIDByProposal($id);
    updateState($petID, 1);
    rejectAllProposalsExceptOne($id);
  }
?>