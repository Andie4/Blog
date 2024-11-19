<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}

// ---------------------------------- SUPPRESSION ----------------------------------
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $id_utilisateur = $_GET['id'];
    try {
        // Vérifier qu'il n'y a pas de dépendances avant la suppression si nécessaire
        $stmt = $db->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id");
        $stmt->execute([':id' => $id_utilisateur]);
        header("Location: gestion_utilisateur.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
    }
}

// ---------------------------------- MODIFICATION ----------------------------------
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $id_utilisateur = $_POST['id_utilisateur'];
    $prenom = $_POST['prenom'];
    $login = $_POST['login'];
    $photo = $_POST['photo'];
    
    try {
        $stmt = $db->prepare("UPDATE utilisateur SET prenom = :prenom, login = :login, photo = :photo WHERE id_utilisateur = :id");
        $stmt->execute([':prenom' => $prenom, ':login' => $login, photo => $photo, ':id' => $id_utilisateur]);
        header("Location: gestion_utilisateur.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la modification de l'utilisateur : " . $e->getMessage();
    }
}

// ---------------------------------- AFFICHAGE DES UTILISATEURS ----------------------------------
try {
    $sql = "SELECT id_utilisateur, prenom, login, photo FROM utilisateur";
    $stmt = $db->query($sql);
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    $utilisateurs = [];
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <p class="navbar-brand">🎮</p>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="lien_post.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="saisie_login.php">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="saisie_inscription.php">Inscription</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="archive.php">Archive</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-disabled="true" href="profil.php">Profil</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Gestion des utilisateurs</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Login</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php 
foreach ($utilisateurs as $utilisateur) {
    echo "
    <tr>
        <td>{$utilisateur['id_utilisateur']}</td>
        <td>{$utilisateur['prenom']}</td>
        <td>{$utilisateur['login']}</td>
        <td><img class='imgProfil' src='photo/{$utilisateur['photo']}' alt='photo de profil'></td>
        <td>
            <!-- Bouton Modifier -->
            <button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modifierModal{$utilisateur['id_utilisateur']}'>Modifier</button>
            <!-- Lien Supprimer -->
            <a href='?action=supprimer&id={$utilisateur['id_utilisateur']}' class='btn btn-danger'>Supprimer</a>
        </td>
    </tr>";

    // Pop-up de modification
    echo "
    <div class='modal fade' id='modifierModal{$utilisateur['id_utilisateur']}' tabindex='-1' aria-labelledby='modifierModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Modifier</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <form method='POST' action=''>
                        <input type='hidden' name='action' value='modifier'>
                        <input type='hidden' name='id_utilisateur' value='{$utilisateur['id_utilisateur']}'>
                        <div class='mb-3'>
                            <label for='prenom' class='form-label'>Prénom</label>
                            <input type='text' name='prenom' class='form-control' value='{$utilisateur['prenom']}' required>
                        </div>
                        <div class='mb-3'>
                            <label for='login' class='form-label'>Login</label>
                            <input type='text' name='login' class='form-control' value='{$utilisateur['login']}' required>
                        </div>
                        <div class='mb-3'>
                            <label for='photo' class='form-label'>Photo</label>
                            <input type='file' name='photo' class='form-control' value='changer la photo de profil' required>
                        </div>
                        <button type='submit' class='btn btn-primary'>Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>";
}

//

//modification de la pdp fait avec ce tuto : https://www.youtube.com/watch?v=lDZLZAdr1is
    if (isset($_FILES["photo"]) ) {
        $tailleMax = 2097152;
        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
    
        if ($_FILES['photo']['size'] <= $tailleMax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
            if (in_array($extensionUpload, $extensionsValides)) {
                $chemin = "photo/" . $_SESSION['login'] . "." . $extensionUpload;
                $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
    
                if ($resultat) {
                    $updatephoto = $db->prepare('UPDATE utilisateur SET photo = :photo WHERE login = :login');
                    $updatephoto->execute(array(
                        'photo' => $_SESSION['login'] . "." . $extensionUpload,
                        'login' => $_SESSION['login']
                    ));
                    
                    // redirection et mise à jour de la page profil 
                    header('Location: profil.php');
                    exit();
                } else {
                    echo "Erreur durant l'importation de la photo.";
                }
            } else {
                echo "Votre photo doit être au format jpg, jpeg, gif ou png.";
            }
        } else {
            echo "Votre photo ne doit pas dépasser 2Mo.";
        }
        echo "<a href='deconect.php>Déconnexion</a>";

    }
    echo 'erreur';
?>

    </table>
</div>

<!-- utilisation de chatgpt pour l'ajout de js avec la bibliotheque bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
