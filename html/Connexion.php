<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../bootstrap-5.3.8/dist/js/bootstrap.js"></script>
</head>

<body>
    <?php include '../component/navbar.php'; ?>
    <p>Veuillez remplir les champs ci-dessous pour vous connecter à notre site.</p>
    <div class="container">
        <div class="row gy-4 gy-md-5 gy-lg-0 align-items-md-center">
            <div class="col-12 col-lg-6">
                <div class="border overflow-hidden">
                    <form action="/interact/traitement_connexion.php" method="post">
                        <div class="row gy-4 gy-xl-5 p-4 p-xl-5">
                            <div class="col-12">
                                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword" class="form-label">Mot de passe <span
                                        class="text-danger">*</span></label>
                                
                                <input type="password" class="form-control" id="inputPassword" name="inputPassword" value="" required>
                            </div>
                            
                            <!--
                            <div class="col-md-6">
                                <label for="inputCity" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                            <div class="col-md-4">
                                <label for="inputState" class="form-label">Région</label>
                                <select id="inputState" class="form-select">
                                    <option selected>Choisir...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="inputZip" class="form-label">Postale</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>
                            -->

                            <?php
                                if (isset($_GET['status']) && $_GET['status'] === 'success') {
                                    echo '<div class="alert alert-success" role="alert">Inscription réussie !</div>';
                                } elseif (isset($_GET['status']) && $_GET['status'] === 'error') {
                                    echo '<div class="alert alert-danger" role="alert">Erreur lors de la connexion.</div>';
                                }
                            ?>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" type="submit">S'inscrire</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
<?php include '../component/footer.php'; ?>

</body>

</html>