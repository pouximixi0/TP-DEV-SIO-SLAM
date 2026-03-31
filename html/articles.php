<?php
$conn = new mysqli('localhost', 'root', '', 'ecommerce');
$articles = [];
$dbError = null;

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
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - Bleach Commerce</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <?php include '../component/navbar.php'; ?>    

    <section class="bg-dark text-white py-5">
        <div class="container">
            <h1 class="display-4 text-center">Nos Articles</h1>
            <p class="lead text-center">Découvrez toute notre collection</p>
        </div>
    </section>

    <section id="articles" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nos Articles Populaires</h2>
            <div class="row g-4">

            <?php if (empty($articles)){
                echo '<div class="col-12"><p class="text-center">Aucun article disponible pour le moment.</p></div>';
                }else {
                    foreach ($articles as $article) {
                        echo '
                        <div class="col-md-4">
                            <div class="card h-100">
                                <img src="' . htmlspecialchars($article['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($article['nom']) . '">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">' . htmlspecialchars($article['nom']) . '</h5>
                                    <p class="card-text">' . htmlspecialchars($article['description']) . '</p>
                                    <div class="mt-auto">
                                        <p class="h5 text-primary">' . number_format($article['prix_actuel'], 2, ',', ' ') . ' €</p>
                                        <a href="article_detail.php?id=' . $article['id_produit'] . '" class="btn btn-outline-primary w-100">Voir Détails</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                } 
            ?>
            </div>
        </div>
    </section>

    <?php include '../component/footer.php'; ?>

    <script src="../bootstrap-5.3.8/dist/js/bootstrap.bundle.js"></script>
    <script src="../js/index.js"></script>
</body>

</html>