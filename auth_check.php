<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user = [
    'user_id' => $_SESSION['user_id'],
    'user_name' => $_SESSION['username'],
    'user_email' => $_SESSION['user_email'],
    'user_type' => $_SESSION['user_type']
]
?>