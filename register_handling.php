<?php
session_start();
require "connect.php";


$error = "";
$success = "";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['signup'])){
    if ($_POST['userType'] === "sportif") {
        $prenom = trim($_POST['prénom']);
        $nom = trim($_POST['nom']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = $_POST['password'];
        $photo = $_POST['photo'];

        $sql = $connect->query("select id_sportif from Sportif where sportif_email = '$email' or sportif_phone = '$email;'");
        $result = $sql->fetch_assoc();
        if ($result->num_rows > 0) {
            $error = "Ce nom d'utilisateur ou cet email existe déjà";
        } else {
            $sql = $connect->query("insert into Sportif (sportif_nom, sportif_prenom, sportif_email, sportif_phone, sportif_password, sportif_photo) values ('$nom', '$prenom', '$email', '$phone', '$password' '$photo')");
            if ($sql){
                $success = "Compte créé avec succès ! Redirection...";
                header("Location: login.php");
                exit;
            }else{
                $error = "Erreur lors de la création du compte";
            }
        }
    }
    elseif($_POST['userType'] === "coach") {
        $prenom = trim($_POST['prénom']);
        $nom = trim($_POST['nom']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = $_POST['password'];
        $photo = $_POST['photo'];
        $discipline = $_POST['useraType'];

        $sql = $connect->query("select id_coach from Coach where coach_email = '$email' or Coach_phone = '$email;'");
        $result = $sql->fetch_assoc();
        if ($result->num_rows > 0) {
            $error = "Ce nom d'utilisateur ou cet email existe déjà";
        } else {
            $sql = $connect->query("insert into Coach (coach_nom, coach_prenom, coach_email, coach_phone, coach_password, coach_photo) values ('$nomSportif', '$prenomSportif', '$emailSportif', '$phoneSportif', '$passwordSportif' '$photoSportif')");
            $sql1 = $connect->query("insert into Discipline (discipline_nom) values ('$discipline')");
            if ($sql) {
                $success = "Compte créé avec succès ! Redirection...";
                header("Location: login.php");
                exit;
            } else {
                $error = "Erreur lors de la création du compte";
            }
        }
    }
    
    
}
    



/* if (strlen($username) < 3) {
        $error = "Le nom d'utilisateur doit contenir au moins 3 caractères";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas";
    } else {

        $sql = $connect->query("select id_user from users where username = '$username' or email = '$email'");
        $result = $sql->fetch_assoc();
        if ($result->num_rows > 0) {
            $error = "Ce nom d'utilisateur ou cet email existe déjà";
        } else {
            
            $sql = $connect->query("insert into users (username, email, full_name, password) values ('$username', '$email', '$full_name', '$password')");
            if ($sql) {
                $success = "Compte créé avec succès ! Redirection...";
                header("Location: login.php");
                exit;
            } else {
                $error = "Erreur lors de la création du compte";
            }
        }
    } */
?>