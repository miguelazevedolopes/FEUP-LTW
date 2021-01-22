<?php function draw_profile($profile) { 
/**
 * Draws the person's profile.
 */ 
  $uid = getIdByUsername($_SESSION['username']);

  
  if(isShelter($uid)){
      draw_shelter_profile($profile, $uid);
  }
  else{

?>
<main id="profilePage">
    <div id="personProfile">
        <div id="photo-edit-info">
            <img id="personProfile-avatar" src="<?= $profile['photoURL']?>" alt="avatar">
            <div id="changeInfo" data-link1="../actions/action_delete_account.php?id=<?= $uid?>"
                data-link2="../pages/profilePage.php">
                <div id="editProfile"> <a href="editProfile.php">Edit Profile</a></div>
                <div id="changePassword"><a href="changePassword.php">Change Password</a></div>
                <a id="personDeleteButton" href="#">Delete </a>
            </div>
        </div>
        <div id="personProfile-info">
            <h3>Name</h3>
            <p><?= htmlspecialchars($profile['name'])?></p>
            <h3>Username</h3>
            <p><?= htmlspecialchars($profile['username'])?></p>
            <h3>Contact</h3>
            <p><?= htmlspecialchars($profile['contact'])?></p>
        </div>

    </div>
    <?php draw_info_profile($profile, $uid); ?>
</main>
<?php } ?>
<?php } ?>

<?php function draw_edit_profile($profile, $username) { 
/**
 * Draws the person's profile to be edited.
 */ ?>
<main id="profilePage">
    <form id="personProfile" enctype="multipart/form-data" action="../actions/action_edit_profile.php" method="POST">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <div id="photo-edit-info">
            <img id="personProfile-avatar" src="<?= urlencode($profile['photoURL'])?>" alt="avatar">
            <div id="changeInfo">
                <div id="uploadPhoto">
                    <input type="file" id="profilePhoto" name="profilePhoto" class="custom-file-input"
                        accept=".jpeg,.jpg,.png,.gif" required hidden>
                    <label for="profilePhoto" id="selector">Upload a Photo</label>
                </div>
            </div>
        </div>
        <div id="personProfile-info">
            <h3>Name</h3>
            <p><input type="text" name="name" id="name" value="<?=htmlspecialchars($profile['name'])?>"
                    autocomplete=off><?php if(isset($_SESSION['name_error'])) echo "<span class='inputError'>" . $_SESSION['name_error'] . "</span>";?>
            </p>
            <h3>Username</h3>
            <p><input type="text" name="username" id="username" value="<?=htmlspecialchars($profile['username'])?>"
                    autocomplete=off><?php if(isset($_SESSION['username_error'])) echo "<span class='inputError'>" . $_SESSION['username_error'] . "</span>";?>
            </p>
            <h3>Contact</h3>
            <p><input type="tel" name="contact" id="contact" value="<?= htmlspecialchars($profile['contact'])?>"
                    autocomplete=off><?php if(isset($_SESSION['contact_error'])) echo "<span class='inputError'>" . $_SESSION['contact_error'] . "</span>";?>
            </p>
            <div id="actionProfile">
                <input type="submit" value="Submit">
                <a href="../pages/profilePage.php">Cancel</a>
            </div>
        </div>
        <?php
          unset($_SESSION['name_error']);
          unset($_SESSION['contact_error']);
          unset($_SESSION['username_error']); 
        ?>

    </form>
</main>

<?php } ?>

<?php function draw_change_password($profile, $username) { 
/**
 * Draws the "change password" form.
 */ ?>

<main id="profilePage">
    <form id="personProfile" action="../actions/action_change_password.php" method="POST">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <div id="photo-edit-info">
            <img id="personProfile-avatar" src="<?= urlencode($profile['photoURL'])?>" alt="avatar">
        </div>
        <div id="personProfile-info">
            <h3>Current Password</h3>
            <p><input type="password" name="password" id="password" autocomplete=off required>
                <?php if(isset($_SESSION['password_error'])) echo "<span class='inputError'>" . $_SESSION['password_error'] . "</span>";?>
            </p>
            <h3>New Password</h3>
            <p><input type="password" name="newPassword" id="newPassword" autocomplete=off
                    required><?php if(isset($_SESSION['new_password_error'])) echo "<span class='inputError'>" . $_SESSION['new_password_error'] . "</span>";?>
            </p>
            <h3>Confirm Password</h3>
            <p><input type="password" name="confirmPassword" id="confirmPassword" autocomplete=off
                    required><?php if(isset($_SESSION['confirm_password_error'])) echo "<span class='inputError'>" . $_SESSION['confirm_password_error'] . "</span>";?>
            </p>
            <div id="actionProfile">
            <input type="submit" value="Submit">
            <a href="../pages/profilePage.php">Cancel</a>
            </div>
        </div>
        <?php
        unset($_SESSION['password_error']);
        unset($_SESSION['new_password_error']);
        unset($_SESSION['confirm_password_error']); 
      ?>
        
    </form>
</main>

<?php } ?>

