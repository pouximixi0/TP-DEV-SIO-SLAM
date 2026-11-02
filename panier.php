<?php
session_start();
require_once('config/db.php');

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = "";
    $id = "";
    $quantite = 1;
    $retour = "";

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    }
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    }
    if (isset($_POST['quantite'])) {
        $quantite = (int) $_POST['quantite'];
    }
    if (isset($_POST['retour'])) {
        $retour = $_POST['retour'];
    }

    if ($action == "ajouter" || $action == "plus" || $action == "moins") {
        $stmt = $pdo->prepare("SELECT stock_dispo FROM produit WHERE id_produit = ?");
        $stmt->execute([$id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produit) {
            unset($_SESSION['panier'][$id]);
            header("Location: panier.php?status=introuvable");
            exit();
        }

        $dansPanier = 0;
        if (isset($_SESSION['panier'][$id])) {
            $dansPanier = $_SESSION['panier'][$id];
        }

        if ($action == "ajouter") {
            $quantite = $dansPanier + $quantite;
        }
        if ($action == "plus") {
            $quantite = $dansPanier + 1;
        }
        if ($action == "moins") {
            $quantite = $dansPanier - 1;
        }

        if ($quantite > $produit['stock_dispo']) {
            $quantite = $produit['stock_dispo'];
        }

        if ($quantite <= 0) {
            unset($_SESSION['panier'][$id]);
        } else {
            $_SESSION['panier'][$id] = $quantite;
        }
    }

    if ($action == "supprimer") {
        unset($_SESSION['panier'][$id]);
    }

    if ($action == "vider") {
        $_SESSION['panier'] = [];
    }

    if ($action == "commander") {
        if (empty($_SESSION['user_name'])) {
            header("Location: connexion.php?retour=panier");
            exit();
        }
        $_SESSION['panier'] = [];
        header("Location: panier.php?status=commande");
        exit();
    }

    if ($action == "ajouter" && $retour == "articles") {
        header("Location: articles.php?status=ajoute");
        exit();
    }

    if ($action == "ajouter") {
        header("Location: panier.php?status=ajoute");
    } else {
        header("Location: panier.php");
    }
    exit();
}

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$lignes = [];
$total = 0;

foreach ($_SESSION['panier'] as $id => $quantite) {
    $stmt = $pdo->prepare("SELECT id_produit, nom, prix_actuel, stock_dispo, image_url FROM produit WHERE id_produit = ?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produit) {
        $produit['quantite'] = $quantite;
        $produit['sous_total'] = $produit['prix_actuel'] * $quantite;
        $total = $total + $produit['sous_total'];
        $lignes[] = $produit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce panier</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/panier.css">
</head>

<body>
    <?php include 'config/header.php'; ?>

    <section class="pageTitre">
        <h1>Mon panier</h1>
        <div class="trait"></div>
        <?php if (count($lignes) > 0) { ?>
            <p>Vous avez <?= count($lignes) ?> article(s) différent(s) dans votre panier.</p>
        <?php } ?>
    </section>

    <section class="panier">
        <?php if ($status == "ajoute") { ?>
            <p class="message messageOk">L'article a bien été ajouté à votre panier.</p>
            <a href="articles.php" class="btn btnOrange">continuer vos achats</a>
        <?php } elseif ($status == "commande") { ?>
            <p class="message messageOk">Votre commande a bien été enregistrée</p>
        <?php } elseif ($status == "introuvable") { ?>
            <p class="message messageErreur">Cet article n'existe plus.</p>
        <?php } ?>

        <?php if (count($lignes) == 0) { ?>
            <div class="panierVide">
                <h2>Votre panier est vide</h2>
                <p>Faites un tour dans le catalogue, il y a forcément une figurine qui vous attend.</p>
                <a href="articles.php" class="btn btnOrange">Voir les articles</a>
            </div>
        <?php } else { ?>
            <div class="panierContenu">
                <div class="panierLignes">
                    <?php foreach ($lignes as $ligne) { ?>
                        <div class="panierLigne">
                            <a href="article.php?id=<?= $ligne['id_produit'] ?>">
                                <img src="img/articles/<?= htmlspecialchars($ligne['image_url']) ?>" alt="<?= htmlspecialchars($ligne['nom']) ?>">
                            </a>

                            <div class="panierInfos">
                                <a href="article.php?id=<?= $ligne['id_produit'] ?>" class="panierNom"><?= htmlspecialchars($ligne['nom']) ?></a>
                                <p class="panierPrix"><?= number_format($ligne['prix_actuel'], 2, ',', ' ') ?> € l'unité</p>
                            </div>

                            <div class="panierQuantite">
                                <form action="panier.php" method="post">
                                    <input type="hidden" name="action" value="moins">
                                    <input type="hidden" name="id" value="<?= $ligne['id_produit'] ?>">
                                    <button type="submit" class="panierPas" title="Retirer un exemplaire">&minus;</button>
                                </form>

                                <span class="panierNombre"><?= $ligne['quantite'] ?></span>

                                <form action="panier.php" method="post">
                                    <input type="hidden" name="action" value="plus">
                                    <input type="hidden" name="id" value="<?= $ligne['id_produit'] ?>">
                                    <button type="submit" class="panierPas" title="Ajouter un exemplaire" <?= $ligne['quantite'] >= $ligne['stock_dispo'] ? "disabled" : "" ?>>+</button>
                                </form>
                            </div>

                            <p class="panierSousTotal"><?= number_format($ligne['sous_total'], 2, ',', ' ') ?> €</p>

                            <form action="panier.php" method="post">
                                <input type="hidden" name="action" value="supprimer">
                                <input type="hidden" name="id" value="<?= $ligne['id_produit'] ?>">
                                <button type="submit" class="panierSupprimer" title="Retirer du panier">&times;</button>
                            </form>
                        </div>
                    <?php } ?>

                    <form action="panier.php" method="post" class="panierVider">
                        <input type="hidden" name="action" value="vider">
                        <button type="submit">Vider le panier</button>
                    </form>
                </div>

                <div class="panierResume">
                    <h2>Récapitulatif</h2>
                    <div class="panierResumeLigne">
                        <span>Sous-total</span>
                        <span><?= number_format($total, 2, ',', ' ') ?> €</span>
                    </div>
                    <div class="panierResumeLigne">
                        <span>Livraison</span>
                        <span>Offerte</span>
                    </div>
                    <div class="panierResumeLigne panierResumeTotal">
                        <span>Total</span>
                        <span><?= number_format($total, 2, ',', ' ') ?> €</span>
                    </div>

                    <?php if (!empty($_SESSION['user_name'])) { ?>
                        <form action="panier.php" method="post">
                            <input type="hidden" name="action" value="commander">
                            <button type="submit" class="btn btnOrange">Commander</button>
                        </form>
                    <?php } else { ?>
                        <a href="connexion.php?retour=panier" class="btn btnNoir">Se connecter pour commander</a>
                        <p class="panierNote">Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </section>

    <?php include 'config/footer.php'; ?>
</body>

</html>
