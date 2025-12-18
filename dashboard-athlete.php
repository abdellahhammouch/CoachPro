<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require "connect.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace - SportCoach</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.html" class="logo">
                <i class="fas fa-dumbbell"></i>
                <span>SportCoach</span>
            </a>
            <ul class="nav-menu">
                <li><a href="coaches.html" class="nav-link"><i class="fas fa-users"></i> Trouver un coach</a></li>
                <li style="display: flex; align-items: center; gap: 10px;">
                    <img src="https://ui-avatars.com/api/?name=Sportif&background=74512D&color=fff" alt="Avatar" style="width: 35px; height: 35px; border-radius: 50%;">
                    <span style="color: var(--primary-dark); font-weight: 600;">Yassine M.</span>
                </li>
                <li><a href="index.html" class="btn-secondary"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
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
                    <a href="coaches.html" class="sidebar-link">
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
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" onclick="showSection('settings')">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
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
                            <h3>2</h3>
                            <p>Réservations en attente</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon confirmed">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-details">
                            <h3>1</h3>
                            <p>Prochaine séance</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon today">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-details">
                            <h3>12</h3>
                            <p>Séances complétées</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon tomorrow">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="stat-details">
                            <h3>3</h3>
                            <p>Coachs actifs</p>
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
                            <button class="btn-primary" onclick="window.location.href='coaches.html'">
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

            <!-- My Coaches Section -->
            <div id="mycoachesSection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Mes Coachs</h1>
                    <p style="color: var(--text-gray);">Les coachs avec qui vous travaillez</p>
                </div>

                <div class="coaches-grid" style="max-width: 1200px;">
                    <div class="coach-card">
                        <img src="https://images.unsplash.com/photo-1605454621097-d3a93d4e3f5f?w=400&h=300&fit=crop" alt="Coach" class="coach-image">
                        <div class="coach-info">
                            <div class="coach-header">
                                <div>
                                    <h3 class="coach-name">Ahmed Benali</h3>
                                    <p class="coach-specialty">Football</p>
                                </div>
                                <div class="coach-rating">
                                    <i class="fas fa-star"></i> 4.9
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
                                <div class="stat-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Depuis 1 mois</span>
                                </div>
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
            </div>

            <!-- Profile Section -->
            <div id="profileSection" class="dashboard-section" style="display: none;">
                <div class="dashboard-header">
                    <h1>Mon Profil</h1>
                    <p style="color: var(--text-gray);">Modifiez vos informations personnelles</p>
                </div>

                <div class="table-container">
                    <form id="athleteProfileForm" style="max-width: 700px; margin: 0 auto;">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <img src="https://ui-avatars.com/api/?name=Yassine+M&background=74512D&color=fff&size=120" alt="Photo" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 15px;">
                            <button type="button" class="btn-secondary">
                                <i class="fas fa-camera"></i> Changer la photo
                            </button>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" class="form-control" value="Yassine" style="padding-left: 15px;">
                            </div>
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control" value="Mouhib" style="padding-left: 15px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="yassine.m@email.com" style="padding-left: 15px;">
                        </div>

                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="tel" class="form-control" value="+212 6XX-XXXXXX" style="padding-left: 15px;">
                        </div>

                        <div class="form-group">
                            <label>Date de naissance</label>
                            <input type="date" class="form-control" value="1995-03-15" style="padding-left: 15px;">
                        </div>

                        <div class="form-group">
                            <label>Sports d'intérêt</label>
                            <input type="text" class="form-control" value="Football, Tennis" style="padding-left: 15px;" placeholder="Séparés par des virgules">
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
    <script src="athlete-space.js"></script>
    <script src="main.js"></script>
</body>
</html>