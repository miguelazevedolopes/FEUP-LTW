<?php
    session_start();

    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = sha1(date("Y-m-d-H-i-s"));
    }
?>