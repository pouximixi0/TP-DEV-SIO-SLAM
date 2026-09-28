<?php
$erreurs = [];
$envoye = false;
$nom = "";
$email = "";
$sujet = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $sujet = $_POST["sujet"];
    $message = trim($_POST["message"]);

    if ($nom == "") {
        $erreurs[] = "Le nom est obligatoire.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }
    if ($sujet == "") {
        $erreurs[] = "Merci de choisir un sujet.";
    }
    if (strlen($message) < 10) {
        $erreurs[] = "Le message est trop court (10 caractères minimum).";
    }

    if (count($erreurs) == 0) {
        $envoye = true;
        $nom = "";
        $email = "";
        $sujet = "";
        $message = "";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bleach-commerce contact</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/contact.css">
</head>

<body>
    <?php include "../components/navbar.php"; ?>

    <section class="pageTitre">
        <h1>Contactez-nous</h1>
        <div class="trait"></div>
        <p>Une question sur un article ou une commande ? Écrivez-nous, on répond nous-mêmes à chaque message.</p>
    </section>

    <section class="contact">
        <div class="contactInfos">
            <div class="contactBloc">
                <h3>Par mail</h3>
                <a href="mailto:contact@bleach-commerce.fr">contact@bleach-commerce.fr</a>
            </div>
            <img src="/img/fond_QSN.jpg" alt="Bleach">
        </div>

        <div class="contactFormulaire">
            <?php if ($envoye) { ?>
                <p class="message messageOk">Merci ! Votre message a bien été envoyé, on revient vers vous rapidement.</p>
            <?php } ?>

            <?php foreach ($erreurs as $erreur) { ?>
                <p class="message messageErreur"><?= $erreur ?></p>
            <?php } ?>

            <form action="contact.php" method="post" class="formulaire">
                <div class="champsLigne">
                    <div class="champ">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" required>
                    </div>

                    <div class="champ">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                    </div>
                </div>

                <div class="champ">
                    <label for="sujet">Sujet</label>
                    <select id="sujet" name="sujet" required>
                        <option value="">Choisir...</option>
                        <option value="commande" <?= $sujet == "commande" ? "selected" : "" ?>>Une commande</option>
                        <option value="article" <?= $sujet == "article" ? "selected" : "" ?>>Un article du catalogue</option>
                        <option value="autre" <?= $sujet == "autre" ? "selected" : "" ?>>Autre</option>
                    </select>
                </div>

                <div class="champ">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" required><?= htmlspecialchars($message) ?></textarea>
                </div>

                <button type="submit" class="btn btnOrange">Envoyer le message</button>
            </form>
        </div>
    </section>

    <?php include '../components/footer.php'; ?>
</body>

</html>
