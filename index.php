<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach Commerce</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/navbar.php'; ?>

    <section class="hero">
        <div class="heroTexte">
            <h1>Bienvenue sur Bleach Commerce</h1>
            <div class="trait"></div>
            <p>Figurines, vêtements, livres, posters, cartes et tous autres accessoires.</p>
            <a href="html/articles.php" class="btn btnOrange">Voir les articles</a>
        </div>

        <div class="heroImages">
            <img src="img/1.png" alt="Figurines" class="visible">
            <img src="img/2.jpg" alt="Éditions limitées">
            <img src="img/3.webp" alt="Nouveautés">
        </div>
    </section>

    <section class="presentation">
        <img src="img/QSN.jpg" alt="Alexis et Juventrain">

        <div class="presentationTexte">
            <h2>Deux étudiants de BTS SIO, fans de Bleach</h2>
            <p>Le catalogue est monté à la main, article par article. Les commandes sont préparées et expédiées par nous, sous 48 h.</p>
            <a href="html/contact.php" class="btn btnContour">Nous contacter</a>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>
    <script src="js/index.js"></script>

</body>

</html>