<!DOCTYPE html>
<html lang="fr">
<head>
    <title>M A R K E T - Marché en ligne</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Boutique en ligne avec livraison à domicile">
    <style>
        /* Reset et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        /* Header */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .market-logo {
            width: 60px;
            height: auto;
        }

        .market-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Navigation */
        .main-nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .main-nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .main-nav a:hover {
            color: #f39c12;
        }

        .mobile-menu-btn {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 10px;
            color: white;
        }

        .hero-content {
            flex: 1;
            padding-right: 2rem;
        }

        .hero-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-button {
            display: inline-block;
            background-color: #f39c12;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #e67e22;
        }

        .hero-image {
            flex: 1;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        /* Features Section */
        .features-section {
            display: flex;
            justify-content: center;
            gap: 2rem;
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            flex: 1;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #3498db;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        /* Footer */
        .footer-section {
            background-color: #2c3e50;
            color: white;
            padding: 3rem 0 0;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-about, .footer-contact, .footer-social {
            flex: 1;
            padding: 0 1rem;
        }

        .footer-about h3, .footer-contact h3, .footer-social h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-about h3::after, .footer-contact h3::after, .footer-social h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: #f39c12;
        }

        .contact-list {
            list-style: none;
        }

        .contact-list li {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .contact-list a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .contact-list a:hover {
            color: #f39c12;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-icons a {
            color: white;
            background-color: #34495e;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background-color: #f39c12;
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 2rem;
            background-color: #1a252f;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }
        
            .main-nav ul {
                flex-direction: column;
                gap: 1rem;
                align-items: center;
            }
        
            .hero-section {
                flex-direction: column;
                text-align: center;
            }
        
            .hero-content {
                padding-right: 0;
                margin-bottom: 2rem;
            }
        
            .features-section {
                flex-direction: column;
            }
        
            .footer-container {
                flex-direction: column;
                gap: 2rem;
            }
        
            .mobile-menu-btn {
                display: block;
            }
        
            .main-nav {
                display: none;
            }
        
            .main-nav.active {
                display: block;
            }
        }

        /* Icônes Font Awesome (version allégée) */
        .fas {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }
        .fa-users:before { content: "👥"; }
        .fa-shopping-basket:before { content: "🛒"; }
        .fa-clipboard-list:before { content: "📋"; }
        .fa-arrow-right:before { content: "→"; }
        .fa-truck:before { content: "🚚"; }
        .fa-credit-card:before { content: "💳"; }
        .fa-headset:before { content: "🎧"; }
        .fa-phone:before { content: "📞"; }
        .fa-envelope:before { content: "✉"; }
        .fa-map-marker-alt:before { content: "📍"; }
        .fa-bars:before { content: "☰"; }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo-container">
                <img class="market-logo" src="image/market1.png" alt="Logo Market">
                <h1 class="market-title">Marché en ligne</h1>
            </div>
            
            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="client.php"><i class="fas fa-users"></i> Clients</a></li>
                    <li><a href="produit.php"><i class="fas fa-shopping-basket"></i> Produits</a></li>
                    <li><a href="commande.php"><i class="fas fa-clipboard-list"></i> Commandes</a></li>
                </ul>
            </nav>
            
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>
    
    <main>
        <section class="hero-section">
            <div class="hero-content">
                <h2>Votre marché à portée de clic</h2>
                <p class="hero-description">Découvrez nos produits frais et de qualité, livrés directement chez vous</p>
                <a href="produit.php" class="cta-button">Voir les produits <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="hero-image">
                <img src="image/market1.png" alt="Panier de courses">
            </div>
        </section>
        
        <section class="features-section">
            <div class="feature-card">
                <i class="fas fa-truck feature-icon"></i>
                <h3>Livraison rapide</h3>
                <p>Livré à domicile en moins de 24h</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-credit-card feature-icon"></i>
                <h3>Paiement sécurisé</h3>
                <p>Plusieurs méthodes de paiement</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-headset feature-icon"></i>
                <h3>Service client</h3>
                <p>Assistance 7j/7</p>
            </div>
        </section>
    </main>
    
    <footer class="footer-section">
        <div class="footer-container">
            <div class="footer-about">
                <h3>À propos</h3>
                <p>Commandez tous les produits disponibles dans notre liste et bénéficiez d'une livraison à domicile.</p>
                <p>Frais de livraison: 50 000 Fmg</p>
            </div>
            
            <div class="footer-contact">
                <h3>Contactez-nous</h3>
                <ul class="contact-list">
                    <li><i class="fas fa-phone"></i> +261 34 001 35</li>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:Marcherenligne@gmail.com">Marcherenligne@gmail.com</a></li>
                    <li><i class="fas fa-map-marker-alt"></i> Antananarivo, Madagascar</li>
                </ul>
            </div>
            
            <div class="footer-social">
    <h3>Suivez-nous</h3>
    <div class="social-icons">
        <a href="mailto:ralahyisaorymialy.com" title="Envoyer un email">
            <i class="fas fa-envelope"></i>
        </a>
        <a href="https://www.facebook.com/alyim04" target="_blank" title="Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://wa.me/261343026444" target="_blank" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</div>

        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 RALAHY ISAORY Mialy Fitahiana. M A R K E T. Tous droits réservés.</p>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const mainNav = document.querySelector('.main-nav');
            
            mobileMenuBtn.addEventListener('click', function() {
                mainNav.classList.toggle('active');
            });
            
            // Animation pour les cartes de features
            const featureCards = document.querySelectorAll('.feature-card');
            
            featureCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.transitionDelay = `${index * 0.1}s`;
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 300);
            });
        });
    </script>
</body>
</html>