<?php
if (!empty($_POST['email']) && !empty($_POST['inputPassword4'])) {
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['inputPassword4']);
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $nom = $_POST['nom'];
    $conn = new mysqli('localhost', 'root', '', 'ecommerce');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        $status = "DB_error";
    }

    $stmt = $conn->prepare("INSERT INTO client (email, password, nom, address, telephone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $password, $nom, $address, $telephone);


    if ($stmt->execute()) {
        $status = "success";
    } else {
        $status = "error";
    }

    $stmt->close();
    $conn->close();

    header('Location: /html/Inscription.php?status=' . $status);

}

?>