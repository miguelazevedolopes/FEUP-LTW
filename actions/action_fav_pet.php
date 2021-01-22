<?php 
    include_once('../includes/database.php');
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_pets.php');

    $petID = $_GET['id'];

    if(!preg_match('/^[0-9]+$/', $petID)){
        die(header('Location: ../pages/home.php'));
      }
    
    $userID = getIdByUsername($_SESSION['username']);
    addFav($petID, $userID);
?>