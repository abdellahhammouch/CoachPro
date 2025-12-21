<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

session_start();
require "connect.php";

// Check if coach is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'coach') {
    header("Location: login.php");
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $coach_id = $_SESSION['user_id'];
    $disponibilite_id = $_POST['disponibilite_id'];
    
    // Delete the availability (only if it belongs to this coach)
    $delete_query = $connect->prepare("DELETE FROM Disponibilite WHERE id_disponibilite = ? AND id_coach = ?");
    $delete_query->bind_param("ii", $disponibilite_id, $coach_id);
    
    if ($delete_query->execute()) {
        $_SESSION['success'] = "Disponibilité supprimée avec succès!";
    } else {
        $_SESSION['error'] = "Erreur: " . $connect->error;
    }
    
    header("Location: dashboard-coach.php");
    exit();
    
} else {
    header("Location: dashboard-coach.php");
    exit();
}
?>