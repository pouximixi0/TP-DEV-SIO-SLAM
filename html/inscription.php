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
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce inscription</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/compte.css">
</head>

<body>
    <?php include "../components/navbar.php"; ?>

    <section class="compte">
        <div class="compteFormulaire">
            <h1>Inscription</h1>
            <div class="trait"></div>

            <?php if ($status == "vide") { ?>
                <p class="message messageErreur">Merci de remplir tous les champs obligatoires.</p>
            <?php } elseif ($status == "email") { ?>
                <p class="message messageErreur">L'adresse email n'est pas valide.</p>
            <?php } elseif ($status == "existe") { ?>
                <p class="message messageErreur">Un compte existe déjà avec cet email.</p>
            <?php } elseif ($status == "mdp") { ?>
                <p class="message messageErreur">Le mot de passe doit faire au moins 6 caractères.</p>
            <?php } elseif ($status == "confirm") { ?>
                <p class="message messageErreur">Les deux mots de passe ne sont pas identiques.</p>
            <?php } elseif ($status == "error") { ?>
                <p class="message messageErreur">Une erreur est survenue, réessayez plus tard.</p>
            <?php } ?>

            <form action="/include/traitement_inscription.php" method="post" class="formulaire">
                <div class="champ">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <div class="champ">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="champ">
                    <label for="telephone">Téléphone <span class="facultatif">(facultatif)</span></label>
                    <input type="tel" id="telephone" name="telephone" placeholder="06 12 34 56 78">
                </div>

                <div class="champsLigne">
                    <div class="champ">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" id="mdp" name="mdp" minlength="6" required>
                    </div>

                    <div class="champ">
                        <label for="mdp2">Confirmation</label>
                        <input type="password" id="mdp2" name="mdp2" minlength="6" required>
                    </div>
                </div>

                <button type="submit" class="btn btnOrange">Créer mon compte</button>
            </form>

            <p class="compteLien">Déjà inscrit ? <a href="/html/connexion.php">Connectez-vous</a></p>
        </div>
    </section>

    <?php include '../components/footer.php'; ?>
</body>

</html>
