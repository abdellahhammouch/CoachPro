<?php
// Turn on error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session and check if user is logged in
session_start();
require "connect.php";

// Check if user is logged in and is an athlete
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'sportif') {
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
    
    // Check if email already exists for another user
    $checkEmail = $connect->prepare("SELECT id_sportif FROM Sportif WHERE sportif_email = ? AND id_sportif != ?");
    $checkEmail->bind_param("si", $email, $user_id);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    // If email exists for another user, show error
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Cet email est déjà utilisé par un autre compte";
        header("Location: dashboard-athlete.php");
        exit();
    }
    
    // -------------------------------
    // PHOTO UPLOAD (SIMPLE)
    // -------------------------------
    // If user selected an image, save it in /uploads and update sportif_photo
    $newPhotoPath = '';

    if (isset($_FILES['photo']) && isset($_FILES['photo']['name']) && $_FILES['photo']['name'] !== '') {
        if ($_FILES['photo']['error'] === 0) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $originalName = basename($_FILES['photo']['name']);
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            // Allow only common image extensions
            $allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
            if (in_array($ext, $allowed)) {
                $newName = 'sportif_' . $user_id . '_' . time() . '.' . $ext;
                $target = $uploadDir . $newName;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                    $newPhotoPath = $target; // ex: uploads/sportif_1_1700000000.jpg
                }
            }
        }
    }

    // Update the athlete's information
    if ($newPhotoPath !== '') {
        $updateQuery = $connect->prepare("UPDATE Sportif SET sportif_prenom = ?, sportif_nom = ?, sportif_email = ?, sportif_phone = ?, sportif_photo = ? WHERE id_sportif = ?");
        $updateQuery->bind_param("sssssi", $prenom, $nom, $email, $phone, $newPhotoPath, $user_id);
    } else {
        $updateQuery = $connect->prepare("UPDATE Sportif SET sportif_prenom = ?, sportif_nom = ?, sportif_email = ?, sportif_phone = ? WHERE id_sportif = ?");
        $updateQuery->bind_param("ssssi", $prenom, $nom, $email, $phone, $user_id);
    }
    
    // Execute the update
    if ($updateQuery->execute()) {
        // Update session name
        $_SESSION['user_name'] = $prenom . ' ' . $nom;
        
        // Success message
        $_SESSION['success'] = "Votre profil a été mis à jour avec succès!";
        header("Location: dashboard-athlete.php");
        exit();
    } else {
        // Error message
        $_SESSION['error'] = "Erreur lors de la mise à jour: " . $connect->error;
        header("Location: dashboard-athlete.php");
        exit();
    }
    
} else {
    // If not POST request, redirect to dashboard
    header("Location: dashboard-athlete.php");
    exit();
}
?>