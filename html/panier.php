<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../include/db.php';

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$lignes = [];
$total = 0;

if (!empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $id => $quantite) {
        $stmt = $conn->prepare("SELECT id_produit, nom, prix_actuel, stock_dispo, image_url FROM produit WHERE id_produit = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $produit = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($produit) {
            $produit['quantite'] = $quantite;
            $produit['sous_total'] = $produit['prix_actuel'] * $quantite;
            $total = $total + $produit['sous_total'];
            $lignes[] = $produit;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce panier</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/panier.css">
</head>

<body>
    <?php include '../components/navbar.php'; ?>

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
            <a href="/html/articles.php" class="btn btnOrange">continuer vos achats</a>
        <?php } elseif ($status == "commande") { ?>
            <p class="message messageOk">Votre commande a bien été enregistrée</p>
        <?php } elseif ($status == "introuvable") { ?>
            <p class="message messageErreur">Cet article n'existe plus.</p>
        <?php } ?>

        <?php if (count($lignes) == 0) { ?>
            <div class="panierVide">
                <h2>Votre panier est vide</h2>
                <p>Faites un tour dans le catalogue, il y a forcément une figurine qui vous attend.</p>
                <a href="/html/articles.php" class="btn btnOrange">Voir les articles</a>
            </div>
        <?php } else { ?>
            <div class="panierContenu">
                <div class="panierLignes">
                    <?php foreach ($lignes as $ligne) { ?>
                        <div class="panierLigne">
                            <a href="article_detail.php?id=<?= $ligne['id_produit'] ?>">
                                <img src="/img/article/<?= htmlspecialchars($ligne['image_url']) ?>" alt="<?= htmlspecialchars($ligne['nom']) ?>">
                            </a>

                            <div class="panierInfos">
                                <a href="article_detail.php?id=<?= $ligne['id_produit'] ?>" class="panierNom"><?= htmlspecialchars($ligne['nom']) ?></a>
                                <p class="panierPrix"><?= number_format($ligne['prix_actuel'], 2, ',', ' ') ?> € l'unité</p>
                            </div>

                            <form action="/include/panier_action.php" method="post" class="panierQuantite">
                                <input type="hidden" name="action" value="modifier">
                                <input type="hidden" name="id" value="<?= $ligne['id_produit'] ?>">
                                <label for="qte<?= $ligne['id_produit'] ?>">Qté</label>
                                <input type="number" id="qte<?= $ligne['id_produit'] ?>" name="quantite" value="<?= $ligne['quantite'] ?>" min="0" max="<?= $ligne['stock_dispo'] ?>">
                                <button type="submit" class="panierMaj">OK</button>
                            </form>

                            <p class="panierSousTotal"><?= number_format($ligne['sous_total'], 2, ',', ' ') ?> €</p>

                            <form action="/include/panier_action.php" method="post">
                                <input type="hidden" name="action" value="supprimer">
                                <input type="hidden" name="id" value="<?= $ligne['id_produit'] ?>">
                                <button type="submit" class="panierSupprimer" title="Retirer du panier">&times;</button>
                            </form>
                        </div>
                    <?php } ?>

                    <form action="/include/panier_action.php" method="post" class="panierVider">
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
                        <form action="/include/panier_action.php" method="post">
                            <input type="hidden" name="action" value="commander">
                            <button type="submit" class="btn btnOrange">Commander</button>
                        </form>
                    <?php } else { ?>
                        <a href="/html/connexion.php?retour=panier" class="btn btnNoir">Se connecter pour commander</a>
                        <p class="panierNote">Pas encore de compte ? <a href="/html/inscription.php">Inscrivez-vous</a></p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </section>

    <?php include '../components/footer.php'; ?>
</body>

</html>