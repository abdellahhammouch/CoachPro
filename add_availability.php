<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "auth_check.php";
require "connect.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'coach') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $coach_id = intval($_SESSION['user_id']);

    $date_disponibilite = $_POST['date_disponibilite'];
    $heure_debut = $_POST['heure_debut']; // ex "14:00"
    $heure_fin = $_POST['heure_fin'];     // ex "16:00"

    // Add seconds for DB compare (TIME)
    if (strlen($heure_debut) == 5) $heure_debut .= ":00";
    if (strlen($heure_fin) == 5) $heure_fin .= ":00";

    if ($heure_debut >= $heure_fin) {
        $_SESSION['error'] = "L'heure de fin doit être après l'heure de début";
        header("Location: dashboard-coach.php");
        exit();
    }

    $today = date('Y-m-d');
    if ($date_disponibilite < $today) {
        $_SESSION['error'] = "La date ne peut pas être dans le passé";
        header("Location: dashboard-coach.php");
        exit();
    }

    // ✅ SIMPLE overlap check (NO complex query, avoids bind_param errors)
    $check_query = $connect->prepare("
        SELECT 1
        FROM Disponibilite
        WHERE id_coach = ?
          AND date_disponibilite = ?
          AND NOT (heure_fin <= ? OR heure_debut >= ?)
        LIMIT 1
    ");
    $check_query->bind_param("isss", $coach_id, $date_disponibilite, $heure_debut, $heure_fin);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Vous avez déjà une disponibilité qui chevauche cet horaire";
        header("Location: dashboard-coach.php");
        exit();
    }

    // Insert availability
    $insert_query = $connect->prepare("
        INSERT INTO Disponibilite (id_coach, date_disponibilite, heure_debut, heure_fin)
        VALUES (?, ?, ?, ?)
    ");
    $insert_query->bind_param("isss", $coach_id, $date_disponibilite, $heure_debut, $heure_fin);

    if ($insert_query->execute()) {
        $_SESSION['success'] = "Disponibilité ajoutée avec succès!";
    } else {
        $_SESSION['error'] = "Erreur: " . $connect->error;
    }

    header("Location: dashboard-coach.php");
    exit();
}

header("Location: dashboard-coach.php");
exit();
?>
