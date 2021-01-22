<?php function draw_login() { 
/**
 * Draws the login section.
 */ ?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/13.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Coiny&family=Roboto&family=Varela+Round&display=swap"
        rel="stylesheet">
</head>

<body id="bodyForm">
    <div class="bodyFormFilter">
        <div class="infoText">
            <img src="../img/white_footprint.png" alt="footprint">
            <a href="../pages/home.php">
                <h1>Buddy Resc</h1>
            </a>
            <h2>RESCUE PETS FOR ADOPTION.</h2>
            <h3>CREATE HAPINESS. SAVE LIVES</h3>
        </div>
        <div class="login">
            <h2>LOGIN</h2>
            <form method="post" action="../actions/action_login.php">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input id="username" name="username" type="username" placeholder="Username" autocomplete="off" required>
                <input id="password" name="password" type="password" placeholder="Password" autocomplete="off" required>
                <p><?php if(isset($_SESSION['login_error'])) echo "<span class='login_register_error'>" . $_SESSION['login_error'] . "</span>";?>
                </p>
                <input type="submit" value="Login"><br>
                <span class="form-toggle">Don't have an account? <a href="register.php">Register</a></span>
            </form>
            <?php
              unset($_SESSION['login_error']);
            ?>
        </div>

    </div>
</body>

</html>
<?php } ?>

<?php function draw_register() { 
/**
 * Draws the register section.
 */ ?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <link rel="icon" href="../img/13.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Coiny&family=Roboto&family=Varela+Round&display=swap"
        rel="stylesheet">
</head>

<body id="bodyForm">
    <div class="bodyFormFilter">
        <div class="infoText">
            <img src="../img/white_footprint.png" alt="footprint">
            <a href="../pages/home.php">
                <h1>Buddy Resc</h1>
            </a>
            <h2>RESCUE PETS FOR ADOPTION.</h2>
            <h3>CREATE HAPINESS. SAVE LIVES</h3>
        </div>
        <div class="register">
            <h2>REGISTER</h2>
            <form method="post" action="../actions/action_register.php">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input id="name" name="name" type="text" placeholder="Name" autocomplete="off"
                    value="<?php if (isset($_SESSION['new_name'])) { echo $_SESSION['new_name']; }?>" required>
                <input id="username" name="username" type="text" placeholder="Username" autocomplete="off"
                    value="<?php if (isset($_SESSION['new_username'])) { echo $_SESSION['new_username']; }?>" required>
                <input id="contact" name="contact" type="tel" placeholder="Contact" autocomplete="off"
                    value="<?php if (isset($_SESSION['new_contact'])) { echo $_SESSION['new_contact']; }?>" required>
                <input id="password" name="password" type="password" placeholder="Password" autocomplete="off" required>
                <p><?php if(isset($_SESSION['register_error'])) echo "<span class='login_register_error'>" . $_SESSION['register_error'] . "</span>";?>
                </p>
                <label for="shelter"> Shelter</label>
                <div id="shelter">
                    <input id="shelteryes" name="shelter" type="radio" value="yes">
                    <label for="shelteryes" class="config-select">Yes</label>
                    <input id="shelterno" name="shelter" type="radio" value="no" checked>
                    <label for="shelterno" class="config-select">No</label><br><br>
                </div>
                <p><?php if(isset($_SESSION['register_error'])) echo "<span class='login_register_error'>" . $_SESSION['register_error'] . "</span>";?>
                </p>
                <input type="submit" value="Register"> <br>
                <span class="form-toggle">Do you already have an account? <a href="login.php">Login</a></span>
                <?php
                unset($_SESSION['register_error']);
                unset($_SESSION['new_name']);
                unset($_SESSION['new_username']);
                unset($_SESSION['new_contact']);
            ?>
            </form>
        </div>

    </div>
</body>

</html>

<?php } ?>