<?php
  include_once('../includes/database.php');
  
  function getProposalsByUserAux($id) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Proposal WHERE userID = ?');
    $stmt->execute(array($id));

    return $stmt->fetchAll();
  }

  function getProposalsByUserID($id) {
    include_once('../database/db_user.php');
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Proposal WHERE userID = ?');
    $stmt->execute(array($id));
    $res =  $stmt->fetchAll();

    $collaborator = !hasNoShelter($id);
    $shelter = isShelter($id);
    if(!($collaborator || $shelter)) return $res; //case of not being either a shelter or a collaborator
    else if($shelter){ //user is a shelter
      //add all collaborators proposals
      $collaborators = getAllColaborators($id);
      foreach($collaborators as $c){
        $aux = getProposalsByUserAux($c['userID']);
        $auxiliar = array_merge((array)$res, $aux);
        $res = $auxiliar;
      }
      return $res;
    }
    else if($collaborator){//user is a collaborator
      //add shelter proposals
      $shelterID = getUserShelter($id);
      $res1 =  getProposalsByUserAux($shelterID);
      $ret = array_merge($res, $res1);
      return $ret;
    }
  }

  function getProposalForPet($id){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Proposal WHERE petID = ? ORDER BY confirmed');
    $stmt->execute(array($id));
    return $stmt->fetchAll();
  }

  function deleteProposal($id){
    $db = Database::instance()->db();
    $stmt = $db->prepare('DELETE FROM Proposal WHERE petID = ?');
    $stmt->execute(array($id));
  }

  function updateConfirmedFieldProposal($confirmed, $proposalID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Proposal SET confirmed = ? WHERE proposalID = ?');
    $stmt->execute(array($confirmed, $proposalID));
  }

  function addProposal($proposalText, $petId){
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO Proposal VALUES(NULL, ?, ?, ?, ?, 1)');
    $username = $_SESSION['username'];
    $userID = getIdByUsername($username);
    $date = strftime(date('Y-m-d', time()));
    $stmt->execute(array($petId, $userID, $date, $proposalText));
  }

  function getPetIDByProposal($proposalID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT petID FROM Proposal WHERE proposalID = ?');
    $stmt->execute(array($proposalID));
    return $stmt->fetch()['petID'];
  }

  function rejectAllProposalsExceptOne($proposalID) {
    $petID = getPetIDByProposal($proposalID);
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Proposal SET confirmed = 3 WHERE petID = ? AND proposalID <> ?');
    $stmt->execute(array($petID, $proposalID));
  }

  function getAnsweredProposalsByUserAux($id) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Proposal WHERE userID = ? AND confirmed <> 1');
    $stmt->execute(array($id));

    return $stmt->fetchAll();
  }

  function getAnsweredProposalsByUserID($id) {
    include_once('../database/db_user.php');
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Proposal WHERE userID = ? AND confirmed <> 1');
    $stmt->execute(array($id));
    $res =  $stmt->fetchAll();

    $collaborator = !hasNoShelter($id);
    $shelter = isShelter($id);
    if(!($collaborator || $shelter)) return $res; //case of not being either a shelter or a collaborator
    else if($shelter){ //user is a shelter
      //add all collaborators proposals
      $collaborators = getAllColaborators($id);
      foreach($collaborators as $c){
        $aux = getProposalsByUserAux($c['userID']);
        $auxiliar = array_merge((array)$res, $aux);
        $res = $auxiliar;
      }
      return $res;
    }
    else if($collaborator){//user is a collaborator
      //add shelter proposals
      $shelterID = getUserShelter($id);
      $res1 =  getProposalsByUserAux($shelterID);
      $ret = array_merge($res, $res1);
      return $ret;
    }
  }
?>