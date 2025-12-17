<?php 
    require "connect.php";
    
    // Récupérer les coachs depuis la base de données
    $sql = "SELECT * FROM Coach";
    $result = $connect->query($sql);
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
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-dumbbell"></i>
                <span>SportCoach</span>
            </a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link"><i class="fas fa-home"></i> Accueil</a></li>
                <li><a href="coaches.php" class="nav-link"><i class="fas fa-users"></i> Nos Coachs</a></li>
                <li><a href="login.php" class="btn-secondary"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                <li><a href="register.php" class="btn-primary"><i class="fas fa-user-plus"></i> Inscription</a></li>
            </ul>
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
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
            
            <?php while($coach = $result->fetch_assoc()): ?>
            <!-- Coach Card -->
            <div class="coach-card" data-sport="football">
                <img src="<?php echo htmlspecialchars($coach['coach_photo']); ?>" alt="Coach" class="coach-image">
                <div class="coach-info">
                    <div class="coach-header">
                        <div>
                            <h3 class="coach-name"><?php echo htmlspecialchars($coach['coach_nom'] . ' ' . $coach['coach_prenom']); ?></h3>
                            <p class="coach-specialty">Football</p>
                        </div>
                        <div class="coach-rating">
                            <i class="fas fa-star"></i> 4.9
                        </div>
                    </div>
                    <div class="coach-stats">
                        <div class="stat-item">
                            <i class="fas fa-medal"></i>
                            <span>10 ans</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-users"></i>
                            <span>150+ élèves</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-certificate"></i>
                            <span>Certifié CAF</span>
                        </div>
                    </div>
                    <div class="coach-tags">
                        <span class="tag">Technique</span>
                        <span class="tag">Tactique</span>
                        <span class="tag">Jeunes</span>
                    </div>
                    <div class="coach-actions">
                        <button class="btn-view" onclick="viewCoachProfile(<?php echo $coach['id_coach']; ?>)">
                            <i class="fas fa-eye"></i> Voir profil
                        </button>
                        <button class="btn-book" onclick="bookSession(<?php echo $coach['id_coach']; ?>)">
                            <i class="fas fa-calendar-plus"></i> Réserver
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Contenu du modal caché pour ce coach (sera copié dans le modal principal) -->
            <div id="coachModalContent<?php echo $coach['id_coach']; ?>" style="display: none;">
                <div style="text-align: center; margin-bottom: 25px;">
                    <img src="<?php echo htmlspecialchars($coach['coach_photo']); ?>" 
                         alt="<?php echo htmlspecialchars($coach['coach_nom']); ?>" 
                         style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 15px;">
                    <h2 style="color: var(--primary-dark); margin-bottom: 5px;">
                        <?php echo htmlspecialchars($coach['coach_nom'] . ' ' . $coach['coach_prenom']); ?>
                    </h2>
                    <p style="color: var(--primary-gold); font-weight: 600; font-size: 18px;">Football</p>
                </div>
                
                <div style="background-color: var(--primary-light); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <h3 style="color: var(--primary-dark); margin-bottom: 15px;">
                        <i class="fas fa-user"></i> À propos
                    </h3>
                    <p style="color: var(--text-gray); line-height: 1.8;">
                        <?php echo htmlspecialchars($coach['coach_biographie']); ?>
                    </p>
                </div>
                
                <button onclick="bookSession(<?php echo $coach['id_coach']; ?>)" class="btn-submit" style="width: 100%;">
                    <i class="fas fa-calendar-plus"></i> Réserver une séance
                </button>
            </div>
            <?php endwhile; ?>

        </div>
    </section>

    <!-- Coach Profile Modal (unique pour tous) -->
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