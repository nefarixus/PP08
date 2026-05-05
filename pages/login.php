<?php
    session_start();
    $show_success = false;

    if (isset($_GET['registered']) && isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
        $show_success = true;
        $email = htmlspecialchars($_SESSION['registered_email']);
        unset($_SESSION['registration_success'], $_SESSION['registered_email']);
    }
?>
