<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['user_name'])) {
    header("Location: /index.php");
    exit();
}

$status = "";
if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

$retour = "";
if (isset($_GET['retour'])) {
    $retour = $_GET['retour'];
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce connexion</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/compte.css">
</head>

<body>
    <?php include "../components/navbar.php"; ?>

    <section class="compte">
        <div class="compteFormulaire">
            <h1>Connexion</h1>
            <div class="trait"></div>

            <?php if ($status == "inscrit") { ?>
                <p class="message messageOk">Votre compte a bien été créé, vous pouvez vous connecter.</p>
            <?php } elseif ($status == "error") { ?>
                <p class="message messageErreur">Email ou mot de passe incorrect.</p>
            <?php } elseif ($status == "vide") { ?>
                <p class="message messageErreur">Merci de remplir tous les champs.</p>
            <?php } elseif ($retour == "panier") { ?>
                <p class="message messageErreur">Vous devez être connecté pour passer commande.</p>
            <?php } ?>

            <form action="/include/traitement_connexion.php" method="post" class="formulaire">
                <input type="hidden" name="retour" value="<?= htmlspecialchars($retour) ?>">

                <div class="champ">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="vous@exemple.fr" required>
                </div>

                <div class="champ">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" required>
                </div>

                <button type="submit" class="btn btnNoir">Se connecter</button>
            </form>

            <p class="compteLien">Pas encore de compte ? <a href="/html/inscription.php">Inscrivez-vous</a></p>
        </div>
    </section>

    <?php include '../components/footer.php'; ?>
</body>

</html>
