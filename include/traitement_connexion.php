<?php
session_start();
include "db.php";

if (empty($_POST["email"]) || empty($_POST["mdp"])) {
    header("Location: /html/connexion.php?status=vide");
    exit();
}

$email = trim($_POST["email"]);
$mdp = hash('sha256', $_POST["mdp"]);

$stmt = $conn->prepare("SELECT id_client, nom FROM client WHERE email = ? AND mot_de_passe = ?");
$stmt->bind_param("ss", $email, $mdp);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$client) {
    header("Location: /html/connexion.php?status=error");
    exit();
}

$_SESSION["user_id"] = $client["id_client"];
$_SESSION["user_name"] = $client["nom"];

if (isset($_POST["retour"]) && $_POST["retour"] == "panier") {
    header("Location: /html/panier.php");
} else {
    header("Location: /index.php");
}
exit();
