<?php
    include_once("../includes/session.php");
    include_once("../database/db_user.php");

    function testPost($text){
      if(preg_match('/^[^A-Za-z" "]/',$text))return false;
      if (preg_match('/(?=[^\w \-\,\;\!\"\(\)\'.?: ])/', $text)) return false;
      if (preg_match('/(?=[\-\,\;\!\"\(\)\'.?:]{2})/', $text)) return false;
      elseif(strlen($text) >= 200 || strlen($text) == 0) return false;
      else return true;
    }

    $text = $_POST['text'];
    $user = getIdByUsername($_SESSION['username']);

    if (!testPost($text)) {
        $_SESSION['post_error'] = "Invalid input characters";
        die(header('Location: ../pages/gallery.php'));
    }

    $id = addPost($user, $text);

    if(isset($_FILES['postPhoto'])){
      $file = $_FILES['postPhoto'];
      $filename = $_FILES['postPhoto']['name'];
      $fileTmpname = $_FILES['postPhoto']['tmp_name'];
      $fileSize = $_FILES['postPhoto']['size'];
      $filename = $_FILES['postPhoto']['name'];
      $fileError = $_FILES['postPhoto']['error'] ;
      $fileType = $_FILES['postPhoto']['type'];

      $fileExt = explode('.', $filename);
      $fileActualExt = strtolower(end($fileExt));

      $allowed_files = array('jpg', 'jpeg', 'gif', 'png');

      if(in_array($fileActualExt, $allowed_files)){
        if($fileError === 0){
            $finalFileName = $id.".".$fileActualExt;
            $fileDestination = '../uploads/post/'.$finalFileName;

            move_uploaded_file($fileTmpname, $fileDestination);

            $original = imagecreatefromstring(file_get_contents($fileDestination));
            $width = imagesx($original);     // width of the original image
            $height = imagesy($original);    // height of the original image
            $square = min($width, $height);  // size length of the maximum square

            // Create and save a square photo
            $img = imagecreatetruecolor(350, 350);
            imagecopyresized($img, $original, 0, 0, ($width>$square)?($width-$square)/2:0, ($height>$square)?($height-$square)/2:0, 350, 350, $square, $square);
            imagejpeg($img, $fileDestination);

            updatePostPhoto($id, $fileDestination);
            header("Location: ../pages/gallery.php");
        }
        elseif($fileError === 1){
          deletePost($id);
          $_SESSION['post_error'] = "Image is too big";
          die(header('Location: ../pages/gallery.php'));
        }
        else{
          deletePost($id);
          $_SESSION['post_error'] = "There was an error in this file";
          header("Location: ../pages/gallery.php");
        }
      }
      else{
        deletePost($id);
        $_SESSION['post_error'] = "You cannot upload this file";
        header("Location: ../pages/gallery.php");
      }
    } else {
      deletePost($id);
      header("Location: ../pages/gallery.php");
    }


  header("Location: ../pages/gallery.php");
?>