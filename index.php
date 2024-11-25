<?php
session_start();

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// pour afficher les billets
$requete="SELECT * FROM billet ORDER BY date DESC LIMIT 3";
$stmt=$db->query($requete);
$result=$stmt->fetchall(PDO::FETCH_ASSOC);

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
	<title>Les derniers posts</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kdam+Thmor+Pro&family=Luckiest+Guy&display=swap" rel="stylesheet">
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

<!-- image de fond accueil -->
<img src="photo/accueil.jpg" alt="" class="imgfond">

	<div class="container text-center ">
		<div class="row">
			<h1 class="col p-8 bruno-ace-regular titre">Blog d'Andréa </h1>
		</div>   
        <p class="mb-5">Vous pourrez trouver sur mon blog mes personnages préférés <br> des différents films spider-man qui sont sortie entre 2001 et 2023.</p>

	</div>
    <h2 class="m-20 col p-6 sous-titre">Les derniers articles</h2>
<?php
    foreach ($result as $billet){
        
        

    echo "<div class='container overflow-hidden'>
					<div class='row p-5 post'>
          <div class='col-2'></div>
						<div class='col-5'>
								<h3 class='mb-5 bruno-ace-regular'>{$billet["titre"]}</h3>
								<p>{$billet["texte"]} </p>
								<p>{$billet["date"]} </p>
								<p>Autrice : {$utilisateur["prenom"]} </p>
								<a href='affiche_post.php?id={$billet['id_nom']} ' class='btn'> Voir le post </a>
						</div>

						<div class='col-5'>
              <img src='photo/{$billet['photo']}' class='imgb'>
						</div>
					
				</div>";
    }

?>


<?php
// affichage du footer
include("footer.php");
?>


</body>
</html>