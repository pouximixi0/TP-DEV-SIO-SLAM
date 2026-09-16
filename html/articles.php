<?php
include '../include/db.php';

if ($conn->connect_error) {
    $Error = $conn->connect_error;
} else {
    $conn->set_charset('utf8mb4');

    $sql = "SELECT p.id_produit, p.nom, p.description, p.prix_actuel, p.stock_dispo, p.image_url FROM Produit p ORDER BY p.id_produit DESC";

    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
        $result->free();
    } else {
        $Error = 'Erreur lors du chargement des articles.';
    }

    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce Articles</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/articles.css">
</head>

<body>
    <?php include '../components/navbar.php'; ?>
    <section class="articles-section">
        <?php if (empty($articles)) {
            echo '<div class="col-12"><p class="text-center">Aucun article disponible pour le moment.</p></div>';
        } else {
            echo '<div class="container">';
            foreach ($articles as $article) {
                echo '
                    <div class="card">
                        <img src="/img/article/' . htmlspecialchars($article['image_url']) . '" alt="' . htmlspecialchars($article['nom']) . '">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($article['nom']) . '</h5>
                            <p class="card-text">' . htmlspecialchars($article['description']) . '</p>
                            <p class="card-price">' . number_format($article['prix_actuel'], 2, ',', ' ') . ' €</p>
                            <a href="article_detail.php?id=' . $article['id_produit'] . '" class="btn btn-primary">Voir Détails</a>
                        </div>
                    </div>';
            }
            echo '</div>';
        }
        ?>
    </section>
</body>

</html>