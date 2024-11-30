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
    
    try {
        $stmt = $db->prepare("UPDATE utilisateur SET prenom = :prenom, login = :login WHERE id_utilisateur = :id");
        $stmt->execute([':prenom' => $prenom, ':login' => $login, ':id' => $id_utilisateur]);
        header("Location: gestion_utilisateur.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la modification de l'utilisateur : " . $e->getMessage();
    }
}

// ---------------------------------- AFFICHAGE DES UTILISATEURS ----------------------------------
try {
    $sql = "SELECT id_utilisateur, prenom, login FROM utilisateur";
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

<?php include("nav.php"); ?>


<div class="container mt-5">
    <h1 class="text-center">Gestion des utilisateurs</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Login</th>
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
        <td>
            <!-- Bouton Modifier -->
            <button class='btn btn-warning btnModifier' data-bs-toggle='modal' data-bs-target='#modifierModal{$utilisateur['id_utilisateur']}'>Modifier</button>
            <!-- Lien Supprimer -->
            <a href='?action=supprimer&id={$utilisateur['id_utilisateur']}' class='btn btn-danger btnSupprimer'>Supprimer</a>
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
                        <button type='submit' class='btn btn-primary'>Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>";
}

?>

    </table>
</div>

<?php
// affichage du footer
include("footer.php");
?>

<!-- utilisation de chatgpt pour l'ajout de js avec la bibliotheque bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!-- J'ai essayé d'ajouter la fonction modifier la photo de profil mais ça ne fonctionnais pas pour certaine images sans savoir pourquoi . J'ai doc mis cette fonctionnalité de coté . -->