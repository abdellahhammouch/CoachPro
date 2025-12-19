<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require "auth_check.php";
    require "connect.php";
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Coachs - SportCoach</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        $profil_Sportif=$connect->prepare("select * from Sportif where id_sportif = ?");
        $profil_Sportif->bind_param("i",$current_user['user_id']);
        $profil_Sportif->execute();
        $result = $profil_Sportif->get_result();
        $row = $result->fetch_assoc();
        $sportif_photo = $row['sportif_photo'];
        $sportif_nom = $row['sportif_nom'];
        $sportif_prenom = $row['sportif_prenom'];
        $sportif_email = $row['sportif_email'];
        $sportif_phone = $row['sportif_phone'];
    ?>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="dashboard-athlete.php" class="logo">
                <i class="fas fa-dumbbell"></i>
                <span>SportCoach</span>
            </a>
            <ul class="nav-menu">
                <li><a href="coaches.php" class="nav-link"><i class="fas fa-users"></i> Trouver un coach</a></li>
                <li style="display: flex; align-items: center; gap: 10px;">
                    <img src="<?=$sportif_photo?>" alt="<?= $sportif_nom .' '.$sportif_prenom ?>" style="width: 35px; height: 35px; border-radius: 50%;">
                    <span style="color: var(--primary-dark); font-weight: 600;"><?= $sportif_nom .' '.$sportif_prenom ?></span>
                </li>
                <li><a href="index.php" class="btn-secondary"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="hero" style="padding: 60px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <h1 style="font-size: 42px; color: var(--primary-dark); margin-bottom: 15px;">
                Découvrez nos <span style="color: var(--primary-gold);">coachs professionnels</span>
            </h1>
            <p style="font-size: 18px; color: var(--text-gray); margin-bottom: 40px;">
                Trouvez le coach idéal pour atteindre vos objectifs sportifs
            </p>

            <!-- Filter Section -->
            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px var(--shadow); max-width: 900px; margin: 0 auto;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <div class="input-group">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un coach...">
                    </div>
                    <div class="input-group">
                        <i class="fas fa-filter"></i>
                        <select id="sportFilter" class="form-control">
                            <option value="">Tous les sports</option>
                            <option value="football">Football</option>
                            <option value="tennis">Tennis</option>
                            <option value="natation">Natation</option>
                            <option value="boxe">Boxe</option>
                            <option value="fitness">Préparation physique</option>
                        </select>
                    </div>
                    <button class="btn-primary" onclick="filterCoaches()">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Coaches Grid -->
    <section class="coaches-section">
        <div class="coaches-grid" id="coachesGrid">
            <?php 
                $coaches=$connect->prepare("select * from Coach");
                $coaches->execute();
                $result = $coaches->get_result();
                $coaches = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($coaches as $coach): ?>

            <div class="coach-card" data-sport="football">
                <img src="<?=$coach['coach_photo']?>" alt="Coach <?= $coach['coach_nom'] .' '.$coach['coach_prenom'] ?>" class="coach-image">
                <div class="coach-info">
                    <div class="coach-header">
                        <div>
                            <h3 class="coach-name"><?= $coach['coach_nom'] .' '.$coach['coach_prenom'] ?></h3>
                            <?php 
                                $coach_disciplines=$connect->prepare("select discipline_nom from Discipline d
                                                                    left join Coach_discipline cd on cd.id_discipline = d.id_discipline
                                                                    where cd.id_coach = ?;");
                                $coach_disciplines->bind_param("i",$coach['id_coach']);
                                $coach_disciplines->execute();
                                $result = $coach_disciplines->get_result();
                                $coach_disciplines = $result->fetch_all(MYSQLI_ASSOC);
                                foreach ($coach_disciplines as $coach_discipline): 
                            ?>
                            <span class="coach-specialty"><?= $coach_discipline['discipline_nom'] ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="coach-stats">
                        <div class="stat-item">
                            <i class="fas fa-medal"></i>
                            <span><?=$coach['coach_annees_experiences']?></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-users"></i>
                            <?php  
                                $sportifs_associes = $connect->prepare("
                                    select count(s.id_sportif) as totalSportifs from Sportif s
                                    inner join Reservation r on r.id_sportif = s.id_sportif
                                    where r.id_coach = ?");
                                $sportifs_associes->bind_param("i", $coach['id_coach']);
                                $sportifs_associes->execute();

                                $result = $sportifs_associes->get_result();
                                $row = $result->fetch_assoc();
                                $totalSportifs = $row['totalSportifs'];
                            ?>
                            <span><?= $totalSportifs ?></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-certificate"></i>
                            <span><?= $coach['coach_biographie'] ?></span>
                        </div>
                    </div>
                    <div class="coach-actions">
                        <button class="btn-view" onclick="viewCoachProfile(<?= $coach['id_coach'] ?>)">
                            <i class="fas fa-eye"></i> Voir profil
                        </button>
                        <button class="btn-book" onclick="bookSession(<?= $coach['id_coach'] ?>)">
                            <i class="fas fa-calendar-plus"></i> Réserver
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Contenu Modal (CACHÉ) -->
            <div id="coachModalContent<?= $coach['id_coach'] ?>" style="display: none;">
                <div style="text-align: center; margin-bottom: 25px;">
                    <img src="<?=$coach['coach_photo']?>" alt="<?= $coach['coach_nom'] .' '.$coach['coach_prenom'] ?>" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 15px; object-fit: cover;">
                    <h2 style="color: var(--primary-dark); margin-bottom: 5px;"><?= $coach['coach_nom'] .' '.$coach['coach_prenom'] ?></h2>
                    <?php
                        foreach ($coach_disciplines as $coach_discipline): 
                    ?>
                        <span style="color: var(--primary-gold); font-weight: 600; font-size: 18px;"><?= $coach_discipline['discipline_nom'] ?></span>
                    <?php endforeach; ?>
                    <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 10px;">
                        <span style="color: var(--text-gray);">•</span>
                        <span style="color: var(--text-gray);"><?= $totalSportifs ?></span>
                    </div>
                </div>
                
                <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <h3 style="color: var(--primary-dark); margin-bottom: 15px;">
                        <i class="fas fa-user"></i> À propos
                    </h3>
                    <p style="color: var(--text-gray); line-height: 1.8;">
                        <?= $coach['coach_biographie'] ?>
                    </p>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div style="background-color: var(--primary-light); padding: 15px; border-radius: 10px;">
                        <i class="fas fa-medal" style="color: var(--primary-gold); font-size: 20px; margin-bottom: 8px; display: block;"></i>
                        <strong style="color: var(--primary-dark);">Expérience</strong>
                        <p style="color: var(--text-gray); margin-top: 5px;"><?=$coach['coach_annees_experiences']?>ans</p>
                    </div>
                    <div style="background-color: var(--primary-light); padding: 15px; border-radius: 10px;">
                        <i class="fas fa-certificate" style="color: var(--primary-gold); font-size: 20px; margin-bottom: 8px; display: block;"></i>
                        <strong style="color: var(--primary-dark);">Certification</strong>
                        <p style="color: var(--text-gray); margin-top: 5px;"><?=$coach['biographie']?></p>
                    </div>
                </div>
                
                <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <h3 style="color: var(--primary-dark); margin-bottom: 15px;">
                        <i class="fas fa-clock"></i> Disponibilités
                    </h3>
                    <p style="color: var(--text-gray); margin-bottom: 8px;">
                        <i class="fas fa-check-circle" style="color: var(--success);"></i> Mardi - Samedi: 8h - 16h
                    </p>
                </div>
                
                <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 25px; text-align: center;">
                    <h3 style="color: var(--primary-dark); margin-bottom: 10px;">
                        <i class="fas fa-tag"></i> Tarif
                    </h3>
                    <p style="color: var(--primary-gold); font-size: 24px; font-weight: bold;">250 DH/heure</p>
                </div>
                
                <button onclick="bookSession(2)" class="btn-submit" style="width: 100%;">
                    <i class="fas fa-calendar-plus"></i> Réserver une séance
                </button>
            </div>
            <?php endforeach; ?>

        </div>

        <!-- Message "Aucun résultat" (CACHÉ par défaut) -->
        <div id="noResultsMessage" style="display: none; text-align: center; padding: 60px 20px;">
            <i class="fas fa-search" style="font-size: 64px; color: var(--primary-gold); margin-bottom: 20px; display: block;"></i>
            <h3 style="color: var(--primary-dark); margin-bottom: 10px;">Aucun coach trouvé</h3>
            <p style="color: var(--text-gray);">Essayez de modifier vos critères de recherche</p>
        </div>
    </section>

    <!-- Modal Profil Coach (UNIQUE) -->
    <div class="modal" id="coachModal" style="display: none;">
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header">
                <h3>Profil du Coach</h3>
                <button class="close-modal" onclick="closeModal('coachModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalContent">
                <!-- Le contenu sera copié ici par JavaScript -->
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3><i class="fas fa-dumbbell"></i> SportCoach</h3>
                <p>Votre plateforme de mise en relation avec les meilleurs coachs sportifs professionnels.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="coaches.php">Nos Coachs</a></li>
                    <li><a href="login.php">Connexion</a></li>
                    <li><a href="register.php">Inscription</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <ul class="footer-links">
                    <li><a href="#">Centre d'aide</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-envelope"></i> contact@sportcoach.com</li>
                    <li><i class="fas fa-phone"></i> +212 5XX-XXXXXX</li>
                    <li><i class="fas fa-map-marker-alt"></i> Casablanca, Maroc</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 SportCoach. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="main.js"></script>
    <script src="coaches.js"></script>
</body>
</html>