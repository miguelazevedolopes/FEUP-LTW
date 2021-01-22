<?php 
    include_once('../includes/session.php');
    include_once('../includes/database.php');
    include_once('../includes/session.php');
    include_once('../database/db_user.php');

    $userID = getIdByUsername($_SESSION['username']);	

    if(!preg_match('/^[0-9]+$/', $userID)){
        die(header('Location: ../pages/home.php'));
      }
    
    $favPets = getFavoritePetsByUser($userID);
    if(isset($_SESSION['username'])){
      echo json_encode($favPets);
    }

    
?>