<?php
session_start();
require_once('config/db.php');

if (!empty($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nom"]) || empty($_POST["email"]) || empty($_POST["mdp"]) || empty($_POST["mdp2"])) {
        header("Location: inscription.php?status=vide");
        exit();
    }

    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $telephone = trim($_POST["telephone"]);
    $mdp = $_POST["mdp"];
    $mdp2 = $_POST["mdp2"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: inscription.php?status=email");
        exit();
    }

    if (strlen($mdp) < 6) {
        header("Location: inscription.php?status=mdp");
        exit();
    }

    if ($mdp != $mdp2) {
        header("Location: inscription.php?status=confirm");
        exit();
    }

    $stmt = $pdo->prepare("SELECT id_client FROM client WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        header("Location: inscription.php?status=existe");
        exit();
    }

    $hash = hash('sha256', $mdp);

    $stmt = $pdo->prepare("INSERT INTO client (email, mot_de_passe, nom, telephone) VALUES (?, ?, ?, ?)");
    $ok = $stmt->execute([$email, $hash, $nom, $telephone]);

    if (!$ok) {
        header("Location: inscription.php?status=error");
        exit();
    }

    $sujet = "Bienvenue sur Bleach Commerce";

    $contenu = "Bonjour " . $nom . ",\r\n\r\n";
    $contenu .= "Votre compte Bleach Commerce vient d'être créé, merci de votre confiance !\r\n\r\n";
    $contenu .= "Bleach Commerce est une boutique tenue par deux étudiants de BTS SIO, fans de l'univers de Bleach.\r\n";
    $contenu .= "Avec votre compte, vous pouvez dès maintenant :\r\n";
    $contenu .= "- parcourir le catalogue (figurines, vêtements, posters, cartes et accessoires) ;\r\n";
    $contenu .= "- consulter la fiche détaillée de chaque article et son stock disponible ;\r\n";
    $contenu .= "- ajouter les articles de votre choix à votre panier, dans la quantité souhaitée ;\r\n";
    $contenu .= "- modifier ou vider votre panier à tout moment ;\r\n";
    $contenu .= "- passer commande une fois connecté à votre compte.\r\n\r\n";
    $contenu .= "Vos identifiants de connexion :\r\n";
    $contenu .= "Identifiant : " . $email . "\r\n";
    $contenu .= "Mot de passe : le même que celui saisi lors de l'inscription.\r\n\r\n";
    $contenu .= "Une question sur un article ou une commande ? Répondez à ce mail ou passez par la page Contact du site, on répond nous-mêmes à chaque message sous 48 h.\r\n\r\n";
    $contenu .= "À bientôt sur Bleach Commerce,\r\n";
    $contenu .= "Alexis & Juventin";

    $entetes = "From: contact@bleach-commerce.fr\r\n";
    $entetes .= "Content-Type: text/plain; charset=UTF-8";

    mail($email, $sujet, $contenu, $entetes);

    header("Location: connexion.php?status=inscrit");
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/compte.css">
</head>

<body>
    <?php include "config/header.php"; ?>

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

            <form action="inscription.php" method="post" class="formulaire">
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

            <p class="compteLien">Déjà inscrit ? <a href="connexion.php">Connectez-vous</a></p>
        </div>
    </section>

    <?php include 'config/footer.php'; ?>
</body>

</html>
