<?php
// Turn on error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session and check if user is logged in
session_start();
require "connect.php";

// Check if user is logged in and is a coach
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'coach') {
    header("Location: login.php");
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Get the user ID from session
    $user_id = $_SESSION['user_id'];
    
    // Get all the form data
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $biographie = $_POST['biographie'];
    $experience = $_POST['experience'];
    $prix = $_POST['prix'];
    
    // Check if email already exists for another user
    $checkEmail = $connect->prepare("SELECT id_coach FROM Coach WHERE coach_email = ? AND id_coach != ?");
    $checkEmail->bind_param("si", $email, $user_id);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    // If email exists for another user, show error
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Cet email est déjà utilisé par un autre compte";
        header("Location: dashboard_coach.php");
        exit();
    }
    
    // Update the coach's information
    $updateQuery = $connect->prepare("UPDATE Coach SET coach_prenom = ?, coach_nom = ?, coach_email = ?, coach_phone = ?, coach_biographie = ?, coach_annees_experiences = ?, coach_prix = ? WHERE id_coach = ?");
    $updateQuery->bind_param("sssssiii", $prenom, $nom, $email, $phone, $biographie, $experience, $prix, $user_id);
    
    // Execute the update
    if ($updateQuery->execute()) {
        // Update session name
        $_SESSION['user_name'] = $prenom . ' ' . $nom;
        
        // Success message
        $_SESSION['success'] = "Votre profil a été mis à jour avec succès!";
        header("Location: dashboard_coach.php");
        exit();
    } else {
        // Error message
        $_SESSION['error'] = "Erreur lors de la mise à jour: " . $connect->error;
        header("Location: dashboard_coach.php");
        exit();
    }
    
} else {
    // If not POST request, redirect to dashboard
    header("Location: dashboard_coach.php");
    exit();
}
?>