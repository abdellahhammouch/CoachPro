<?php
// create_reservation.php (FINAL - beginner friendly)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

session_start();
require "connect.php";

// Check if athlete is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'sportif') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sportif_id = intval($_SESSION['user_id']);
    $coach_id = intval($_POST['coach_id']);
    $date_seance = $_POST['date_seance'];
    $heure_debut = $_POST['heure_debut']; // ex: "14:00"
    $duree = $_POST['duree']; // ex: "0.5", "1", "1.5", "2"
    $discipline_id = !empty($_POST['discipline_id']) ? intval($_POST['discipline_id']) : null;

    // ---- Validation date (not past)
    $today = date('Y-m-d');
    if ($date_seance < $today) {
        $_SESSION['error'] = "La date ne peut pas être dans le passé";
        header("Location: dashboard-athlete.php");
        exit();
    }

    // ---- Make heure_debut format with seconds for DB compare (HH:MM:SS)
    $heure_debut_db = $heure_debut;
    if (strlen($heure_debut_db) === 5) {
        $heure_debut_db = $heure_debut_db . ":00";
    }

    // ---- Calculate end time (simple way, no floor)
    // Split start time "HH:MM"
    $heure_parts = explode(':', $heure_debut);
    $start_hours = intval($heure_parts[0]);
    $start_minutes = intval($heure_parts[1]);

    // Split duration "1.5" -> hours=1, minutes=30
    $duree_parts = explode('.', $duree);
    $duree_hours = intval($duree_parts[0]);

    $duree_minutes = 0;
    if (isset($duree_parts[1]) && intval($duree_parts[1]) > 0) {
        // because your options are only .5 (30 minutes)
        $duree_minutes = 30;
    }

    $end_hours = $start_hours + $duree_hours;
    $end_minutes = $start_minutes + $duree_minutes;

    if ($end_minutes >= 60) {
        $end_hours = $end_hours + 1;
        $end_minutes = $end_minutes - 60;
    }

    // End time cannot exceed midnight
    if ($end_hours >= 24) {
        $_SESSION['error'] = "L'heure de fin dépasse minuit. Choisissez une durée plus courte.";
        header("Location: dashboard-athlete.php");
        exit();
    }

    $heure_fin = sprintf("%02d:%02d:00", $end_hours, $end_minutes);

    // ---- CHECK ONLY coach availability (Disponibilite)
    $check_availability = $connect->prepare("
        SELECT * FROM Disponibilite
        WHERE id_coach = ?
        AND date_disponibilite = ?
        AND heure_debut <= ?
        AND heure_fin >= ?
    ");
    $check_availability->bind_param("isss", $coach_id, $date_seance, $heure_debut_db, $heure_fin);
    $check_availability->execute();
    $result = $check_availability->get_result();

    // Use foreach (no while)
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $is_available = false;
    foreach ($rows as $row) {
        $is_available = true;
        break;
    }

    if (!$is_available) {
        $_SESSION['error'] = "Le coach n'est pas disponible à cette date et à ce créneau horaire";
        header("Location: dashboard-athlete.php");
        exit();
    }

    // ---- Create reservation (NO conflict check with other reservations)
    if ($discipline_id) {
        $insert_query = $connect->prepare("
            INSERT INTO Reservation (id_sportif, id_coach, id_discipline, date_seance, heure_debut, heure_fin, statut)
            VALUES (?, ?, ?, ?, ?, ?, 'enattente')
        ");
        $insert_query->bind_param("iiisss", $sportif_id, $coach_id, $discipline_id, $date_seance, $heure_debut_db, $heure_fin);
    } else {
        $insert_query = $connect->prepare("
            INSERT INTO Reservation (id_sportif, id_coach, date_seance, heure_debut, heure_fin, statut)
            VALUES (?, ?, ?, ?, ?, 'enattente')
        ");
        $insert_query->bind_param("iisss", $sportif_id, $coach_id, $date_seance, $heure_debut_db, $heure_fin);
    }

    if ($insert_query->execute()) {
        $_SESSION['success'] = "Réservation envoyée avec succès! En attente de confirmation du coach.";
    } else {
        $_SESSION['error'] = "Erreur: " . $connect->error;
    }

    header("Location: dashboard-athlete.php");
    exit();
}

header("Location: dashboard-athlete.php");
exit();
?>
