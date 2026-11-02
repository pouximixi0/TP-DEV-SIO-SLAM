<?php
session_start();
require_once('config/db.php');

if (empty($_GET['id'])) {
    header("Location: articles.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header("Location: articles.php?status=introuvable");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce <?= htmlspecialchars($article['nom']) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/article.css">
</head>

<body>
    <?php include 'config/header.php'; ?>

    <section class="article">
        <div class="articleContenu">
            <div class="articleImage">
                <img src="img/articles/<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['nom']) ?>">
            </div>

            <div class="articleInfos">
                <a href="articles.php" class="retour">&larr; Retour aux articles</a>
                <h1 class="carteTitre"><?= htmlspecialchars($article['nom']) ?></h1>
                <p class="cartePrix"><?= number_format($article['prix_actuel'], 2, ',', ' ') ?> €</p>
                <p class="carteTexte"><?= htmlspecialchars($article['description']) ?></p>

                <?php if ($article['stock_dispo'] > 0) { ?>
                    <p class="carteStock">Stock disponible : <?= $article['stock_dispo'] ?></p>

                    <form action="panier.php" method="post" class="ajoutPanier">
                        <input type="hidden" name="action" value="ajouter">
                        <input type="hidden" name="id" value="<?= $article['id_produit'] ?>">
                        <label for="quantite">Quantité</label>
                        <input type="number" id="quantite" name="quantite" value="1" min="1" max="<?= $article['stock_dispo'] ?>">
                        <button type="submit" class="btn btnOrange">Ajouter au panier</button>
                    </form>
                <?php } else { ?>
                    <p class="carteStock rupture">Rupture de stock</p>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include 'config/footer.php'; ?>
</body>

</html>
