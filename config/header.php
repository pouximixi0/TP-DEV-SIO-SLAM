<?php
$page = strtolower(basename($_SERVER['PHP_SELF']));

$nbArticles = 0;
if (!empty($_SESSION['panier'])) {
    $nbArticles = array_sum($_SESSION['panier']);
}
?>

<header class="headerSite">

    <a href="index.php" class="logo">
        <img src="img/logo.png" alt="Logo Bleach Commerce">
    </a>

    <nav class="navbar">
        <a href="index.php" class="<?= $page === "index.php" ? "active" : "" ?>">Accueil</a>
        <a href="articles.php" class="<?= $page === "articles.php" ? "active" : "" ?>">Articles</a>
        <a href="apropos.php" class="<?= $page === "apropos.php" ? "active" : "" ?>">À propos</a>
        <a href="contact.php" class="<?= $page === "contact.php" ? "active" : "" ?>">Contact</a>
    </nav>

    <div class="navbarAccount">
        <?php if (!empty($_SESSION['user_name'])) { ?>
            <span class="navbarPseudo">Bonjour, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="deconnexion.php">Déconnexion</a>
        <?php } else { ?>
            <a href="connexion.php" class="<?= $page === "connexion.php" ? "active" : "" ?>">Connexion</a>
            <a href="inscription.php" class="<?= $page === "inscription.php" ? "active" : "" ?>">Inscription</a>
        <?php } ?>

        <a href="panier.php" class="btnPanier <?= $page === "panier.php" ? "active" : "" ?>">
            Panier
            <span class="badge"><?= $nbArticles ?></span>
        </a>
    </div>

</header>
