<?php
  include_once('../includes/session.php');
  include_once('../database/db_pets.php');
  include_once('../utils/pet_utils.php');

  if($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../pages/home.php');
  }

  if(isset($_FILES['petPhotos'])){
    $id = $_GET['id'];
    if(!preg_match('/^[0-9]+$/', $id)){
      die(header('Location: ../pages/home.php'));
    }
  
    $pet = getPetInfoById($id);
    $n_previous_photos = count(getPhotosById($id));
    $j = $n_previous_photos + 1;
  
    $count = count($_FILES['petPhotos']['name']);

    if($_FILES['petPhotos']['size'] != 0 && $_FILES['petPhotos']['error'] != 0){
        for($i = 0; $i < $count; $i++){
          $filename = $_FILES['petPhotos']['name'][$i];
          $fileTmpname = $_FILES['petPhotos']['tmp_name'][$i];
          $fileSize = $_FILES['petPhotos']['size'][$i];
          $filename = $_FILES['petPhotos']['name'][$i];
          $fileError = $_FILES['petPhotos']['error'][$i];
          $fileType = $_FILES['petPhotos']['type'][$i];
  
          $fileExt = explode('.', $filename);
          $fileActualExt = strtolower(end($fileExt));
  
          $allowed_files = array('jpg', 'jpeg', 'gif', 'png');
  
          if(in_array($fileActualExt, $allowed_files)){
              if($fileError === 0){
                  $finalFileName = $id."_".$j.".".$fileActualExt;
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

                  addPhoto($id, $fileDestination, $pet['name']);
                  $j++;
              }
              else{
                echo "There was an error in this file";
              }
            }
            else{
              echo "You cannot upload this file";
            }
  
        }
        header("Location: ../pages/petProfile.php?id=$id");
    }
    else{
      echo "No file uploaded";
    }
      
  }
  else{
   echo "Can't add these photos";
  }
  
  
?>