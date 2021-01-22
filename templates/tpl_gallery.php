<?php
    include_once('../database/db_user.php');

function draw_gallery() {
    $post = getAllPosts();
    ?>

    <div class="gallery">
        <div id="gallery-banner">
            <h2>GALLERY</h2>
        </div>

    <?php
    foreach ($post as $post) {
        draw_gallery_post($post);
    }
    ?>

    </div>

    <?php
}

function draw_gallery_post($post) {
    ?>

    <div class="gallery-post">
        <img src=<?=urlencode($post['photoURL'])?> alt=<?=htmlspecialchars($post['text'])?> >
        <h2><?=htmlspecialchars($post['text'])?></h2>
    </div>

    <?php
}

function draw_add_post($userID) {
    ?>

    <div id="postCard">
        <h3>Make a Post</h3>
        <form id="postCardForm" action="../actions/action_post.php" method="POST" enctype="multipart/form-data">
            ​<textarea id="text" name="text" rows="6" cols="20" placeholder="Share your pet's life!"
                maxlength="200"></textarea><br>
            <div id="uploadPhoto">
                <input type="file" id="postPhoto" name="postPhoto" class="custom-file-input"
                    accept=".jpeg,.jpg,.png,.gif" required hidden>
                <label for="postPhoto" id="selector">Upload a Photo</label>
            </div><br>
            <?php
                if(isset($_SESSION['post_error'])) {
                    echo "<p><span class='post_error'>" . $_SESSION['post_error'] . "</span></p>";
                    unset($_SESSION['post_error']);
                }
            ?>
            <input id="postbutton" type="submit" value="Post"><br>
            <p id="font" size="1">(Maximum characters: 200)</p>
        </form>
    </div>

    <?php
}

?>