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
    <title>Connexion - SportCoach</title>
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
                <li><a href="index.html" class="nav-link"><i class="fas fa-home"></i> Accueil</a></li>
                <li><a href="coaches.html" class="nav-link"><i class="fas fa-users"></i> Nos Coachs</a></li>
                <li><a href="login.html" class="btn-secondary"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                <li><a href="register.html" class="btn-primary"><i class="fas fa-user-plus"></i> Inscription</a></li>
            </ul>
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="form-container">
        <div class="form-header">
            <h2>Connexion</h2>
            <p>Accédez à votre espace personnel</p>
        </div>
        <form id="loginForm" action="login_handling" method="post" novalidate>
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" class="form-control" placeholder="votre@email.com" required>
                </div>
                <span class="error-message" id="emailError">Veuillez entrer un email valide</span>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" class="form-control" placeholder="Votre mot de passe" required>
                </div>
                <span class="error-message" id="passwordError">Le mot de passe est requis</span>
            </div>

            <div class="form-group">
                <label for="userType">Type de compte</label>
                <div class="input-group">
                    <i class="fas fa-user-tag"></i>
                    <select id="userType" class="form-control" required>
                        <option value="">Sélectionnez votre rôle</option>
                        <option value="athlete">Sportif</option>
                        <option value="coach">Coach</option>
                    </select>
                </div>
                <span class="error-message" id="userTypeError">Veuillez sélectionner un type de compte</span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" id="rememberMe">
                    <span style="font-size: 14px; color: var(--text-gray);">Se souvenir de moi</span>
                </label>
                <a href="#" style="font-size: 14px; color: var(--primary-gold); font-weight: 600;">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>

        <div class="form-footer">
            <p>Vous n'avez pas de compte ? <a href="register.html">Inscrivez-vous</a></p>
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
                    <li><a href="index.html">Accueil</a></li>
                    <li><a href="coaches.html">Nos Coachs</a></li>
                    <li><a href="login.html">Connexion</a></li>
                    <li><a href="register.html">Inscription</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="auth.js"></script>
    <script src="main.js"></script>
</body>
</html>