<?php
session_start();
require "connect.php";


$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sqlSporitf = $connect->query("select * from Sportif where username = '$username' or email = '$username'");
    $sqlCoach = $connect->query("select * from Coach where username = '$username' or email = '$username'");


    if ($sqlSportif) {
        $sportif = $sqlSportif->fetch_assoc();
        if ($sportif["password"] === $password) {
            $_SESSION['user_id'] = $sportif['id_user'];
            $_SESSION['username'] = $sportif['username'];
            $_SESSION['email'] = $sportif['email'];
            $_SESSION['full_name'] = $sportif['full_name'];
            
            header("Location: index.php");
            exit();
        }else {
            $error = "Nom d'utilisateur ou mot de passe incorrect";
        }
    } elseif($sqlCoach) {
        $user = $sqlCoach->fetch_assoc();
        if ($user["password"] === $password) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['full_name'] = $user['full_name'];
            
            header("Location: index.php");
            exit();
        }else {
            $error = "Nom d'utilisateur ou mot de passe incorrect";
        }
    }else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>