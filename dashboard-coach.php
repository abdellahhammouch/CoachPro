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

    // Get coach information
    $profil_Coach = $connect->prepare("SELECT * FROM Coach WHERE id_coach = ?");
    $profil_Coach->bind_param("i", $current_user['user_id']);
    $profil_Coach->execute();
    $result = $profil_Coach->get_result();
    $row = $result->fetch_assoc();
    $coach_photo = $row['coach_photo'];
    $coach_nom = $row['coach_nom'];
    $coach_prenom = $row['coach_prenom'];
    $coach_email = $row['coach_email'];
    $coach_phone = $row['coach_phone'];
    $coach_biographie = $row['coach_biographie'];
    $coach_experience = $row['coach_annees_experiences'];
    $coach_prix = $row['coach_prix'];

    // Get statistics - DYNAMIC
    // Count pending reservations
    $pending_query = $connect->prepare("SELECT COUNT(*) as total FROM Reservation WHERE id_coach = ? AND statut = 'enattente'");
    $pending_query->bind_param("i", $current_user['user_id']);
    $pending_query->execute();
    $pending_result = $pending_query->get_result();
    $pending_count = $pending_result->fetch_assoc()['total'];

    // Count confirmed reservations
    $confirmed_query = $connect->prepare("SELECT COUNT(*) as total FROM Reservation WHERE id_coach = ? AND statut = 'acceptee'");
    $confirmed_query->bind_param("i", $current_user['user_id']);
    $confirmed_query->execute();
    $confirmed_result = $confirmed_query->get_result();
    $confirmed_count = $confirmed_result->fetch_assoc()['total'];

    // Count completed reservations
    $completed_query = $connect->prepare("SELECT COUNT(*) as total FROM Reservation WHERE id_coach = ? AND statut = 'terminee'");
    $completed_query->bind_param("i", $current_user['user_id']);
    $completed_query->execute();
    $completed_result = $completed_query->get_result();
    $completed_count = $completed_result->fetch_assoc()['total'];

    // Count total unique athletes
    $athletes_query = $connect->prepare("SELECT COUNT(DISTINCT id_sportif) as total FROM Reservation WHERE id_coach = ?");
    $athletes_query->bind_param("i", $current_user['user_id']);
    $athletes_query->execute();
    $athletes_result = $athletes_query->get_result();
    $athletes_count = $athletes_result->fetch_assoc()['total'];

    // Get recent reservations (last 3)
    $recent_reservations = $connect->prepare("
        SELECT r.*, s.sportif_nom, s.sportif_prenom, d.discipline_nom 
        FROM Reservation r
        JOIN Sportif s ON r.id_sportif = s.id_sportif
        LEFT JOIN Discipline d ON r.id_discipline = d.id_discipline
        WHERE r.id_coach = ?
        ORDER BY r.date_seance DESC, r.heure_debut DESC
        LIMIT 3
    ");
    $recent_reservations->bind_param("i", $current_user['user_id']);
    $recent_reservations->execute();
    $result = $recent_reservations->get_result();
    $recent_reservations_list = $result->fetch_all(MYSQLI_ASSOC);

    // Get ALL reservations
    $all_reservations = $connect->prepare("
        SELECT r.*, s.sportif_nom, s.sportif_prenom, d.discipline_nom 
        FROM Reservation r
        JOIN Sportif s ON r.id_sportif = s.id_sportif
        LEFT JOIN Discipline d ON r.id_discipline = d.id_discipline
        WHERE r.id_coach = ?
        ORDER BY r.date_seance DESC, r.heure_debut DESC
    ");
    $all_reservations->bind_param("i", $current_user['user_id']);
    $all_reservations->execute();
    $result = $all_reservations->get_result();
    $all_reservations_list = $result->fetch_all(MYSQLI_ASSOC);

    // Get coach availabilities
    $availabilities = $connect->prepare("SELECT * FROM Disponibilite WHERE id_coach = ? ORDER BY date_disponibilite ASC, heure_debut ASC");
    $availabilities->bind_param("i", $current_user['user_id']);
    $availabilities->execute();
    $result = $availabilities->get_result();
    $availabilities_list = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Coach - SportCoach</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="issets/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="dashboard-coach.php" class="logo">
                <i class="fas fa-dumbbell"></i>
                <span>SportCoach</span>
            </a>
            <ul class="nav-menu">
                <li style="display: flex; align-items: center; gap: 10px;">
                    <img src="<?=$coach_photo?>" alt="<?= $coach_nom .' '.$coach_prenom ?>" style="width: 35px; height: 35px; border-radius: 50%;">
                    <span style="color: var(--primary-dark); font-weight: 600;"><?= $coach_prenom .' '.$coach_nom ?></span>
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
                    <a href="#" class="sidebar-link" onclick="showSection('reservations')">
                        <i class="fas fa-calendar-check"></i>
                        <span>Réservations</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="showSection('availability')">
                        <i class="fas fa-clock"></i>
                        <span>Mes Disponibilités</span>
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
                    <p style="color: var(--text-gray);">Bienvenue dans votre espace coach</p>
                </div>

                <!-- Stats Grid - DYNAMIC -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?= $pending_count ?></h3>
                            <p>Réservations en attente</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon confirmed">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?= $confirmed_count ?></h3>
                            <p>Séances confirmées</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon today">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?= $completed_count ?></h3>
                            <p>Séances complétées</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon tomorrow">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?= $athletes_count ?></h3>
                            <p>Sportifs totaux</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Reservations - DYNAMIC -->
                <div class="table-container">
                    <div class="table-header">
                        <h2>Réservations récentes</h2>
                        <button class="btn-secondary" onclick="showSection('reservations')">Voir tout</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Sportif</th>
                                <th>Discipline</th>
                                <th>Date & Heure</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent_reservations_list as $reservation): ?>
                            <tr>
                                <td><strong><?= $reservation['sportif_prenom'] . ' ' . $reservation['sportif_nom'] ?></strong></td>
                                <td><?= $reservation['discipline_nom'] ?? 'Non spécifiée' ?></td>
                                <td><?= date('d M Y', strtotime($reservation['date_seance'])) ?>, <?= substr($reservation['heure_debut'], 0, 5) ?></td>
                                <td>
                                    <?php if($reservation['statut'] == 'enattente'): ?>
                                        <span class="status-badge pending">En attente</span>
                                    <?php elseif($reservation['statut'] == 'acceptee'): ?>
                                        <span class="status-badge confirmed">Confirmée</span>
                                    <?php elseif($reservation['statut'] == 'refusee'): ?>
                                        <span class="status-badge cancelled">Refusée</span>
                                    <?php else: ?>
                                        <span class="status-badge confirmed">Terminée</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-buttons">
                                    <?php if($reservation['statut'] == 'enattente'): ?>
                                        <form method="POST" action="handle_reservation.php" style="display: inline;">
                                            <input type="hidden" name="reservation_id" value="<?= $reservation['id_reservation'] ?>">
                                            <input type="hidden" name="action" value="accept">
                                            <button type="submit" class="btn-accept">Accepter</button>
                                        </form>
                                        <form method="POST" action="handle_reservation.php" style="display: inline;">
                                            <input type="hidden" name="reservation_id" value="<?= $reservation['id_reservation'] ?>">
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn-reject">Refuser</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn-view">Détails</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(count($recent_reservations_list) == 0): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-gray);">
                                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 10px; display: block;"></i>
                                    Aucune réservation pour le moment
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Reservations Section - DYNAMIC -->
            <div id="reservationsSection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Mes Réservations</h1>
                    <p style="color: var(--text-gray);">Gérez toutes vos réservations</p>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2>Toutes les réservations</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sportif</th>
                                <th>Discipline</th>
                                <th>Date & Heure</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($all_reservations_list as $reservation): ?>
                            <tr>
                                <td>#<?= str_pad($reservation['id_reservation'], 3, '0', STR_PAD_LEFT) ?></td>
                                <td><strong><?= $reservation['sportif_prenom'] . ' ' . $reservation['sportif_nom'] ?></strong></td>
                                <td><?= $reservation['discipline_nom'] ?? 'Non spécifiée' ?></td>
                                <td><?= date('d M Y', strtotime($reservation['date_seance'])) ?>, <?= substr($reservation['heure_debut'], 0, 5) ?></td>
                                <td>
                                    <?php if($reservation['statut'] == 'enattente'): ?>
                                        <span class="status-badge pending">En attente</span>
                                    <?php elseif($reservation['statut'] == 'acceptee'): ?>
                                        <span class="status-badge confirmed">Confirmée</span>
                                    <?php elseif($reservation['statut'] == 'refusee'): ?>
                                        <span class="status-badge cancelled">Refusée</span>
                                    <?php else: ?>
                                        <span class="status-badge confirmed">Terminée</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-buttons">
                                    <?php if($reservation['statut'] == 'enattente'): ?>
                                        <form method="POST" action="handle_reservation.php" style="display: inline;">
                                            <input type="hidden" name="reservation_id" value="<?= $reservation['id_reservation'] ?>">
                                            <input type="hidden" name="action" value="accept">
                                            <button type="submit" class="btn-accept">Accepter</button>
                                        </form>
                                        <form method="POST" action="handle_reservation.php" style="display: inline;">
                                            <input type="hidden" name="reservation_id" value="<?= $reservation['id_reservation'] ?>">
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="btn-reject">Refuser</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn-view">Détails</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(count($all_reservations_list) == 0): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-gray);">
                                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 10px; display: block;"></i>
                                    Aucune réservation pour le moment
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Availability Section - NEW -->
            <div id="availabilitySection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Mes Disponibilités</h1>
                    <p style="color: var(--text-gray);">Gérez vos horaires de disponibilité</p>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div style="background: #d1fae5; border: 2px solid #10b981; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: 600;">
                        <i class="fas fa-check-circle"></i> <?= $_SESSION['success'] ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <div class="table-container">
                    <div class="table-header">
                        <h2>Mes créneaux horaires</h2>
                        <button class="btn-primary" onclick="openModal('addAvailabilityModal')">
                            <i class="fas fa-plus"></i> Ajouter un créneau
                        </button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Jour</th>
                                <th>Heure début</th>
                                <th>Heure fin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($availabilities_list as $avail): 
                                // Get day name in French from date
                                $date_obj = new DateTime($avail['date_disponibilite']);
                                $day_number = $date_obj->format('N');
                                $days_french = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'];
                                $jour_nom = $days_french[$day_number];
                            ?>
                            <tr>
                                <td><strong><?= date('d/m/Y', strtotime($avail['date_disponibilite'])) ?></strong></td>
                                <td><?= $jour_nom ?></td>
                                <td><?= substr($avail['heure_debut'], 0, 5) ?></td>
                                <td><?= substr($avail['heure_fin'], 0, 5) ?></td>
                                <td class="action-buttons">
                                    <form method="POST" action="delete_availability.php" style="display: inline;">
                                        <input type="hidden" name="disponibilite_id" value="<?= $avail['id_disponibilite'] ?>">
                                        <button type="submit" class="btn-reject">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(count($availabilities_list) == 0): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-gray);">
                                    <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 10px; display: block;"></i>
                                    Vous n'avez pas encore ajouté de disponibilités
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Profile Section -->
            <div id="profileSection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Mon Profil</h1>
                    <p style="color: var(--text-gray);">Modifiez vos informations professionnelles</p>
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
                    <form id="coachProfileForm" action="update_coach.php" method="POST" enctype="multipart/form-data" style="max-width: 700px; margin: 0 auto;">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <img id="coachPhotoPreview" src="<?=$coach_photo?>" alt="<?= $coach_nom .' '.$coach_prenom ?>" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 15px; object-fit: cover;">

                            <!-- Hidden file input for photo -->
                            <input type="file" name="photo" id="coachPhotoInput" accept="image/*" style="display: none;">

                            <button type="button" class="btn-secondary" onclick="document.getElementById('coachPhotoInput').click();">
                                <i class="fas fa-camera"></i> Changer la photo
                            </button>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" name="prenom" class="form-control" value="<?=$coach_prenom?>" style="padding-left: 15px;" required>
                            </div>
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" name="nom" class="form-control" value="<?=$coach_nom?>" style="padding-left: 15px;" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?=$coach_email?>" style="padding-left: 15px;" required>
                        </div>

                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="tel" name="phone" class="form-control" value="<?=$coach_phone?>" style="padding-left: 15px;" required>
                        </div>

                        <div class="form-group">
                            <label>Biographie</label>
                            <textarea name="biographie" class="form-control" rows="4" style="padding: 12px; resize: vertical; border-radius: 8px; border: 2px solid #e5e5e5;" required><?=$coach_biographie?></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label>Années d'expérience</label>
                                <input type="number" name="experience" class="form-control" value="<?=$coach_experience?>" style="padding-left: 15px;" min="0" required>
                            </div>
                            <div class="form-group">
                                <label>Tarif par heure (DH)</label>
                                <input type="number" name="prix" class="form-control" value="<?=$coach_prix?>" style="padding-left: 15px;" min="50" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Availability Modal -->
    <div class="modal" id="addAvailabilityModal" style="display: none;">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3>Ajouter un créneau</h3>
                <button class="close-modal" onclick="closeModal('addAvailabilityModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="add_availability.php">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date_disponibilite" class="form-control" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label>Heure de début</label>
                    <input type="time" name="heure_debut" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Heure de fin</label>
                    <input type="time" name="heure_fin" class="form-control" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-plus"></i> Ajouter
                </button>
            </form>
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
    <script src="issets/coach_dashboard.js" ></script>
    <script src="issets/coaches.js"></script>
</body>
</html>