<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach Commerce - Boutique Officielle</title>
    <link rel="stylesheet" href="bootstrap-5.3.8/dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php include 'component/navbar.php'; ?>
    <section id="accueil">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img src="img/1.webp" class="d-block w-100" alt="Bleach">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h1 class="display-4">Bienvenue sur Bleach Commerce</h1>
                        <p class="lead">Vente d'objet bleach</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="img/2.jpg" class="d-block w-100" alt="Collection">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h1 class="display-4">Produits Premium</h1>
                        <p class="lead">Une qualité garantie aute finition</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="img/3.webp" class="d-block w-100" alt="Nouveautés">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h1 class="display-4">Nouveautés 2026</h1>
                        <p class="lead">Les dernières sorties disponibles</p>
                    </div>
                </div>
            </div>
            
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </section>

    <section id="articles" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nos Articles Populaires</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <img src="img/figurine.jpg" class="card-img-top" alt="Figurine Ichigo">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Figurine</h5>
                            <p class="card-text text-muted">Figurine collector</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0 text-primary">39,99€</span>
                                    <button class="btn btn-primary btn-sm">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <img src="img/tshirt.jpg"card-img-top" alt="T-shirt Bleach">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">T-shirt</h5>
                            <p class="card-text text-muted">Haute qualité</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0 text-primary">24,99€</span>
                                    <button class="btn btn-primary btn-sm">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <img src="img/poster.avif" class="card-img-top" alt="Poster Bleach">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Poster HD</h5>
                            <p class="card-text text-muted">Imprimé en haute qualité</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0 text-primary">14,99€</span>
                                    <button class="btn btn-primary btn-sm">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <img src="img/dvd.jpg" class="card-img-top" alt="DVD Integral Bleach">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">DVD Integral</h5>
                            <p class="card-text text-muted">Édition collector</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0 text-primary">214,99€</span>
                                    <button class="btn btn-primary btn-sm">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'component/footer.php'; ?>

    <script src="bootstrap-5.3.8/dist/js/bootstrap.bundle.js"></script>
    <script src="js/index.js"></script>
</body>

</html>