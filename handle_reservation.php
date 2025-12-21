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
    $reservation_id = $_POST['reservation_id'];
    $action = $_POST['action']; // 'accept' or 'reject'
    
    // Determine new status
    if ($action == 'accept') {
        $new_status = 'acceptee';
    } else {
        $new_status = 'refusee';
    }
    
    // Update the reservation status (only if it belongs to this coach)
    $update_query = $connect->prepare("UPDATE Reservation SET statut = ? WHERE id_reservation = ? AND id_coach = ?");
    $update_query->bind_param("sii", $new_status, $reservation_id, $coach_id);
    
    if ($update_query->execute()) {
        if ($action == 'accept') {
            $_SESSION['success'] = "Réservation acceptée avec succès!";
        } else {
            $_SESSION['success'] = "Réservation refusée";
        }
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