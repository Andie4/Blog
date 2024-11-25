<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// pour afficher les billets individuellment
$requete = "SELECT billet.titre, billet.date, billet.texte, billet.photo, utilisateur.login AS auteur FROM billet JOIN utilisateur ON billet.id_nom = utilisateur.id_utilisateur WHERE billet.id_nom = :id_nom";
$stmt = $db->prepare($requete);
$stmt->execute(['id_nom' => $_GET['id']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// pour afficher l'auteur
$auteur='SELECT prenom FROM utilisateur WHERE id_utilisateur = 18';
$auteurStmt=$db->query($auteur);
$utilisateur=$auteurStmt->fetch(PDO::FETCH_ASSOC);

// source de l'utilisation du JOIN : https://colibri.unistra.fr/fr/course/practice/notions-de-base-en-sql/regrouper-avec-group-by/57


// pour afficher les commentaires
$commentaire = "SELECT commentaire.date, commentaire.texte, utilisateur.login AS auteur FROM commentaire JOIN utilisateur ON commentaire.utilisateur_id = utilisateur.id_utilisateur WHERE commentaire.billet_id = :id";
$stmtCommentaire = $db->prepare($commentaire);
$stmtCommentaire->execute(['id' => $_GET['id']]);
$resultCommentaire = $stmtCommentaire->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Les derniers posts</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>
<body>


<nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">
    <p class="">🎮</p>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
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

	<div class="container text-center ">
		<div class="row">
			<h1 class="col p-8"></h1>
		</div>
	</div>

	
	
	<?php
	// Afficher les détails du post
	if (empty($result)) {
    echo "Aucun billet trouvé avec cet ID.";
} else {
    foreach ($result as $billet) {
        echo "<div class='container overflow-hidden  .contour'>
                  <div class='row p-5'>
                      <div class='col-6'>
                          <h3 class='p-4 bruno-ace-regular'>{$billet['titre']}</h3>
                          <p>{$billet['texte']}</p>
                          <p>{$billet['date']}</p>
                          <p>Autrice : {$utilisateur['prenom']}</p>
                      </div>
                      <div class='col-6'>
                        <img src='photo/{$billet['photo']}' class='imgb'>
						          </div>
                  </div>
              </div>";
    }
}


	// Création de la section commentaire(s)
if (!empty($resultCommentaire)) {
    echo "<div class='container overflow-hidden text-center'>
            <div class='row p-5'>
                <div class='col-6'>
                    <h3 class='p-4'>Commentaires :</h3>
                    <button id='toggle_comments_button' onclick='toggle_comments();'>Afficher les commentaires</button>
                    
                    <!-- Section des commentaires, initialement cachée -->
                    <div id='comments_section' style='display: none;'>";
                    
                    foreach ($resultCommentaire as $commentaire) {
                        echo "<div class='commentaire-item'>
                                <p> <span style='font-weight: bold'> {$commentaire['auteur']} </span>  à écrit :  <span style='font-weight:bold '> {$commentaire['texte']} </span> <br> (le {$commentaire['date']})</p>
                              </div>
                              <hr>";
                    }

    echo "    </div>
                </div>
            </div>
        </div>";
} else {
    echo "<p>Aucun commentaire pour ce billet.</p>";
}

// Ajouter un commentaire 
if (isset($_SESSION['login']) && isset($_GET['id'])) {
    echo "<form action='traite_commentaire.php' method='post' id='formulaire'>
            <textarea name='texte' cols='30' rows='10' placeholder='Écrivez votre texte' onKeyPress='if(event.keyCode == 13) validerForm();'></textarea>
            <input type='hidden' name='billet_id' value='{$_GET['id']}'>
            <input type='submit' value='Ajouter'>
          </form>";
} else {
    echo "<p>Connectez-vous pour ajouter un commentaire</p>";
}
    

?>



<?php
// affichage du footer
include("footer.php");
?>

<!-- lien page id=$post[id] -->
<script src='script.js'></script>



</body>
</html>