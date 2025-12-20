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
    <title>SportCoach - Trouvez votre coach sportif idéal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="issets/style.css">
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Trouvez votre <span class="highlight">coach sportif</span> idéal</h1>
                <p>Réservez des séances personnalisées avec des coachs professionnels dans toutes les disciplines sportives. Atteignez vos objectifs avec un accompagnement sur mesure.</p>
                <div class="hero-buttons">
                    <a href="coaches.php" class="btn-primary">
                        <i class="fas fa-search"></i> Découvrir les coachs
                    </a>
                    <a href="register.php" class="btn-secondary">
                        <i class="fas fa-user-plus"></i> Créer un compte
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=600&h=600&fit=crop" alt="Coach sportif">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="section-title">
            <h2>Pourquoi choisir SportCoach ?</h2>
            <p>Une plateforme complète pour votre développement sportif</p>
        </div>
        <div class="features-container">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Coachs Professionnels</h3>
                <p>Accédez à des coachs certifiés et expérimentés dans toutes les disciplines sportives.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>Réservation Facile</h3>
                <p>Réservez vos séances en quelques clics selon vos disponibilités et vos objectifs.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Suivi Personnalisé</h3>
                <p>Bénéficiez d'un accompagnement personnalisé adapté à votre niveau et vos ambitions.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3>Multiples Disciplines</h3>
                <p>Football, tennis, natation, préparation physique et bien plus encore.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Horaires Flexibles</h3>
                <p>Trouvez des créneaux qui correspondent à votre emploi du temps.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Paiement Sécurisé</h3>
                <p>Transactions sécurisées et protection de vos données personnelles.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="features" style="background-color: var(--primary-light); text-align: center; padding: 60px 20px;">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="font-size: 36px; color: var(--primary-dark); margin-bottom: 20px;">
                Prêt à commencer votre transformation ?
            </h2>
            <p style="font-size: 18px; color: var(--text-gray); margin-bottom: 30px;">
                Rejoignez des milliers de sportifs qui ont déjà atteint leurs objectifs avec nos coachs professionnels.
            </p>
            <a href="register.php" class="btn-primary" style="display: inline-block; font-size: 18px; padding: 15px 40px;">
                <i class="fas fa-rocket"></i> Commencer maintenant
            </a>
        </div>
    </section>

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
                    <li><a href="#">Conditions d'utilisation</a></li>
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

    <script src="issets/main.js"></script>
</body>
</html>²