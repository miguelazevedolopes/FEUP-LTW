<?php
    include_once("../includes/session.php");
    include_once('../database/db_pets.php');
    include_once('../utils/pet_utils.php');

    if($_SESSION['csrf'] !== $_POST['csrf']) {
      header('Location: ../pages/home.php');
    }

    $id = $_GET['id'];

    if(!preg_match('/^[0-9]+$/', $id)){
      die(header('Location: ../pages/home.php'));
    }

    $pet = getPetInfoById($id);

    if(isset($_POST['submit'])){
      
      $species = trim($_POST['petSpecies']);
      $name = trim($_POST['petName']);
      $location = trim($_POST['petCity']);
      $sex = trim($_POST['petSex']);
      $sex_int = sexToInt($sex);
      $age = trim($_POST['petAge']);
      $size = trim($_POST['petSize']);
      $size_int = sizeToInt($size);
      $about_me = trim($_POST['aboutme']);
 

      //verifying inputs 
      function testAboutMe($text){
        if(preg_match('/^[^\w" "]/',$text))return false;
        if (preg_match('/(?=[^\w \-\,\;\!\"\(\)\'.?: ])/', $text)) return false;
        if (preg_match('/(?=[\-\,\;\!\"\(\)\'.?:]{2})/', $text)) return false;
        if(strlen($text) >= 500) return false;
        else return true;
      }
      
      if(strlen($name) != 0 && !preg_match("/\w+, \w+/", $name)){
        $_SESSION['edit_error'] =   "Invalid name format: name, race";
        die(header('Location: ../pages/editPetProfile.php?id='.$id));
      }
      
      if(strlen($age) != 0 &&!preg_match("/\w+/", $age)){
        $_SESSION['edit_error'] = "Invalid age";
        die(header('Location: ../pages/editPetProfile.php?id='.$id));
      }
    
      if(strlen($location) != 0 && !preg_match("/^[a-zA-Z]+$/", $location)){
        $_SESSION['edit_error'] = "Invalid location";
        die(header('Location: ../pages/editPetProfile.php?id='.$id));
      }
      
      if(strlen($about_me) != 0  && !testAboutMe($about_me)){
        $_SESSION['edit_error'] = "Invalid text: more than of 500 characters or invalid characters";
        die(header('Location: ../pages/editPetProfile.php?id='.$id));
      }
      if(($sex_int == -1) || ($size_int == -1) || ($species != "dog" && $species != "cat" && $species != "pig" && $species != "other animals")){
        die(header('Location: ../pages/home.php'));
      }
      

      //updating the wanted fields
      if(strlen($name)!=0 && $name != $pet['name']){
        updateName($id, $name);
      }
      if(strlen($location)!=0 && $location != $pet['location']){
        updateLocation($id, $location);
      }
      if(strlen($age)!=0 && $age != $pet['age']){
        updateAge($id, $age);
      }
      if($species != $pet['species']){
        updateSpecies($id, $species);
      }
      if($sex_int != $pet['sex']){
        updateSex($id, $sex_int);
      }
      if($size_int != $pet['size']){
        updateSize($id, $size_int);
      }
      if(strlen($about_me)!=0){
        updateAboutme($id, $about_me);
      }
          
    }
    else echo "Can't update this pet";
  
    header("Location: ../pages/petProfile.php?id=$id");
?>