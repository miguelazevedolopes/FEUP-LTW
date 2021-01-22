<?php 
  include_once('../includes/database.php');

  function getQuestionsforPet($petId){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Question WHERE petID = ?');
    $stmt->execute(array($petId));
    return $stmt->fetchAll();
  }

  function getQuestionsByUser($id){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Question WHERE userID = ?');
    $stmt->execute(array($id));
    return $stmt->fetchAll();
  }

  function getAnsweredQuestionsforPet($petId){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Answer JOIN Question using(questionID) WHERE petID = ?');
    $stmt->execute(array($petId));
    return $stmt->fetchAll();
  }

  function getAnswerForQuestion($questionId){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Answer WHERE questionID = ?');
    $stmt->execute(array($questionId));
    return $stmt->fetch();
  }

  function getAnsweredQuestions($userID){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT petID FROM Answer JOIN Question using(questionID) WHERE Question.userID = ?');
    $stmt->execute(array($userID));
    return $stmt->fetchAll();
  }

  function addQuestion($questionText, $petId){
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO Question VALUES(NULL, ?, ?, ? , ?)');
    $username = $_SESSION['username'];
    $userID = getIdByUsername($username);
    $date = strftime(date('Y-m-d', time()));
    $stmt->execute(array($questionText,$date, $petId,$userID));
  }

  function addAnswerForQuestion($answerText, $questionID) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO Answer VALUES(NULL, ?, ?, ?, ?)');
    $username = $_SESSION['username'];
    $userID = getIdByUsername($username);
    $date = strftime(date('Y-m-d', time()));
    $stmt->execute(array($answerText, $date, $questionID, $userID));
  }

  function updateAnswerText($answerText, $answerID) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('UPDATE Answer SET date=?, answerText=? WHERE answerID=?');
    $date = strftime(date('Y-m-d', time()));
    $stmt->execute(array($date, $answerText, $answerID));
  }


  function deletePetQuestions($id){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT questionID FROM Question WHERE petID = ?');
    $stmt->execute(array($id));
    $questionID = $stmt->fetch()['questionID'];

    $stmt = $db->prepare('DELETE FROM Question WHERE petID = ?');
    $stmt->execute(array($id));

    return $questionID;
  }

  function deleteQuestion($questionID) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('DELETE FROM Question WHERE questionID = ?');
    $stmt->execute(array($questionID));
  }

  function deleteAnswerByQuestionID($questionID) {
    $db = Database::instance()->db();
    $stmt = $db->prepare('DELETE FROM Answer WHERE questionID = ?');
    $stmt->execute(array($questionID));
  }
  
?>