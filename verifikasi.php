<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['iduser']);
}

function redirectToLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}
?>
