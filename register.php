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
    <title>Inscription - SportCoach</title>
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

    <!-- Register Form -->
    <div class="form-container" style="max-width: 600px;">
        <div class="form-header">
            <h2>Créer un compte</h2>
            <p>Rejoignez notre communauté sportive</p>
        </div>
        <form id="registerForm" action="register_handling" method="post" novalidate>
            <div class="form-group">
                <label for="userType">Je m'inscris en tant que</label>
                <div class="input-group">
                    <i class="fas fa-user-tag"></i>
                    <select name="useraType" id="userType" class="form-control" required>
                        <option value="">Sélectionnez votre rôle</option>
                        <option value="sportif">Sportif</option>
                        <option value="coach">Coach professionnel</option>
                    </select>
                </div>
                <span class="error-message" id="userTypeError">Veuillez sélectionner un type de compte</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label for="firstName">Prénom</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="prénom" id="firstName" class="form-control" placeholder="Votre prénom" required>
                    </div>
                    <span class="error-message" id="firstNameError">Le prénom est requis (min. 2 caractères)</span>
                </div>

                <div class="form-group">
                    <label for="lastName">Nom</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="nom" id="lastName" class="form-control" placeholder="Votre nom" required>
                    </div>
                    <span class="error-message" id="lastNameError">Le nom est requis (min. 2 caractères)</span>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" class="form-control" placeholder="votre@email.com" required>
                </div>
                <span class="error-message" id="emailError">Veuillez entrer un email valide</span>
            </div>

            <div class="form-group">
                <label for="phone">Téléphone</label>
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="+212 6XX-XXXXXX" required>
                </div>
                <span class="error-message" id="phoneError">Format: +212 6XX-XXXXXX ou 06XX-XXXXXX</span>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Min. 8 caractères" required>
                </div>
                <span class="error-message" id="passwordError">8 caractères min. (majuscule, minuscule, chiffre)</span>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirmer le mot de passe</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirmez votre mot de passe" required>
                </div>
                <span class="error-message" id="confirmPasswordError">Les mots de passe ne correspondent pas</span>
            </div>

            <!-- Coach specific fields -->
            <div id="coachFields" style="display: none;">
                <div class="form-group">
                    <label for="specialties">Spécialités (séparées par des virgules)</label>
                    <div class="input-group">
                        <i class="fas fa-medal"></i>
                        <input type="text" id="specialties" class="form-control" placeholder="Football, Tennis, Natation...">
                        <select name="useraType" id="userType" class="form-control" required>
                            <option value="">Sélectionnez votre rôle</option>
                            <option value="Football">Football</option>
                            <option value="Tennis">Tennis</option>
                            <option value="Natation">Natation</option>
                            <option value="Preparation physique">Preparation physique</option>
                            <option value="Boxe">Boxe</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="experience">Années d'expérience</label>
                    <div class="input-group">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="number" id="experience" class="form-control" placeholder="Ex: 5" min="0">
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: start; gap: 10px; cursor: pointer;">
                    <input type="checkbox" id="terms" required style="margin-top: 4px;">
                    <span style="font-size: 14px; color: var(--text-gray);">
                        J'accepte les <a href="#" style="color: var(--primary-gold); font-weight: 600;">conditions d'utilisation</a>
                        et la <a href="#" style="color: var(--primary-gold); font-weight: 600;">politique de confidentialité</a>
                    </span>
                </label>
                <span class="error-message" id="termsError">Vous devez accepter les conditions</span>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus"></i> Créer mon compte
            </button>
        </form>

        <div class="form-footer">
            <p>Vous avez déjà un compte ? <a href="login.html">Connectez-vous</a></p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer" style="margin-top: 50px;">
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