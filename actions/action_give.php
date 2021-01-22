<?php
  include_once('../includes/database.php');
  include_once('../includes/session.php');
  include_once('../database/db_pets.php');
  include_once('../database/db_user.php');
  include_once("../database/db_questions.php");
  include_once("../database/db_proposal.php");
  include_once('../utils/pet_utils.php');

  if($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../pages/home.php');
  }

  if(isset($_POST['submit'])){
    $species = trim($_POST['petSpecies']);
    $name = trim($_POST['petName']);
    $location = trim($_POST['petCity']);
    $sex = trim($_POST['petSex']);
    $sex_int = sexToInt($sex);
    $age = trim($_POST['petAge']);
    $size = trim($_POST['petSize']);
    $size_int = sizeToInt($size);
    $about_me = 'Hi there my name is '.$name."!<br>".$name.' xxx';
    $rescuer = getIdByUsername($_SESSION['username']);
    
    
    if(!preg_match("/\w+, \w+/", $name)){
      $_SESSION['give_error'] =   "Invalid name format";
      die(header('Location: ../pages/give.php'));
    }
    
    if(!preg_match("/\w+/", $age)){
      $_SESSION['give_error'] = "Invalid age";
      die(header('Location: ../pages/give.php'));
    }
    if(!preg_match("/^[a-zA-Z]+$/", $location)){
      $_SESSION['give_error'] = "Invalid location";
      die(header('Location: ../pages/give.php'));
    }
    if(($sex_int == -1) || ($size_int == -1) || ($species != "dog" && $species != "cat" && $species != "pig" && $species != "other animals")){
      die(header('Location: ../pages/home.php'));
    }
    
    if(isset($_FILES['petPhoto'])){
     
      $file = $_FILES['petPhoto'];
      $filename = $_FILES['petPhoto']['name'];
      $fileTmpname = $_FILES['petPhoto']['tmp_name'];
      $fileSize = $_FILES['petPhoto']['size'];
      $filename = $_FILES['petPhoto']['name'];
      $fileError = $_FILES['petPhoto']['error'] ;
      $fileType = $_FILES['petPhoto']['type'];

      $fileExt = explode('.', $filename);
      $fileActualExt = strtolower(end($fileExt));

      $allowed_files = array('jpg', 'jpeg', 'gif', 'png');

      if(in_array($fileActualExt, $allowed_files)){
        if($fileError === 0){

            $id = addPet($species, $name ,$age, $location, $sex_int, $rescuer, $size_int, $about_me);
            
            $finalFileName = $id.".".$fileActualExt;
            $fileDestination = '../uploads/pet/'.$finalFileName;
            
            move_uploaded_file($fileTmpname, $fileDestination);

            $original = imagecreatefromstring(file_get_contents($fileDestination));
            $width = imagesx($original);     // width of the original image
            $height = imagesy($original);    // height of the original image
            $square = min($width, $height);  // size length of the maximum square
            
            // Create and save a square photo
            $img = imagecreatetruecolor(350, 350);
            imagecopyresized($img, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 350, 350, $square, $square);
            imagejpeg($img, $fileDestination);

            addPhoto($id, $fileDestination, $name);
            header("Location: ../pages/petProfile.php?id=$id");
        }
        else if($fileError === 1){
          $_SESSION['give_error'] = "Image is too big";
          die(header('Location: ../pages/give.php'));
        }
        else{
          echo "There was an error in this file";
        }
      }
      else{
        $_SESSION['give_error'] = "Invalid file";
          die(header('Location: ../pages/give.php'));
        echo "You cannot upload this file";
      }
    }

  }
  else echo "Can't create this pet";


?>