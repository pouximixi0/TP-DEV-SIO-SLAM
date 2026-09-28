<?php
session_start();
include "db.php";

if (empty($_POST["nom"]) || empty($_POST["email"]) || empty($_POST["mdp"]) || empty($_POST["mdp2"])) {
    header("Location: /html/inscription.php?status=vide");
    exit();
}

$nom = trim($_POST["nom"]);
$email = trim($_POST["email"]);
$telephone = trim($_POST["telephone"]);
$mdp = $_POST["mdp"];
$mdp2 = $_POST["mdp2"];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: /html/inscription.php?status=email");
    exit();
}

if (strlen($mdp) < 6) {
    header("Location: /html/inscription.php?status=mdp");
    exit();
}

if ($mdp != $mdp2) {
    header("Location: /html/inscription.php?status=confirm");
    exit();
}

$stmt = $conn->prepare("SELECT id_client FROM client WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: /html/inscription.php?status=existe");
    exit();
}
$stmt->close();

$hash = hash('sha256', $mdp);

$stmt = $conn->prepare("INSERT INTO client (email, mot_de_passe, nom, telephone) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $email, $hash, $nom, $telephone);

if ($stmt->execute()) {
    $status = "inscrit";
} else {
    $status = "error";
}

$stmt->close();
$conn->close();

if ($status == "inscrit") {
    header("Location: /html/connexion.php?status=inscrit");
} else {
    header("Location: /html/inscription.php?status=error");
}
exit();
