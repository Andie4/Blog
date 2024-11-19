<?php
session_start();
$db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// --------------------------------------MODIFICATION---------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    
        $id_billet = $_POST['id_billet'];  
        $titre = $_POST['titre'];
        $texte = $_POST['texte'];

        // limite du texte parce que au delà de 255 le billet ne s'ajoute pas et je ne sais pas encore comment aller au delà de 255 dans la bdd (dans ma base de données -->VACHAR(255))
        if (strlen($texte) > 255) {
            echo "Le texte dépasse la limite de 255 caractères.";
            exit();
        }

        // Met à jour le billet dans la BDD
        $requete = $db->prepare("UPDATE billet SET titre = :titre, texte = :texte WHERE id_nom = :id");
        $requete->execute([
            ':titre' => $titre,':texte' => $texte,':id' => $id_billet
        ]);

        header("Location: gestion_billet.php");
        exit();

   
}

// --------------------------------------SUPPRESSION---------------------------------------------------
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    try {
        // récupère l'ID du billet à supprimer
        $id_billet = $_GET['id'];
        $requete = $db->prepare("DELETE FROM billet WHERE id_nom = :id");
        $requete->execute([':id' => $id_billet]);




        header("Location: gestion_billet.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du billet : " . $e->getMessage();
    }
}



// --------------------------------------AJOUTER---------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    try {
        $titre = $_POST['titre'];
        $texte = $_POST['texte'];

        // limite du texte
        if (strlen($texte) > 255) {
            echo "Le texte dépasse la limite de 255 caractères.";
            exit();
        }

        // AJOUT du billet dans la BDD
        $requete = $db->prepare("INSERT INTO billet (titre, texte, date, auteur) VALUES (:titre, :texte, NOW(), :auteur)");
        $requete->execute([':titre' => $titre, ':texte' => $texte, ':auteur' => 4  
        ]);

        header("Location: gestion_billet.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout du billet : " . $e->getMessage();
    }
}

// Afficher tous les billets
$billets = $db->query("SELECT * FROM billet")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Billets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1 class="text-center">Gestion des billets</h1>

    <!-- Ajouter un billet -->
    <h2>Ajouter un nouveau billet</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="ajouter">
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="texte" class="form-label">Contenu</label>
            <textarea name="texte" id="texte" class="form-control" rows="5" maxlength="255" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <hr>

    <!-- Liste des billets -->
    <h2>Liste des billets</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Texte</th>
                <th>Date</th>
                <th>Auteur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php 
        foreach ($billets as $billet) {
            echo "
            <tr>
                <td>{$billet['id_nom']}</td>
                <td>{$billet['titre']}</td>
                <td>{$billet['texte']}</td>
                <td>{$billet['date']}</td>
                <td>{$billet['auteur']}</td>
                <td>
                    <!-- Lien de modification -->
                    <a href='#' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modifierModal{$billet['id_nom']}'>Modifier</a>
                    <!-- Lien de suppression -->
                    <a href='gestion_billet.php?action=supprimer&id={$billet['id_nom']}' class='btn btn-danger'>Supprimer</a>
                </td>
            </tr>";

            // Formulaire modal de modification
            echo "
            <div class='modal fade' id='modifierModal{$billet['id_nom']}' tabindex='-1' aria-labelledby='modifierModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='modifierModalLabel'>Modifier le billet</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <form method='POST' action=''>
                                <input type='hidden' name='action' value='modifier'>
                                <input type='hidden' name='id_billet' value='{$billet['id_nom']}'>
                                <div class='mb-3'>
                                    <label for='titre' class='form-label'>Titre</label>
                                    <input type='text' name='titre' id='titre' class='form-control' value='{$billet['titre']}' required>
                                </div>
                                <div class='mb-3'>
                                    <label for='texte' class='form-label'>Contenu</label>
                                    <textarea name='texte' id='texte' class='form-control' rows='5' maxlength='255' required>{$billet['texte']}</textarea>
                                </div>
                                <button type='submit' class='btn btn-primary'>Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";
        }
        ?>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
