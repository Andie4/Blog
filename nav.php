<?php
// nav des utilisateurs logués
if (isset($_SESSION['id_utilisateur'])) {
    echo '<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="archive.php">Archive</a></li>
                <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
            </ul>
        </div>
    </div>
</nav>';
}

// nav des utilisateurs non logués
if (!isset($_SESSION['id_utilisateur'])) {
    echo '<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="saisie_login.php">Connexion</a></li>
                <li class="nav-item"><a class="nav-link" href="saisie_inscription.php">Inscription</a></li>
                <li class="nav-item"><a class="nav-link" href="archive.php">Archive</a></li>
            </ul>
        </div>
    </div>
</nav>';
}

?>