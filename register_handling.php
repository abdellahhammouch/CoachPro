<?php
session_start();
require "connect.php";

$error = "";
$success = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['signup'])) {
    
    // Get common fields
    $userType = $_POST['userType'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $password_hassed = password_hash($password,PASSWORD_BCRYPT);
    
    $photo = "https://ui-avatars.com/api/?name=" . urlencode($prenom . "+" . $nom) . "&background=FEBA17&color=fff";
    
    // ========== REGISTER SPORTIF ==========
    if ($userType === "sportif") {
        
        $checkEmail=$connect->prepare("select id_sportif from Sportif where sportif_email = ?");
        $checkEmail->bind_param("s",$email);
        $checkEmail->execute();
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Cet email existe déjà";
        } else {
            $sql = "insert into Sportif (sportif_nom, sportif_prenom, sportif_email, sportif_phone, sportif_password, sportif_photo) 
                    VALUES ('$nom', '$prenom', '$email', '$phone', '$password', '$photo')";
            
            if (mysqli_query($connect, $sql)) {
                $success = "Compte créé avec succès!";
                header("Location: login.php");
                exit;
            } else {
                $error = "Erreur: " . mysqli_error($connect);
            }
        }
    }
    
    // ========== REGISTER COACH ==========
    elseif ($userType === "coach") {
        
        $biographie = $_POST['biographie'];
        $disciplines = $_POST['disciplines']; // This is comma-separated string: "Football,Tennis,Boxe"
        
        // Check if email already exists
        $checkEmail = "SELECT id_coach FROM Coach WHERE coach_email = '$email'";
        $result = mysqli_query($connect, $checkEmail);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Cet email existe déjà";
        } else {
            // Insert new coach
            $sql = "INSERT INTO Coach (coach_nom, coach_prenom, coach_email, coach_phone, coach_photo, coach_biographie) 
                    VALUES ('$nom', '$prenom', '$email', '$phone', '$photo', '$biographie')";
            
            if (mysqli_query($connect, $sql)) {
                // Get the ID of the coach we just created
                $id_coach = mysqli_insert_id($connect);
                
                // Split disciplines by comma
                $disciplineArray = explode(",", $disciplines);
                
                // Insert each discipline
                foreach ($disciplineArray as $disciplineName) {
                    $disciplineName = trim($disciplineName); // Remove extra spaces
                    
                    // First, check if discipline exists in Discipline table
                    $checkDiscipline = "SELECT id_discipline FROM Discipline WHERE discipline_nom = '$disciplineName'";
                    $resultDiscipline = mysqli_query($connect, $checkDiscipline);
                    
                    if (mysqli_num_rows($resultDiscipline) > 0) {
                        // Discipline exists, get its ID
                        $row = mysqli_fetch_assoc($resultDiscipline);
                        $id_discipline = $row['id_discipline'];
                    } else {
                        // Discipline doesn't exist, create it
                        $insertDiscipline = "INSERT INTO Discipline (discipline_nom) VALUES ('$disciplineName')";
                        mysqli_query($connect, $insertDiscipline);
                        $id_discipline = mysqli_insert_id($connect);
                    }
                    
                    // Link coach to discipline in Coach_discipline table
                    $linkCoachDiscipline = "INSERT INTO Coach_discipline (id_coach, id_discipline) VALUES ($id_coach, $id_discipline)";
                    mysqli_query($connect, $linkCoachDiscipline);
                }
                
                $success = "Compte coach créé avec succès!";
                header("Location: login.php");
                exit;
            } else {
                $error = "Erreur: " . mysqli_error($connect);
            }
        }
    }
}

// If there's an error, show it
if ($error) {
    echo "<script>alert('$error');</script>";
    echo "<script>window.location.href = 'register.php';</script>";
}
?>