<?php
  include_once('../includes/database.php');
  include_once('../utils/pet_utils.php');
  include_once('../database/db_user.php');

  /**
   * Verifies if there is a pet with this id
   */
  function petExists($id){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Pet WHERE  PetID = ?');
    $stmt->execute(array($id));
    return $stmt->fetch();
  }

  /**
   * Verifies if there is a pet with this id and if it is not adopted 
   */
  function petExistsAvailable($id){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Pet WHERE PetID = ? AND state = 0');
    $stmt->execute(array($id));
    return $stmt->fetch();
  }

/***************************************************  ADDS   *************************************************** */
  /**
   * Creates a new pet 
   */
  function addPet($species, $name,$age, $location,$sex,$rescuer, $size, $aboutMeText) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO Pet VALUES(NULL, ?, ?, ?, ?, 0, ?, ?, ?, ?)');
    $stmt->execute(array($species,$name,$age,$location, $sex, $rescuer, $size, $aboutMeText));
    
    $last_id = $db->lastInsertId();

    return $last_id;

  }

  function addPhoto($id, $photo, $name){
    $altText = "Photo of ". $name;
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO Photo VALUES(NULL, ?, ?, ?)'); 
    $stmt->execute(array($photo,$altText,$id));
  }

  function addFav($petID, $userID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO Favourite VALUES(NULL, ?, ?)'); 
    
    $stmt->execute(array($petID,$userID));
  }

/***************************************************  GETS   *************************************************** */

  function getPetId($species, $name, $age, $location, $sex, $rescuer, $size){
    $sex_int = sexToInt($sex);
    $size_int = sizeToInt($size);
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT PetId FROM Pet WHERE species = ? AND name = ? AND age = ? AND location = ? AND sex = ? AND rescuer = ? AND size = ? ');
    $stmt->execute(array($species,$name,$age,$location, $sex_int, $rescuer, $size_int));

    return $stmt->fetch()['PetId'];
  }

  function getPetInfoById($id){
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Pet WHERE PetId = ?');
      $stmt->execute(array($id));

      return $stmt->fetch();
  }

  function getPhotosById($id){
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Photo WHERE PetId = ?');
      $stmt->execute(array($id));
      
      return $stmt->fetchAll();
  }

  function getAllPhotos(){
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Photo');
      $stmt->execute(array());

      return $stmt->fetchAll();
  }

  function getNumberOfPets(){
    $db= Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Pet');
    $stmt->execute(array());
    $pets=$stmt->fetchAll();
    return count($pets);
  }

  function getPetsByUserAux($id) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT * FROM Pet WHERE Rescuer = ?');
      $stmt->execute(array($id));

      return $stmt->fetchAll();
  }
  
  function getPetsByUser($id) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Pet WHERE Rescuer = ?');
    $stmt->execute(array($id));
    $res = $stmt->fetchAll();

    $collaborator = !hasNoShelter($id);
    $shelter = isShelter($id);
    if(!($collaborator || $shelter)) return $res; //case of not being either a shelter or a collaborator
    else if($shelter){ //user is a shelter
      //add all collaborators pets given
      $collaborators = getAllColaborators($id);
      foreach($collaborators as $c){
        $aux = getPetsByUserAux($c['userID']);
        $auxiliar = array_merge((array)$res, $aux);
        $res = $auxiliar;
      }
      return $res;
    }
    else if($collaborator){//user is a collaborator
      //add shelter pets given
      $shelterID = getUserShelter($id);
      $res1 =  getPetsByUserAux($shelterID);
      $ret = array_merge($res, $res1);
      return $ret;
    }

}
/***************************************************  DELETES   *************************************************** */
  function deletePet($id){
    
    deletePetPhotos($id);

    $db = Database::instance()->db();
    $stmt = $db->prepare('DELETE FROM Pet WHERE petID = ?');
    $stmt->execute(array($id));
  }

  function deletePetPhotos($id){
    $photos = getPhotosById($id);
    $count = count($photos);
    for($i=0; $i<$count;$i++){
      unlink($photos[$i]['url']);
    }
  }

  function unfav($userID, $petID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('DELETE FROM Favourite WHERE petID = ? AND userID = ?'); 
    $stmt->execute(array($petID,$userID));
  }

  /***************************************************  UPDATES   *************************************************** */

  function updateSpecies($id, $species){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Pet SET species = ? WHERE petID = ?');
    $stmt->execute(array($species, $id));
  }

  function updateName($id, $name){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Pet SET name = ? WHERE petID = ?');
    $stmt->execute(array($name, $id));
  }

  function updateAge($id, $age){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Pet SET age = ? WHERE petID = ?');
    $stmt->execute(array($age, $id));
  }

  function updateLocation($id, $location){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Pet SET location = ? WHERE petID = ?');
    $stmt->execute(array($location, $id));
  }

  function updateSex($id, $sex){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Pet SET sex = ? WHERE petID = ?');
    $stmt->execute(array($sex, $id));
  }

  function updateSize($id, $size){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Pet SET size = ? WHERE petID = ?');
    $stmt->execute(array($size, $id));
  }
  function updateAboutme($id, $aboutme){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Pet SET aboutmeText = ? WHERE petID = ?');
    $stmt->execute(array($aboutme, $id));
  }
  function updateState($id, $state){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Pet SET state = ? WHERE petID = ?');
    $stmt->execute(array($state, $id));
  }


?>