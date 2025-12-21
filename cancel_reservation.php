<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

session_start();
require "connect.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'sportif') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $sportif_id = $_SESSION['user_id'];
    $reservation_id = $_POST['reservation_id'];
    
    $update_query = $connect->prepare("UPDATE Reservation SET statut = 'annulee' WHERE id_reservation = ? AND id_sportif = ?");
    $update_query->bind_param("ii", $reservation_id, $sportif_id);
    
    if ($update_query->execute()) {
        $_SESSION['success'] = "Réservation annulée avec succès";
    } else {
        $_SESSION['error'] = "Erreur: " . $connect->error;
    }
    
    header("Location: dashboard-athlete.php");
    exit();
    
} else {
    header("Location: dashboard-athlete.php");
    exit();
}
?>