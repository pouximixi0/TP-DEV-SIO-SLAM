<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = strtolower(basename($_SERVER['PHP_SELF']));

$nbArticles = 0;
if (!empty($_SESSION['panier'])) {
    $nbArticles = array_sum($_SESSION['panier']);
}
?>

<header class="headerSite">

    <a href="/index.php" class="logo">
        <img src="/img/logo.png" alt="Logo Bleach Commerce">
    </a>

    <nav class="navbar">
        <a href="/index.php" class="<?= $page === "index.php" ? "active" : "" ?>">Accueil</a>
        <a href="/html/articles.php" class="<?= $page === "articles.php" ? "active" : "" ?>">Articles</a>
        <a href="/html/about.php" class="<?= $page === "about.php" ? "active" : "" ?>">À propos</a>
        <a href="/html/contact.php" class="<?= $page === "contact.php" ? "active" : "" ?>">Contact</a>
    </nav>

    <div class="navbarAccount">
        <?php if (!empty($_SESSION['user_name'])) { ?>
            <span class="navbarPseudo">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="/include/logout.php">Déconnexion</a>
        <?php } else { ?>
            <a href="/html/connexion.php" class="<?= $page === "connexion.php" ? "active" : "" ?>">Connexion</a>
            <a href="/html/inscription.php" class="<?= $page === "inscription.php" ? "active" : "" ?>">Inscription</a>
        <?php } ?>

        <a href="/html/panier.php" class="btn-panier <?= $page === "panier.php" ? "active" : "" ?>">
            Panier
            <span class="badge"><?= $nbArticles ?></span>
        </a>
    </div>

</header>
