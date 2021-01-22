<?php
  include_once("../includes/session.php");
  include_once("../database/db_user.php");

  if($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../pages/home.php');
  }

  $name = trim($_POST['name']);
  $username = trim($_POST['username']);
  $contact = trim($_POST['contact']);

  $person = getUserByUsername($_SESSION['username']);

  if (!preg_match ("/^[a-zA-Z -]+$/", $name)) {
    $_SESSION['name_error'] = 'Name can only contain letters!';
    die(header('Location: ../pages/editProfile.php'));
  }
  
  if(preg_match('/\s/', $username)){
    $_SESSION['username_error'] = 'Username can not have whitespaces!';
    die(header('Location: ../pages/editProfile.php'));
  }
  if(!preg_match("/^[1-9][0-9]{8}$/", $contact)){
    $_SESSION['contact_error'] = 'Contact must only have 9 digits!';
    die(header('Location: ../pages/editProfile.php'));
  }

  try {
    if(isset($name) && ($name != $person['name'])){
        updatePersonName($person['userID'], $name);
      }
  } catch (PDOException $e) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Name is not valid!');
    die(header('Location: ../pages/editProfile.php'));
  }

  try {
    if(isset($contact) && ($contact != $person['contact']))
    updatePersonContact($person['userID'], $contact);
  } catch (PDOException $e) {
    $_SESSION['contact_error'] = 'Contact must only have 9 digits!';
    die(header('Location: ../pages/editProfile.php'));
  }

  try {
    if(isset($username) && ($username != $person['username'])){
        updatePersonUsername($person['userID'], $username);  
        $_SESSION['username'] = $username;
    }
  } catch (PDOException $e) {
    $_SESSION['username_error'] = 'Username already exists!';
    die(header('Location: ../pages/editProfile.php'));
  }

  if(isset($_FILES['profilePhoto'])){

    $file = $_FILES['profilePhoto'];
    $filename = $_FILES['profilePhoto']['name'];
    $fileTmpname = $_FILES['profilePhoto']['tmp_name'];
    $fileSize = $_FILES['profilePhoto']['size'];
    $filename = $_FILES['profilePhoto']['name'];
    $fileError = $_FILES['profilePhoto']['error'] ;
    $fileType = $_FILES['profilePhoto']['type'];

    $fileExt = explode('.', $filename);
    $fileActualExt = strtolower(end($fileExt));

    $allowed_files = array('jpg', 'jpeg', 'gif', 'png');

    if(in_array($fileActualExt, $allowed_files)){
      if($fileError === 0){
          $finalFileName = $person['userID'].".".$fileActualExt;
          $fileDestination = '../uploads/user/'.$finalFileName;

          move_uploaded_file($fileTmpname, $fileDestination);

          $original = imagecreatefromstring(file_get_contents($fileDestination));
          $width = imagesx($original);     // width of the original image
          $height = imagesy($original);    // height of the original image
          $square = min($width, $height);  // size length of the maximum square

          // Create and save a square photo
          $img = imagecreatetruecolor(400, 400);
          imagecopyresized($img, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 400, 400, $square, $square);
          imagejpeg($img, $fileDestination);

          updateProfilePhoto($person['userID'], $fileDestination);
      }
      elseif($fileError === 1){
        $_SESSION['give_error'] = "Image is too big";
        die(header('Location: ../pages/give.php'));
      }
      else{
        echo "There was an error in this file";
      }
    }
    else{
      echo "You cannot upload this file";
    }
  }

  header('Location: ../pages/profilePage.php');
?>