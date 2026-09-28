<footer class="footerSite">
    <div class="footerHaut">
        <div class="footerMarque">
            <img src="/img/logo.png" alt="Logo Bleach Commerce">
            <p>Figurines, vêtements, posters et accessoires autour de l'univers de Bleach. Un catalogue monté à la main par deux fans.</p>
        </div>

        <div class="footerColonne">
            <h3>Navigation</h3>
            <a href="/index.php">Accueil</a>
            <a href="/html/articles.php">Articles</a>
            <a href="/html/about.php">À propos</a>
            <a href="/html/contact.php">Contact</a>
        </div>

        <div class="footerColonne">
            <h3>Mon compte</h3>
            <?php if (!empty($_SESSION['user_name'])) { ?>
                <a href="/html/panier.php">Mon panier</a>
                <a href="/include/logout.php">Déconnexion</a>
            <?php } else { ?>
                <a href="/html/connexion.php">Connexion</a>
                <a href="/html/inscription.php">Inscription</a>
                <a href="/html/panier.php">Mon panier</a>
            <?php } ?>
        </div>

        <div class="footerColonne">
            <h3>Nous contacter</h3>
            <a href="mailto:contact@bleach-commerce.fr">contact@bleach-commerce.fr</a>
            <p>Alexis &amp; Juventin<br>Étudiants BTS SIO</p>
            <p>Réponse sous 48 h<br>du lundi au vendredi</p>
        </div>
    </div>

    <div class="footerBas">
        <p>&copy; <?= date('Y') ?> Bleach Commerce. Tous droits réservés.</p>
        <p>Site réalisé dans le cadre d'un projet étudiant</p>
    </div>
</footer>
