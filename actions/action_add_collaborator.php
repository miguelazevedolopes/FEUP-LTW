<?php
  include_once('../includes/database.php');
  include_once('../includes/session.php');
  include_once('../database/db_user.php');

    $id = $_GET['id'];

    if(!preg_match('/^[0-9]+$/', $id)){
        die(header('Location: ../pages/home.php'));
    }

    if(!isset($_POST['collaboratorusername'])){
        $_SESSION['collaborator_error'] = 'No username inserted!';
        die(header('Location: ../pages/addCollaborator.php'));
    }
    $collaborator_name = $_POST['collaboratorusername'];

    $collaborator_id = getIdByUsername(trim($collaborator_name));

    if($collaborator_id == false){
        $_SESSION['collaborator_error'] = 'No user with that username!';
        die(header('Location: ../pages/addCollaborator.php'));
    }

    //cant be in two shelters at the same time, it is possible to have a shelter associated to another shelter 
    if(!hasNoShelter($collaborator_id)){
        $_SESSION['collaborator_error'] = 'That user is already associated with a shelter!';
        die(header('Location: ../pages/addCollaborator.php'));
    }

    //add shelterid to collaborator
    updateShelterUser($collaborator_id, $id);

    header("Location: ../pages/profilePage.php");

?>