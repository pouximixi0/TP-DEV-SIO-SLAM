<?php 
$name = $_POST['fullname'];
echo "Le nom est : " . $name . "<br>";
$email = $_POST['email'];       
echo "Le mail est : " . $email . "<br>";
$phone = $_POST['phone'];
echo "Le téléphone est : " . $phone . "<br>";
$subject = $_POST['subject'];
echo "L'objet est : " . $subject . "<br>";
$message = $_POST['message'];
echo "Le message est : " . $message . "<br>";
?>