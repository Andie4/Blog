<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// pour afficher les billets individuellment
$requete = "SELECT titre, date, texte, photo FROM billet WHERE id_nom = :id_nom";
$stmt = $db->prepare($requete);
$stmt->execute(['id_nom' => $_GET['id']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// pour afficher les commentaires
$commentaire = "SELECT commentaire.date, commentaire.texte, utilisateur.login AS auteur FROM commentaire JOIN utilisateur ON commentaire.utilisateur_id = utilisateur.id_utilisateur WHERE commentaire.billet_id = :id";
$stmtCommentaire = $db->prepare($commentaire);
$stmtCommentaire->execute(['id' => $_GET['id']]);
$resultCommentaire = $stmtCommentaire->fetchAll(PDO::FETCH_ASSOC);

// pour afficher l'auteur
$auteur='SELECT prenom FROM utilisateur WHERE id_utilisateur = 18';
$auteurStmt=$db->query($auteur);
$utilisateur=$auteurStmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le blog d'Andréa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kdam+Thmor+Pro&family=Luckiest+Guy&display=swap" rel="stylesheet">

</head>
<body>
<?php include("nav.php"); ?>



<?php
          // Afficher les détails du post
if (empty($result)) {
    echo "<p>Aucun billet trouvé avec cet ID.</p>";
} else {
    foreach ($result as $billet) {
        echo "<div class='container overflow-hidden contour m-auto'>
                <div class='row p-5'>
                    <div class='col-8'>
                        <h3 class='p-4 bruno-ace-regular bruno-ace-regular'>{$billet['titre']}</h3>
                        <p>{$billet['texte']}</p>
                        <p>Publié le : {$billet['date']}</p>
                        <p>Autrice : {$utilisateur["prenom"]} </p>
                    </div>
                    <div class='col-4'>
                        <img src='photo/{$billet['photo']}' class='imgb'>
                    </div>
                </div>
              </div>";
    }
}

// Création de la section commentaire(s)
if (!empty($resultCommentaire)) {
    echo "<div class='container overflow-hidden text-center detailsPost'>
            <div class='row p-5'>
                    <h3 class='p-4'>Commentaires :</h3>
                    <button class='btnAfficherCommentaires m-auto' id='toggle_comments_button' onclick='toggle_comments();'>Afficher les commentaires</button>
                    <div id='comments_section' style='display: none;'>";
    foreach ($resultCommentaire as $commentaire) {
        echo "<div class='commentaire-item'>
                <p><strong>{$commentaire['auteur']}</strong> a écrit : <strong>{$commentaire['texte']}</strong> <br> (le {$commentaire['date']})</p>
              </div>
              <hr>";
    }
    echo "</div></div></div></div>";
} else {
    echo "<p>Aucun commentaire pour ce billet.</p>";
}

// Formulaire pour ajouter un commentaire
if (isset($_SESSION['login']) && isset($_GET['id'])) {
    echo "<div class='card shadow-sm'>
    <div class='card-body col-6 m-auto'>
        <h4 class='card-title whiteText'>Ajouter un commentaire</h4>
        <form action='traite_commentaire.php' method='post'>
            <div class='mb-3'>
                <textarea name='texte' class='form-control ' rows='4' placeholder='Écrivez ici'></textarea>
            </div>
            <input type='hidden' name='billet_id' value='{$_GET['id']}'>
            <button type='submit' class='btn btn-success'>Publier</button>
        </form>
    </div>
</div>";
} else {
    echo "<p>Connectez-vous pour ajouter un commentaire</p>";
}
?>

<?php include("footer.php"); ?>
<script src="script.js"></script>
</body>
</html>