<?php function draw_info_profile($profile, $uid) {
/**
 * Draws the info section of the profile
 */
?>
<div class="infoProfile">
    <div class="announcementInfo" id="announcementInfo" data-link="userspets.php?id=1">
        <h2>Pet's Announcements</h2>
        <p>Click here to see more information.</p>
    </div>
    <div class="proposalInfo" id="proposalInfo" data-link="userspets.php?id=0">
        <h2>Pet's Proposals</h2>
        <p>Click here to see more information.</p>
    </div>
</div>

<?php } ?>


<?php function draw_shelter_profile($profile, $uid) {
/**
 * Draws the shelter's profile, similiar to other users but with more functionalities
 */
?>
<main id="profilePage">
    <div id="personProfile">
        <div id="photo-edit-info">
            <img id="personProfile-avatar" src="<?= $profile['photoURL']?>" alt="avatar">
            <div id="changeInfo" data-link1="../actions/action_delete_account.php?id=<?= $uid?>"
                data-link2="../pages/profilePage.php">
                <div id="editProfile"> <a href="editProfile.php">Edit Profile</a></div>
                <div id="changePassword"><a href="changePassword.php">Change Password</a></div>
                <div id="addCollaborator"><a href="addCollaborator.php">Add Collaborator</a></div>
                <div id="seeCollaborators"><a href="seeCollaborators.php">See Collaborators</a></div>
                <a id="shelterDeleteButton" href="#">Delete </a>
            </div>
        </div>
        <div id="personProfile-info">
            <h2>Shelter</h2>
            <h3>Name</h3>
            <p><?= htmlspecialchars($profile['name'])?></p>
            <h3>Username</h3>
            <p><?= htmlspecialchars($profile['username'])?></p>
            <h3>Contact</h3>
            <p><?= htmlspecialchars($profile['contact'])?></p>
        </div>
        
    </div>
    <?php draw_info_profile($profile, $uid); ?>
</main>

<?php } ?>


<?php function draw_add_collaborator($profile) {
/**
 * Draws the add colaborator form.
 */
  $uid = $profile['userID'];
?>
<main id="profilePage">
    <form id="personProfile" enctype="multipart/form-data" action="../actions/action_add_collaborator.php?id=<?=$uid ?>"
        method="POST">
        <div id="photo-edit-info">
        <img id="personProfile-avatar" src="<?= urlencode($profile['photoURL'])?>" alt="avatar">
        </div>
        <div id="personProfile-info">
            <h3>Add a new collaborator</h3><br><br>
            <label for="collaboratorusername"> Collaborator username</label>
            <p><input type="text" name="collaboratorusername" id="collaboratorusername"
                    autocomplete=off><?php if(isset($_SESSION['collaborator_error'])) echo "<span class='inputError'> " . $_SESSION['collaborator_error'] . "</span>";?>
            </p>
            <div id="actionProfile">
                <input type="submit" value="Submit">
                <a href="../pages/profilePage.php">Cancel</a>
            </div>
        </div>
        <?php
          unset($_SESSION['collaborator_error']);
        ?>
    </form>

</main>
<?php } ?>


<?php function draw_see_collaborators( $username) {
/**
 * Draws the see colaborators section.
 */
  include_once('../database/db_user.php');

  $uid = getIdByUsername($username);
  $collaborators = getAllColaborators($uid);

  if(count($collaborators) <= 0){

?>
<main id="seeColaborators">
    <div id="nocollaborators">
        <br><br>
        <p> You don't have any collaborators yet! Add one <a href="../pages/addCollaborator.php"> here</a>.</p>
    </div>
    <div id="goback">
        <a href="../pages/profilePage.php">Go back to profile page</a>
    </div>

</main>
<?php }
    else{
  ?>
<main id="seeColaborators">
    <h2> Your shelter collaborators</h2>
    <div id="collaborators-display">
        <?php foreach($collaborators as $collaborator){?>
        <div id="collaborator" data-link1="../actions/action_delete_collaborator.php?id=<?=$collaborator['userID']?>" data-link2="../pages/seeCollaborators.php">
            <img id="collaborator-image" src="<?= urlencode($collaborator['photoURL'])?>" />
            <p> <?= htmlspecialchars($collaborator['username'])?></p>
            <input type="button" value="Delete" id="deleteButton" name="delete" class="buttonDelete" />
        </div>
        <?php }?>
    </div>
    <div id="goback">
        <a href="../pages/profilePage.php">Go back to profile page</a>
    </div>
</main>
<?php } ?>
<?php } ?>