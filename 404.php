<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - SportCoach</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%); padding: 20px;">
        <div style="text-align: center; max-width: 600px;">
            <div style="position: relative; margin-bottom: 30px;">
                <h1 style="font-size: 150px; color: var(--primary-gold); font-weight: bold; margin: 0; line-height: 1;">
                    404
                </h1>
                <i class="fas fa-dumbbell" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 80px; color: var(--primary-brown); opacity: 0.3;"></i>
            </div>

            <h2 style="font-size: 32px; color: var(--primary-dark); margin-bottom: 15px;">
                Page non trouvée
            </h2>
            
            <p style="font-size: 18px; color: var(--text-gray); margin-bottom: 40px; line-height: 1.6;">
                Désolé, la page que vous recherchez semble avoir pris la fuite comme un sprinter olympique ! Elle n'existe pas ou a été déplacée.
            </p>

            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="index.html" class="btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 15px 30px; font-size: 16px;">
                    <i class="fas fa-home"></i>
                    Retour à l'accueil
                </a>
                <a href="coaches.html" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; padding: 13px 28px; font-size: 16px;">
                    <i class="fas fa-users"></i>
                    Voir les coachs
                </a>
            </div>

            <div style="margin-top: 60px; padding: 30px; background-color: var(--white); border-radius: 15px; box-shadow: 0 5px 20px var(--shadow);">
                <h3 style="font-size: 20px; color: var(--primary-dark); margin-bottom: 20px;">
                    <i class="fas fa-compass" style="color: var(--primary-gold);"></i>
                    Vous cherchez quelque chose ?
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                    <a href="index.html" style="padding: 15px; background-color: var(--primary-light); border-radius: 10px; color: var(--primary-dark); transition: all 0.3s ease; display: block;">
                        <i class="fas fa-home" style="font-size: 24px; color: var(--primary-gold); display: block; margin-bottom: 8px;"></i>
                        <strong>Accueil</strong>
                    </a>
                    <a href="coaches.html" style="padding: 15px; background-color: var(--primary-light); border-radius: 10px; color: var(--primary-dark); transition: all 0.3s ease; display: block;">
                        <i class="fas fa-users" style="font-size: 24px; color: var(--primary-gold); display: block; margin-bottom: 8px;"></i>
                        <strong>Nos Coachs</strong>
                    </a>
                    <a href="login.html" style="padding: 15px; background-color: var(--primary-light); border-radius: 10px; color: var(--primary-dark); transition: all 0.3s ease; display: block;">
                        <i class="fas fa-sign-in-alt" style="font-size: 24px; color: var(--primary-gold); display: block; margin-bottom: 8px;"></i>
                        <strong>Connexion</strong>
                    </a>
                    <a href="register.html" style="padding: 15px; background-color: var(--primary-light); border-radius: 10px; color: var(--primary-dark); transition: all 0.3s ease; display: block;">
                        <i class="fas fa-user-plus" style="font-size: 24px; color: var(--primary-gold); display: block; margin-bottom: 8px;"></i>
                        <strong>Inscription</strong>
                    </a>
                </div>
            </div>

            <p style="margin-top: 40px; color: var(--text-gray); font-size: 14px;">
                <i class="fas fa-question-circle"></i>
                Besoin d'aide ? <a href="#" style="color: var(--primary-gold); font-weight: 600;">Contactez-nous</a>
            </p>
        </div>
    </div>

    <script>
        // Add hover effects
        document.querySelectorAll('a[href]').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Auto redirect after 10 seconds (optional)
        let countdown = 10;
        const timer = setInterval(() => {
            countdown--;
            if (countdown === 0) {
                window.location.href = 'index.html';
                clearInterval(timer);
            }
        }, 1000);
    </script>
</body>
</html>