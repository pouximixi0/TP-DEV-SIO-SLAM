<?php
include '../include/db.php';
if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Produit WHERE id_produit = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $article = $result->fetch_assoc();
        if (!$article) {
            echo "Article non trouvé.";
            exit;
        }
    } else {
        echo "Erreur lors du chargement de l'article.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce Article</title>
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <?php include '../components/navbar.php'; ?>

    <section class="article-detail">
        <div class="container">
            <div class="product-image-wrapper">
                <img src="/img/article/<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['nom']) ?>">
            </div>

            <div class="product-info">
                <h1 class="card-title"><?= htmlspecialchars($article['nom']) ?></h1>
                <p class="card-price"><?= number_format($article['prix_actuel'], 2, ',', ' ') ?> €</p>
                <p class="card-text"><?= htmlspecialchars($article['description']) ?></p>
                <p class="card-stock">Stock disponible : <?= htmlspecialchars($article['stock_dispo']) ?></p>
            </div>
        </div>
    </section>


</body>

</html>