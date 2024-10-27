<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// pour afficher les billets individuellment
$requete = "SELECT billet.titre, billet.date, billet.texte, utilisateur.login AS auteur FROM billet JOIN utilisateur ON billet.id_nom = utilisateur.id_utilisateur WHERE billet.id_nom = :id_nom";
$stmt = $db->prepare($requete);
$stmt->execute(['id_nom' => $_GET['id']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// source de l'utilisation du JOIN : https://colibri.unistra.fr/fr/course/practice/notions-de-base-en-sql/regrouper-avec-group-by/57


// pour afficher les commentaires
$commentaire = "SELECT commentaire.date, commentaire.texte, utilisateur.login AS auteur FROM commentaire JOIN utilisateur ON commentaire.utilisateur_id = utilisateur.id_utilisateur WHERE commentaire.billet_id = :id_billet";
$stmtCommentaire = $db->prepare($commentaire);
$stmtCommentaire->execute(['id_billet' => $_GET['id']]);
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


<nav class="navbar navbar-expand-lg bg-body-teriary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul>
                    <li><a class="navbar-brand" href="lien_post.php">Accueil</a></li>
                    <li><a class="navbar-brand" href="saisie_login.php">Connexion</a></li>
                    <li><a class="navbar-brand" href="saisie_inscription.php">Inscription</a></li>
					<li><a class="navbar-brand" href="profil.php">Profil</a></li>
					<li><a class="navbar-brand" href="archive.php">Archive</a></li>
                </ul> 
            </div>
           
        </div>
        
    </nav>

	<div class="container text-center ">
		<div class="row"">
			<h1 class="col p-8"></h1>
		</div>
	</div>

	
	
	
	
	
	<?php
	// Afficher les détails du post
	foreach ($result as $billet) {
		echo "<div class='container overflow-hidden text-center .contour'>
				<div class='row p-5'>
					<div class='col-6'>
						<h3 class='p-4'>{$billet['titre']}</h3>
						<p>{$billet['texte']}</p>
						<p>{$billet['date']}</p>
						<p>Auteur : Andréa </p>
						
					</div>
				</div>
			</div>";
	}
// problème pour m'afficher en auteur sur tout les posts

	// Afficher les commentaires
	foreach ($resultCommentaire as $commentaire) {
		echo "<div class='container overflow-hidden text-center'>
				<div class='row p-5'>
					<div class='col-6'>
						<h3 class='p-4'>Commentaires :</h3>
						<button type='button' onclick='toggle_text(this);'>Afficher le commentaire</button>
						<span class='commentaire' style='display:none;'>
							<p>{$commentaire['date']}</p>
							<p>{$commentaire['auteur']}</p>
							<p>{$commentaire['texte']}</p>
						</span>
					</div>
				</div>
			</div>";
	}

	
	?>

<!-- lien page id=$post[id] -->
<script>
	function toggle_text(button) {
		var span = button.nextElementSibling;
		
		if (span.style.display === "none") {
			span.style.display = "block"; 
			button.textContent = "Cacher le commentaire";

		} else {
			span.style.display = "none"; 
			button.textContent = "Afficher le commentaire"; 
		}
	}

// inspiration pour l'affichage des commentaires : https://openclassrooms.com/forum/sujet/appuyer-sur-un-bouton-pour-afficher-du-texte-21481
</script>



</body>
</html>