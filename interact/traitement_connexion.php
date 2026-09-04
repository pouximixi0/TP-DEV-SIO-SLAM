<?php
include("db.php");
if (isset($_POST["nom"]) && isset($_POST["inputPassword"])) {
    $nom = $_POST["nom"];
    $password = hash('sha256', $_POST["inputPassword"]);

    $stmt = $conn->prepare("SELECT * FROM Client WHERE nom = ? AND mot_de_passe = ?");
    $stmt->bind_param("ss", $nom, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        session_start();
        $_SESSION["user_name"] = $row["nom"];
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../html/Connexion.php?status=error");
        exit();
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../html/Connexion.php?status=error");
    exit();
}
?>