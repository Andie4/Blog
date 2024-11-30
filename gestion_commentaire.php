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
    $id_commentaire = $_GET['id'];
    try {
        $stmt = $db->prepare("DELETE FROM commentaire WHERE id_commentaire = :id");
        $stmt->execute([':id' => $id_commentaire]);
        header("Location: gestion_commentaire.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression du commentaire : " . $e->getMessage();
    }
}

// ---------------------------------- MODIFICATION ----------------------------------
// dans mon code le texte est la seule valeur modifiable. On ne peut pas modifier l'id, la date, l'auteur, et le bilet lier. 
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $id_commentaire = $_POST['id_commentaire'];
    $texte = $_POST['texte'];
    try {
        $stmt = $db->prepare("UPDATE commentaire SET texte = :texte WHERE id_commentaire = :id");
        $stmt->execute([':texte' => $texte, ':id' => $id_commentaire]);
        header("Location: gestion_commentaire.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la modification du commentaire : " . $e->getMessage();
    }
}

// ---------------------------------- AFFICHAGE DES COMMENTAIRES ----------------------------------
try {
    $sql = "SELECT c.id_commentaire, c.texte, c.date, u.login AS auteur, b.titre AS billet_titre FROM commentaire c JOIN utilisateur u ON c.utilisateur_id = u.id_utilisateur JOIN billet b ON c.billet_id = b.id_nom";
    $stmt = $db->query($sql);
    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    $commentaires = [];
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commentaires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("nav.php"); ?>


<div class="container mt-5">
    <h1 class="text-center">Gestion des commentaires</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Texte</th>
                <th>Date</th>
                <th>Auteur</th>
                <th>Billet</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php 
foreach ($commentaires as $commentaire) {
    // tableau des commentaire et les boutons d'actions modification et supprimer 
    echo "
    <tr>
        <td>{$commentaire['id_commentaire']}</td>
        <td>{$commentaire['texte']}</td>
        <td>{$commentaire['date']}</td>
        <td>{$commentaire['auteur']}</td>
        <td>{$commentaire['billet_titre']}</td>
        <td>
            <!-- Bouton Modifier -->
            <button class='btn btn-warning btnModifier' data-bs-toggle='modal' data-bs-target='#modifierModal{$commentaire['id_commentaire']}'>Modifier</button>
            <!-- Lien Supprimer -->
            <a href='?action=supprimer&id={$commentaire['id_commentaire']}' class='btn btn-danger btnSupprimer'>Supprimer</a>
        </td>
    </tr>";

    // pop up de modification
    echo "
    <div class='modal fade' id='modifierModal{$commentaire['id_commentaire']}' tabindex='-1' aria-labelledby='modifierModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Modifier</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <form method='POST' action=''>
                        <input type='hidden' name='action' value='modifier'>
                        <input type='hidden' name='id_commentaire' value='{$commentaire['id_commentaire']}'>
                        <div class='mb-3'>
                            <label for='texte' class='form-label'>commentaire</label>
                            <textarea name='texte' class='form-control' rows='4' required>{$commentaire['texte']}</textarea>
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
