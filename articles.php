<?php
session_start();
require_once('config/db.php');

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$sql = "SELECT p.id_produit, p.nom, p.description, p.prix_actuel, p.stock_dispo, p.image_url FROM produit p ORDER BY p.id_produit DESC";
$articles = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce Articles</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/articles.css">
</head>

<body>
    <?php include 'config/header.php'; ?>

    <section class="articlesSection">
        <?php if ($status == "ajoute") { ?>
            <p class="message messageOk">L'article a bien été ajouté à votre panier. <a href="panier.php">Voir mon panier</a></p>
        <?php } elseif ($status == "introuvable") { ?>
            <p class="message messageErreur">Cet article n'existe plus.</p>
        <?php } ?>

        <?php if (count($articles) == 0) { ?>
            <p class="aucunArticle">Aucun article disponible pour le moment.</p>
        <?php } else { ?>
            <div class="grilleArticles">
                <?php foreach ($articles as $article) { ?>
                    <div class="carte">
                        <img src="img/articles/<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['nom']) ?>">
                        <div class="carteCorps">
                            <h5 class="carteTitre"><?= htmlspecialchars($article['nom']) ?></h5>
                            <p class="carteTexte"><?= htmlspecialchars($article['description']) ?></p>
                            <p class="cartePrix"><?= number_format($article['prix_actuel'], 2, ',', ' ') ?> €</p>
                            <a href="article.php?id=<?= $article['id_produit'] ?>" class="btnDetail">Voir Détails</a>

                            <?php if ($article['stock_dispo'] > 0) { ?>
                                <form action="panier.php" method="post" class="ajoutPanier">
                                    <input type="hidden" name="action" value="ajouter">
                                    <input type="hidden" name="id" value="<?= $article['id_produit'] ?>">
                                    <input type="hidden" name="retour" value="articles">
                                    <label for="qte<?= $article['id_produit'] ?>">Qté</label>
                                    <input type="number" id="qte<?= $article['id_produit'] ?>" name="quantite" value="1" min="1" max="<?= $article['stock_dispo'] ?>">
                                    <button type="submit" class="btn btnOrange">Ajouter au panier</button>
                                </form>
                            <?php } else { ?>
                                <p class="carteStock rupture">Rupture de stock</p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </section>

    <?php include 'config/footer.php'; ?>
</body>

</html>
