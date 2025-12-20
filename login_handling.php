<?php
session_start();
require "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];
    
    if ($userType == "sportif") {
        
        $sql=$connect->prepare("select * from Sportif where sportif_email = ?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['sportif_password'])) {
                $_SESSION['user_id'] = $user['id_sportif'];
                $_SESSION['user_type'] = 'sportif';
                $_SESSION['user_name'] = $user['sportif_prenom'] . ' ' . $user['sportif_nom'];
                
                header("Location: dashboard-athlete.php");
                exit();
            } else {
                echo "Mot de passe incorrect";
            }
        } else {
            echo "Email non trouvé";
        }
    }
    
    elseif ($userType == "coach") {
        
        $sql=$connect->prepare("select * from Coach where coach_email = ?");
        $sql->bind_param("s",$email);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['coach_password'])) {
                $_SESSION['user_id'] = $user['id_coach'];
                $_SESSION['user_type'] = 'coach';
                $_SESSION['user_name'] = $user['coach_prenom'] . ' ' . $user['coach_nom'];
                
                header("Location: dashboard-coach.php");
                exit();
            } else {
                echo "Mot de passe incorrect";
            }
        } else {
            echo "Email non trouvé";
        }
    }
    
} else {
    echo "Accès non autorisé";
}
?>