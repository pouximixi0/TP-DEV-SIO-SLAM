<?php
session_start();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="/img/logo.png" alt="Logo" class="logo">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/html/articles.php">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/html/QSN.php">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/html/Contact.php">Contact</a>
                    </li>
                    <?php
                    if (isset($_SESSION["user_name"])) {
                        echo '<li class="nav-item"><a class="nav-link" href="/html/profile.php">Profil</a></li>';
                        echo '<li class="nav-item"><a class="nav-link btn btn-outline-light ms-2 px-3" href="/interact/logout.php">Déconnexion</a></li>';
                    } else {
                        echo '<li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-2 px-3" href="/html/Inscription.php">Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-2 px-3" href="/html/Connexion.php">Connexion</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>