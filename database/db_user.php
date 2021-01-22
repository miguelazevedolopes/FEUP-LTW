<?php
  include_once('../includes/database.php');

  /**
   * Verifies if a certain username, password combination
   * exists in the database. Use the sha1 hashing function.
   */
  function checkUserPassword($username, $password) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
    $stmt->execute(array($username));
    $user = $stmt->fetch();

    return $user !== false && password_verify($password, $user['password']);
  }

  /**
   * Creates a new user with username, password, name and contact
   */
  function insertUser($username, $password, $name, $contact, $shelter) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO User VALUES(NULL,?, ?, ?, ?, "../uploads/user/defaultAvatar.png", ?, NULL)');
    $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT), $contact, $name, $shelter));
  }

  /**
   * Checks if user is a shelter or not
   */
  function isShelter($uid){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT shelter FROM User WHERE userID = ?');
    $stmt->execute(array($uid));
    $r = $stmt->fetch();

    if($r == false) return false;
    $res = $r['shelter'];
    
    if( $res == 1) return true;
    else return false;
  }

  /**
   * Checks if user is a shelter exists or not
   */
  function existsShelter($shelter_name){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM User WHERE username = ? and shelter == 1');
    $stmt->execute(array($shelter_name));
    $res = $stmt->fetch();
    if($res == false) return false;
    if( count($res) > 0) return true;
    else return false;
  }

  /**
   * Checks if user is still not associated to any shelter or not
   */
  function hasNoShelter($uid){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT shelterUser FROM User WHERE userID = ?');
    $stmt->execute(array($uid));
    $res = $stmt->fetch()['shelterUser'];
    if($res == NULL) return true;
    else return false;

  }

  /**
  * Inserts a post, with a default image
  */
  function addPost($userID, $text) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO Post VALUES(NULL, ?, ?, "../uploads/post/defaultPost.png")');
    $stmt->execute(array($userID, $text));

    $last_id = $db->lastInsertId();
    return $last_id;
  }


  /**
   * Checks if userId is a collaborator of shelterID or not, and vice-versa
   */
  function isCollaboratorOfShelter($userID, $shelterID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT shelterUser FROM User WHERE userID = ?');
    $stmt->execute(array($userID));
    $res = $stmt->fetch()['shelterUser'];
    if($res === $shelterID) return true;
    else return false;
  }


/***************************************************  UPDATES   *************************************************** */

  function updatePersonName($id, $name){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE User SET name = ? WHERE userID = ?');
    $stmt->execute(array($name, $id));
  }

  function updatePersonContact($id, $contact){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE User SET contact = ? WHERE userID = ?');
    $stmt->execute(array($contact, $id));
  }

  function updatePersonUsername($id, $username){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE User SET username = ? WHERE userID = ?');
    $stmt->execute(array($username, $id));
  }

  function updatePassword($username, $password){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE User SET password = ? WHERE username = ?');
    $stmt->execute(array(password_hash($password, PASSWORD_DEFAULT), $username));
  }

  function updateShelterUser($userID, $shelterUser){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE User SET shelterUser = ? WHERE userID = ?');
    $stmt->execute(array($shelterUser, $userID));
    //users can only be linked to one shelter at a time
  }

  function updateProfilePhoto($userID, $url){
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE User SET photoURL = ? WHERE userID = ?');
    $stmt->execute(array($url, $userID));
  }

  function updatePostPhoto($id, $photo) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Post SET photoURL = ? WHERE postID = ?');
    $stmt->execute(array($photo, $id));
  }

  /***************************************************  GETS   *************************************************** */

  function getIdByUsername($username){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT userID FROM User WHERE username = ?');
    $stmt->execute(array($username));
    return $stmt->fetch()['userID'];
  }

  function getUsernameById($userID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT username FROM User WHERE userID = ?');
    $stmt->execute(array($userID));
    return $stmt->fetch()['username'];
  }

  function getFavoritePetsByUser($userID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Favourite WHERE userID = ?');
    $stmt->execute(array($userID));
    return $stmt->fetchAll();
  }

  function getUserByID($userID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM User WHERE userID = ?');
    $stmt->execute(array($userID));
    return $stmt->fetch();
  }


  function getUserByUsername($username){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
    $stmt->execute(array($username));

    return $stmt->fetch();
  }

  function getAllColaborators($uid){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT userID, username, photoURL FROM User WHERE shelterUser = ?');
    $stmt->execute(array($uid));
    return $stmt->fetchAll();
  }

  function getUserShelter($uid){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT shelterUser FROM User WHERE userID = ?');
    $stmt->execute(array($uid));
    return $stmt->fetch()['shelterUser'];
  }

  function getAllShelters(){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT username FROM User WHERE shelter = 1');
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function getAllPosts() {
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Post');
    $stmt->execute();

    return $stmt->fetchAll();
  }

    /***************************************************  DELETES   *************************************************** */

    function deleteUser($id){
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT photoURL FROM User WHERE userID   = ?');
      $stmt->execute(array($id));
      $photo = $stmt->fetch()['photoURL'];
      $db = Database::instance()->db();
      $stmt = $db->prepare('DELETE FROM User WHERE userID = ?');
      $stmt->execute(array($id));
      if($photo != false && $photo != "../uploads/user/defaultAvatar.png") unlink($photo);
    }

    function unsetShelter($uid){
      $db = Database::instance()->db();
      $stmt = $db->prepare('UPDATE User SET shelterUser = ? WHERE userID = ?');
      $stmt->execute(array(NULL, $uid));
    }

    function unsetAllColaborators($uid){
      $db = Database::instance()->db();
      $stmt = $db->prepare('UPDATE User SET shelterUser = ? WHERE shelterUser = ?');
      $stmt->execute(array(NULL, $uid));
    }

    function deletePost($id) {
      $db = Database::instance()->db();
      $stmt = $db->prepare('SELECT photoURL FROM Post WHERE postID   = ?');
      $stmt->execute(array($id));
      $photo = $stmt->fetch()['photoURL'];
      $db = Database::instance()->db();
      $stmt = $db->prepare('DELETE FROM Post WHERE postID = ?');
      $stmt->execute(array($id));
      if($photo != false && $photo != "") unlink($photo);
    }

?>