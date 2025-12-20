<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require "auth_check.php";
    require "connect.php";

    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'sportif') {
        header("Location: login.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace - SportCoach</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="issets/style.css">
</head>
<body>
    <?php 
        $my_sessions = $connect->prepare("select count(*) as total from Reservation where id_coach = ? and id_sportif = ?");
        $my_sessions->bind_param("ii", $coach['id_coach'], $current_user['user_id']);
        $my_sessions->execute();
        $result = $my_sessions->get_result();
        $row = $result->fetch_assoc();
        $total_sessions = $row['total'];

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
                <li><a href="logout.php" class="btn-secondary"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Layout -->
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link active" onclick="showSection('overview')">
                        <i class="fas fa-chart-line"></i>
                        <span>Vue d'ensemble</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="showSection('mybookings')">
                        <i class="fas fa-calendar-check"></i>
                        <span>Mes Réservations</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="showSection('findcoach')">
                        <i class="fas fa-search"></i>
                        <span>Trouver un Coach</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="showSection('mycoaches')">
                        <i class="fas fa-user-tie"></i>
                        <span>Mes Coachs</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="showSection('profile')">
                        <i class="fas fa-user-edit"></i>
                        <span>Mon Profil</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Overview Section -->
            <div id="overviewSection" class="dashboard-section">
                <div class="dashboard-header">
                    <h1>Tableau de bord</h1>
                    <p style="color: var(--text-gray);">Bienvenue dans votre espace personnel</p>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-details">
                            <?php 
                                $resrvation_enattente=$connect->prepare("select count(id_reservation) as total from Reservation where statut = 'enattente' and id_sportif = ?");
                                $resrvation_enattente->bind_param("i", $current_user['user_id']);
                                $resrvation_enattente->execute();
                                $result = $resrvation_enattente->get_result();
                                $row = $result->fetch_assoc();
                                $resrvation_enattente = $row['total'];
                            ?>
                            <h3><?=$resrvation_enattente?></h3>
                            <p>Réservations en attente</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon confirmed">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-details">
                            <?php 
                                $resrvation_approuved=$connect->prepare("select count(id_reservation) as total from Reservation where statut = 'acceptee'");
                                $resrvation_approuved->execute();
                                $result = $resrvation_approuved->get_result();
                                $row = $result->fetch_assoc();
                                $resrvation_approuved = $row['total'];
                            ?>
                            <h3><?=$resrvation_approuved?></h3>
                            <p>Prochaine séance</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon today">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-details">
                            <?php 
                                $resrvation_done=$connect->prepare("select count(id_reservation) as total from Reservation where statut = 'terminee'");
                                $resrvation_done->execute();
                                $result = $resrvation_done->get_result();
                                $row = $result->fetch_assoc();
                                $resrvation_done = $row['total'];
                            ?>
                            <h3><?=$resrvation_done?></h3>
                            <p>Séances complétées</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon tomorrow">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="stat-details">
                            <?php 
                                $coaches_totaux=$connect->prepare("select count(id_coach) as total from Coach");
                                $coaches_totaux->execute();
                                $result = $coaches_totaux->get_result();
                                $row = $result->fetch_assoc();
                                $coaches_totaux = $row['total'];
                            ?>
                            <h3><?=$coaches_totaux?></h3>
                            <p>Coachs totaux</p>
                        </div>
                    </div>
                </div>

                <!-- Next Session Card -->
                <div class="table-container" style="margin-bottom: 30px;">
                    <div class="table-header">
                        <h2><i class="fas fa-clock"></i> Prochaine séance</h2>
                    </div>
                    <div style="padding: 20px; display: flex; gap: 20px; align-items: center; background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%); border-radius: 10px;">
                        <img src="https://ui-avatars.com/api/?name=Ahmed+Benali&background=FEBA17&color=fff" alt="Coach" style="width: 80px; height: 80px; border-radius: 50%;">
                        <div style="flex: 1;">
                            <h3 style="color: var(--primary-dark); margin-bottom: 5px;">Ahmed Benali</h3>
                            <p style="color: var(--text-gray); margin-bottom: 10px;"><i class="fas fa-futbol"></i> Football - Technique de dribble</p>
                            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                                <span style="color: var(--primary-brown);"><i class="fas fa-calendar"></i> 19 Déc 2024</span>
                                <span style="color: var(--primary-brown);"><i class="fas fa-clock"></i> 16:00 - 17:00</span>
                                <span style="color: var(--primary-brown);"><i class="fas fa-map-marker-alt"></i> Stade Municipal</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px; flex-direction: column;">
                            <button class="btn-primary" style="padding: 10px 20px; white-space: nowrap;">
                                <i class="fas fa-info-circle"></i> Détails
                            </button>
                            <button class="btn-reject" style="padding: 8px 20px; white-space: nowrap;">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="table-container">
                    <div class="table-header">
                        <h2>Réservations récentes</h2>
                        <button class="btn-secondary" onclick="showSection('mybookings')">Voir tout</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Coach</th>
                                <th>Discipline</th>
                                <th>Date & Heure</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Ahmed Benali</strong></td>
                                <td>Football</td>
                                <td>20 Déc 2024, 10:00</td>
                                <td><span class="status-badge pending">En attente</span></td>
                                <td class="action-buttons">
                                    <button class="btn-view" onclick="viewBookingDetails(1)">Détails</button>
                                    <button class="btn-reject" onclick="cancelBooking(1)">Annuler</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Fatima Zahra</strong></td>
                                <td>Tennis</td>
                                <td>21 Déc 2024, 14:00</td>
                                <td><span class="status-badge pending">En attente</span></td>
                                <td class="action-buttons">
                                    <button class="btn-view" onclick="viewBookingDetails(2)">Détails</button>
                                    <button class="btn-reject" onclick="cancelBooking(2)">Annuler</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ahmed Benali</strong></td>
                                <td>Football</td>
                                <td>19 Déc 2024, 16:00</td>
                                <td><span class="status-badge confirmed">Confirmée</span></td>
                                <td><button class="btn-view" onclick="viewBookingDetails(3)">Détails</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- My Bookings Section -->
            <div id="mybookingsSection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Mes Réservations</h1>
                    <p style="color: var(--text-gray);">Gérez toutes vos séances sportives</p>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2>Toutes mes réservations</h2>
                        <div style="display: flex; gap: 10px;">
                            <select class="form-control" style="width: auto; padding: 8px 15px;">
                                <option>Tous les statuts</option>
                                <option>En attente</option>
                                <option>Confirmées</option>
                                <option>Terminées</option>
                                <option>Annulées</option>
                            </select>
                            <button class="btn-primary" onclick="showSection('findcoach')">
                                <i class="fas fa-plus"></i> Nouvelle réservation
                            </button>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Coach</th>
                                <th>Discipline</th>
                                <th>Date & Heure</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="allBookingsTable">
                            <!-- Populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- FIND COACH SECTION (NEW - Integrated from coaches.php) -->
            <div id="findcoachSection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Découvrez nos <span style="color: var(--primary-gold);">coachs professionnels</span></h1>
                    <p style="color: var(--text-gray);">Trouvez le coach idéal pour atteindre vos objectifs sportifs</p>
                </div>

                <!-- Filter Section -->
                <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px var(--shadow); margin-bottom: 40px;">
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

                <!-- Coaches Grid -->
                <div class="coaches-grid" id="coachesGrid">
                    <?php 
                        $coaches=$connect->prepare("select * from Coach");
                        $coaches->execute();
                        $result = $coaches->get_result();
                        $coaches = $result->fetch_all(MYSQLI_ASSOC);
                        foreach ($coaches as $coach): 
                    ?>
                    <div class="coach-card" data-sport="football">
                        <img src="<?=$coach['coach_photo']?>" alt="<?= $coach['coach_nom'] .' '.$coach['coach_prenom'] ?>" class="coach-image">
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
                                    <span><?=$coach['coach_annees_experiences']?> ans</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-users"></i>
                                    <?php  
                                        $sportifs_associes = $connect->prepare("
                                            select count(distinct s.id_sportif) as totalSportifs from Sportif s
                                            inner join Reservation r on r.id_sportif = s.id_sportif
                                            where r.id_coach = ?");
                                        $sportifs_associes->bind_param("i", $coach['id_coach']);
                                        $sportifs_associes->execute();
                                        $result = $sportifs_associes->get_result();
                                        $row = $result->fetch_assoc();
                                        $totalSportifs = $row['totalSportifs'];
                                    ?>
                                    <span><?= $totalSportifs ?> élèves</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-tag"></i>
                                    <span><?= $coach['coach_prix'] ?? 100 ?> DH/h</span>
                                </div>
                            </div>
                            <div class="coach-actions">
                                <button class="btn-view" onclick="viewCoachProfileModal(<?= $coach['id_coach'] ?>)">
                                    <i class="fas fa-eye"></i> Voir profil
                                </button>
                                <button class="btn-book" onclick="bookSessionModal(<?= $coach['id_coach'] ?>)">
                                    <i class="fas fa-calendar-plus"></i> Réserver
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden Modal Content for Each Coach -->
                    <div id="coachModalContent<?= $coach['id_coach'] ?>" style="display: none;">
                        <div style="text-align: center; margin-bottom: 25px;">
                            <img src="<?=$coach['coach_photo']?>" alt="<?= $coach['coach_nom'] .' '.$coach['coach_prenom'] ?>" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 15px; object-fit: cover;">
                            <h2 style="color: var(--primary-dark); margin-bottom: 5px;"><?= $coach['coach_nom'] .' '.$coach['coach_prenom'] ?></h2>
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
                                <span style="color: var(--primary-gold); font-weight: 600; font-size: 18px;"><?= $coach_discipline['discipline_nom'] ?></span>
                            <?php endforeach; ?>
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
                                <p style="color: var(--text-gray); margin-top: 5px;"><?=$coach['coach_annees_experiences']?> ans</p>
                            </div>
                            <div style="background-color: var(--primary-light); padding: 15px; border-radius: 10px;">
                                <i class="fas fa-users" style="color: var(--primary-gold); font-size: 20px; margin-bottom: 8px; display: block;"></i>
                                <strong style="color: var(--primary-dark);">Élèves</strong>
                                <p style="color: var(--text-gray); margin-top: 5px;"><?= $totalSportifs ?> sportifs</p>
                            </div>
                        </div>
                        
                        <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 25px; text-align: center;">
                            <h3 style="color: var(--primary-dark); margin-bottom: 10px;">
                                <i class="fas fa-tag"></i> Tarif
                            </h3>
                            <p style="color: var(--primary-gold); font-size: 24px; font-weight: bold;"><?= $coach['coach_prix'] ?? 100  ?> DH/heure</p>
                        </div>
                        
                        <button onclick="bookSessionModal(<?= $coach['id_coach'] ?>)" class="btn-submit" style="width: 100%;">
                            <i class="fas fa-calendar-plus"></i> Réserver une séance
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- No Results Message -->
                <div id="noResultsMessage" style="display: none; text-align: center; padding: 60px 20px;">
                    <i class="fas fa-search" style="font-size: 64px; color: var(--primary-gold); margin-bottom: 20px; display: block;"></i>
                    <h3 style="color: var(--primary-dark); margin-bottom: 10px;">Aucun coach trouvé</h3>
                    <p style="color: var(--text-gray);">Essayez de modifier vos critères de recherche</p>
                </div>
            </div>

            <!-- My Coaches Section -->
            <div id="mycoachesSection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Mes Coachs</h1>
                    <p style="color: var(--text-gray);">Les coachs avec qui vous travaillez</p>
                </div>

                <div class="coaches-grid" style="max-width: 1200px;">
                    <?php 
                        $mycoaches=$connect->prepare("select distinct c.* from Coach c 
                                                    inner join Reservation r on r.id_coach = c.id_coach
                                                    where r.id_sportif = ?");
                        $mycoaches->bind_param("i",$current_user['user_id']);
                        $mycoaches->execute();
                        $result = $mycoaches->get_result();
                        $mycoaches = $result->fetch_all(MYSQLI_ASSOC);
                        if (count($mycoaches) > 0) :
                        foreach ($mycoaches as $coach):
                    ?>
                    <div class="coach-card">
                        <img src="<?=$coach['coach_photo']?>" alt="<?= $coach['coach_nom'] .' '.$coach['coach_prenom'] ?>" class="coach-image">
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
                                    <i class="fas fa-check-circle"></i>
                                    <span>8 séances</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Depuis 2 mois</span>
                                </div>
                            </div>
                            <div class="coach-actions">
                                <button class="btn-view" onclick="viewCoachProfile(1)">
                                    <i class="fas fa-eye"></i> Voir profil
                                </button>
                                <button class="btn-book" onclick="bookSession(1)">
                                    <i class="fas fa-calendar-plus"></i> Réserver
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="coach-card">
                        <img src="https://images.unsplash.com/photo-1622163642998-1ea32b0bbc67?w=400&h=300&fit=crop" alt="Coach" class="coach-image">
                        <div class="coach-info">
                            <div class="coach-header">
                                <div>
                                    <h3 class="coach-name">Fatima Zahra</h3>
                                    <p class="coach-specialty">Tennis</p>
                                </div>
                                <div class="coach-rating">
                                    <i class="fas fa-star"></i> 5.0
                                </div>
                            </div>
                            <div class="coach-stats">
                                <div class="stat-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>4 séances</span>
                                </div>
                                <divdisplay: none; class="stat-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Depuis 1 mois</span>
                                </divdisplay:>
                            </div>
                            <div class="coach-actions">
                                <button class="btn-view" onclick="viewCoachProfile(2)">
                                    <i class="fas fa-eye"></i> Voir profil
                                </button>
                                <button class="btn-book" onclick="bookSession(2)">
                                    <i class="fas fa-calendar-plus"></i> Réserver
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; 
                else :?>
                <div style="text-align: center; padding: 60px 20px;">
                    <i class="fas fa-users" style="font-size: 64px;"></i>
                    <h3>Vous n'avez pas encore de coach</h3>
                    <p>Trouvez un coach professionnel pour commencer</p>
                    <button class="btn-primary" onclick="showSection('findcoach')">
                        <i class="fas fa-search"></i> Trouver un coach
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Profile Section -->
        <div id="profileSection" class="dashboard-section" style="display: none;">
            <div class="dashboard-header">
                <h1>Mon Profil</h1>
                <p style="color: var(--text-gray);">Modifiez vos informations personnelles</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div style="background: #d1fae5; border: 2px solid #10b981; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: 600;">
                    <i class="fas fa-check-circle"></i> <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div style="background: #fee2e2; border: 2px solid #dc2626; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: 600;">
                    <i class="fas fa-exclamation-triangle"></i> <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="table-container">
                <form id="athleteProfileForm" action="update_athlete_profile.php" method="POST" style="max-width: 700px; margin: 0 auto;">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <img src="<?=$sportif_photo?>" alt="<?= $sportif_nom .' '.$sportif_prenom ?>" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 15px;">
                        <button type="button" class="btn-secondary">
                            <i class="fas fa-camera"></i> Changer la photo
                        </button>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label>Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="<?=$sportif_prenom?>" style="padding-left: 15px;" required>
                        </div>
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" value="<?=$sportif_nom?>" style="padding-left: 15px;" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?=$sportif_email?>" style="padding-left: 15px;" required>
                    </div>

                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="tel" name="phone" class="form-control" value="<?=$sportif_phone?>" style="padding-left: 15px;" required>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>

        <!-- Coach Profile Modal -->
        <div class="modal" id="coachModal" style="display: none;">
            <div class="modal-content" style="max-width: 700px; scrollbar-width:none">
                <div class="modal-header">
                    <h3>Profil du Coach</h3>
                    <button class="close-modal" onclick="closeModal('coachModal')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="modalContent">
                    <!-- Content will be copied here by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-bottom" style="padding: 20px;">
                <p>&copy; 2024 SportCoach. Tous droits réservés.</p>
            </div>
        </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="issets/main.js"></script>
    <script src="issets/athlete_dashboard.js"></script>
    <script src="issets/coaches.js" ></script>
</body>
</html>