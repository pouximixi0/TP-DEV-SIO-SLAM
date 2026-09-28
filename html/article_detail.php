<?php
include '../include/db.php';

if (empty($_GET['id'])) {
    header("Location: articles.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM produit WHERE id_produit = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$article) {
    echo "Article non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce <?= htmlspecialchars($article['nom']) ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/article_detail.css">
</head>

<body>
    <?php include '../components/navbar.php'; ?>

    <section class="article-detail">
        <div class="container">
            <div class="product-image-wrapper">
                <img src="/img/article/<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['nom']) ?>">
            </div>

            <div class="product-info">
                <a href="articles.php" class="retour">&larr; Retour aux articles</a>
                <h1 class="card-title"><?= htmlspecialchars($article['nom']) ?></h1>
                <p class="card-price"><?= number_format($article['prix_actuel'], 2, ',', ' ') ?> €</p>
                <p class="card-text"><?= htmlspecialchars($article['description']) ?></p>

                <?php if ($article['stock_dispo'] > 0) { ?>
                    <p class="card-stock">Stock disponible : <?= $article['stock_dispo'] ?></p>

                    <form action="/include/panier_action.php" method="post" class="ajoutPanier">
                        <input type="hidden" name="action" value="ajouter">
                        <input type="hidden" name="id" value="<?= $article['id_produit'] ?>">
                        <label for="quantite">Quantité</label>
                        <input type="number" id="quantite" name="quantite" value="1" min="1" max="<?= $article['stock_dispo'] ?>">
                        <button type="submit" class="btn btnOrange">Ajouter au panier</button>
                    </form>
                <?php } else { ?>
                    <p class="card-stock rupture">Rupture de stock</p>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include '../components/footer.php'; ?>
</body>

</html>
