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
    $profil_Coach = $connect->prepare("select * from Coach where id_coach = ?");
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

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-details">
                            <h3>5</h3>
                            <p>Réservations en attente</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon confirmed">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-details">
                            <h3>12</h3>
                            <p>Séances confirmées</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon today">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-details">
                            <h3>48</h3>
                            <p>Séances complétées</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon tomorrow">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3>23</h3>
                            <p>Sportifs totaux</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Reservations -->
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
                            <tr>
                                <td><strong>Mohamed Alami</strong></td>
                                <td>Football</td>
                                <td>22 Déc 2024, 10:00</td>
                                <td><span class="status-badge pending">En attente</span></td>
                                <td class="action-buttons">
                                    <button class="btn-accept" onclick="acceptReservation(1)">Accepter</button>
                                    <button class="btn-reject" onclick="rejectReservation(1)">Refuser</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Fatima Zahra</strong></td>
                                <td>Football</td>
                                <td>23 Déc 2024, 14:00</td>
                                <td><span class="status-badge pending">En attente</span></td>
                                <td class="action-buttons">
                                    <button class="btn-accept" onclick="acceptReservation(2)">Accepter</button>
                                    <button class="btn-reject" onclick="rejectReservation(2)">Refuser</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Hassan Benani</strong></td>
                                <td>Football</td>
                                <td>21 Déc 2024, 16:00</td>
                                <td><span class="status-badge confirmed">Confirmée</span></td>
                                <td><button class="btn-view" onclick="viewReservationDetails(3)">Détails</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Reservations Section -->
            <div id="reservationsSection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Mes Réservations</h1>
                    <p style="color: var(--text-gray);">Gérez toutes vos réservations</p>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2>Toutes les réservations</h2>
                        <select class="form-control" style="width: auto; padding: 8px 15px;">
                            <option>Tous les statuts</option>
                            <option>En attente</option>
                            <option>Confirmées</option>
                            <option>Terminées</option>
                            <option>Refusées</option>
                        </select>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sportif</th>
                                <th>Discipline</th>
                                <th>Date & Heure</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#001</td>
                                <td><strong>Mohamed Alami</strong></td>
                                <td>Football</td>
                                <td>22 Déc 2024, 10:00</td>
                                <td>1h</td>
                                <td><span class="status-badge pending">En attente</span></td>
                                <td class="action-buttons">
                                    <button class="btn-accept" onclick="acceptReservation(1)">Accepter</button>
                                    <button class="btn-reject" onclick="rejectReservation(1)">Refuser</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#002</td>
                                <td><strong>Fatima Zahra</strong></td>
                                <td>Football</td>
                                <td>23 Déc 2024, 14:00</td>
                                <td>1h</td>
                                <td><span class="status-badge pending">En attente</span></td>
                                <td class="action-buttons">
                                    <button class="btn-accept" onclick="acceptReservation(2)">Accepter</button>
                                    <button class="btn-reject" onclick="rejectReservation(2)">Refuser</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#003</td>
                                <td><strong>Hassan Benani</strong></td>
                                <td>Football</td>
                                <td>21 Déc 2024, 16:00</td>
                                <td>1h</td>
                                <td><span class="status-badge confirmed">Confirmée</span></td>
                                <td><button class="btn-view" onclick="viewReservationDetails(3)">Détails</button></td>
                            </tr>
                            <tr>
                                <td>#004</td>
                                <td><strong>Amina Tazi</strong></td>
                                <td>Football</td>
                                <td>20 Déc 2024, 11:00</td>
                                <td>1.5h</td>
                                <td><span class="status-badge confirmed">Terminée</span></td>
                                <td><button class="btn-view" onclick="viewReservationDetails(4)">Détails</button></td>
                            </tr>
                            <tr>
                                <td>#005</td>
                                <td><strong>Youssef Idrissi</strong></td>
                                <td>Football</td>
                                <td>24 Déc 2024, 09:00</td>
                                <td>1h</td>
                                <td><span class="status-badge pending">En attente</span></td>
                                <td class="action-buttons">
                                    <button class="btn-accept" onclick="acceptReservation(5)">Accepter</button>
                                    <button class="btn-reject" onclick="rejectReservation(5)">Refuser</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#006</td>
                                <td><strong>Sara Bennani</strong></td>
                                <td>Football</td>
                                <td>25 Déc 2024, 15:00</td>
                                <td>1h</td>
                                <td><span class="status-badge confirmed">Confirmée</span></td>
                                <td><button class="btn-view" onclick="viewReservationDetails(6)">Détails</button></td>
                            </tr>
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

                <!-- SUCCESS/ERROR MESSAGES -->
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
                    <form id="coachProfileForm" action="update_coach_profile.php" method="POST" style="max-width: 700px; margin: 0 auto;">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <img src="<?=$coach_photo?>" alt="<?= $coach_nom .' '.$coach_prenom ?>" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 15px;">
                            <button type="button" class="btn-secondary">
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

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-bottom" style="padding: 20px;">
            <p>&copy; 2024 SportCoach. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="main.js"></script>
    <script>
        // Simple functions for accept/reject reservations
        function acceptReservation(id) {
            showConfirmAlert(
                'Accepter la réservation',
                'Voulez-vous accepter cette réservation ?',
                function() {
                    // Here you will add the code to accept in database
                    showSuccessAlert('Réservation acceptée', 'La réservation a été acceptée avec succès');
                }
            );
        }

        function rejectReservation(id) {
            showConfirmAlert(
                'Refuser la réservation',
                'Voulez-vous refuser cette réservation ?',
                function() {
                    // Here you will add the code to reject in database
                    showSuccessAlert('Réservation refusée', 'La réservation a été refusée');
                }
            );
        }

        function viewReservationDetails(id) {
            showSuccessAlert('Détails', 'Ici vous verrez les détails de la réservation #' + id);
        }
    </script>
</body>
</html>