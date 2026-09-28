<?php
session_start();
include "db.php";
$action = "";
$id = "";
$quantite = 1;

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}
if (isset($_POST['action'])) {
    $action = $_POST['action'];
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['quantite'])) {
    $quantite = (int) $_POST['quantite'];
}

if ($action == "ajouter" || $action == "modifier") {
    $stmt = $conn->prepare("SELECT stock_dispo FROM produit WHERE id_produit = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $produit = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$produit) {
        header("Location: /html/panier.php?status=introuvable");
        exit();
    }

    if ($action == "ajouter" && isset($_SESSION['panier'][$id])) {
        $quantite = $quantite + $_SESSION['panier'][$id];
    }

    if ($quantite > $produit['stock_dispo']) {
        $quantite = $produit['stock_dispo'];
    }

    if ($quantite <= 0) {
        unset($_SESSION['panier'][$id]);
    } else {
        $_SESSION['panier'][$id] = $quantite;
    }
}

if ($action == "supprimer") {
    unset($_SESSION['panier'][$id]);
}

if ($action == "vider") {
    $_SESSION['panier'] = [];
}

if ($action == "commander") {
    if (empty($_SESSION['user_name'])) {
        header("Location: /html/connexion.php?retour=panier");
        exit();
    }
    $_SESSION['panier'] = [];
    header("Location: /html/panier.php?status=commande");
    exit();
}

$conn->close();

if ($action == "ajouter") {
    header("Location: /html/panier.php?status=ajoute");
} else {
    header("Location: /html/panier.php");
}
exit();
