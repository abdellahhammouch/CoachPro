<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    require "connect.php";

    $error = "";
    $success = "";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $userType = $_POST['userType'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $password_hashed = password_hash($password,PASSWORD_BCRYPT);
        
        $photo = "https://ui-avatars.com/api/?name=" . urlencode($prenom . "+" . $nom) . "&background=FEBA17&color=fff";
        
        // ========== REGISTER SPORTIF ==========
        if ($userType === "sportif") {
            
            $checkEmail=$connect->prepare("select id_sportif from Sportif where sportif_email = ?");
            $checkEmail->bind_param("s",$email);
            $checkEmail->execute();
            $resultCheckEmail=$checkEmail->get_result();
            
            if ($resultCheckEmail->num_rows > 0) {
                $error = "Cet email existe déjà";
            } else {
                $sql=$connect->prepare("insert into Sportif (sportif_nom, sportif_prenom, sportif_email, sportif_phone, sportif_password, sportif_photo) VALUES (?, ?, ?, ?, ?, ?)");
                $sql->bind_param("ssssss",$nom,$prenom,$email,$phone,$password_hashed,$photo);
                $sql->execute();
                
                if (true) {
                    $success = "Compte créé avec succès!";
                    header("Location: login.php");
                    exit;
                } else {
                    $error = "Erreur: " . $sql->error;
                }
            }
        }
        
        elseif ($userType === "coach") {
            
            $biographie = $_POST['biographie'];
            $disciplines = $_POST['disciplines'];
            $experiences = $_POST['experience'];
            $prix = $_POST['prix'];
            
            $checkEmail=$connect->prepare("select id_coach from Coach where coach_email = ?");
            $checkEmail->bind_param("s",$email);
            $checkEmail->execute();
            $resultCheckEmail = $checkEmail->get_result();

            if ($resultCheckEmail->num_rows > 0) {
                $error = "Cet email existe déjà";
            } else {

                $sql = $connect->prepare("insert into Coach (coach_nom, coach_prenom, coach_email, coach_phone, coach_password, coach_photo, coach_biographie, coach_annees_experiences,coach_prix) values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $sql->bind_param("sssssssii",$nom,$prenom,$email,$phone,$photo,$password_hashed,$biographie,$experiences, $prix);

                if ($sql->execute()) {
                    
                    $id_coach=$connect->insert_id;
                    
                    $disciplineArray = explode(",", $disciplines);
                    
                    foreach ($disciplineArray as $disciplineName) {
                        $disciplineName = trim($disciplineName);
                        
                        $checkDiscipline=$connect->prepare("select id_discipline from Discipline where discipline_nom = ?");
                        $checkDiscipline->bind_param("s",$disciplineName);
                        $checkDiscipline->execute();
                        $resultDiscipline = $checkDiscipline->get_result();
                        
                        if ($resultDiscipline->num_rows > 0) {

                            
                            $row = $resultDiscipline->fetch_assoc();
                            $id_discipline = $row['id_discipline'];
                            
                        } else {
                            
                            $insertDiscipline = $connect->prepare("insert into Discipline (discipline_nom) values (?)");

                            $insertDiscipline->bind_param("s", $disciplineName);
                            $insertDiscipline->execute();

                            $id_discipline = $insertDiscipline->insert_id;
                        }
                        
                        
                        $checkDiscipline=$connect->prepare("insert into Coach_discipline (id_coach, id_discipline) values (?, ?)");
                        $checkDiscipline->bind_param("ii",$id_coach,$id_discipline);
                        $checkDiscipline->execute();
                    }
                    header("Location: login.php");
                    exit;
                } else {
                    $error = "Erreur: " . mysqli_error($connect);
                }
            }
        }
    }

    $_SESSION['error'] = $error;
    $_SESSION['success'] = $success;
?>