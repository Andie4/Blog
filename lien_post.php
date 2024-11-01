<?php
session_start();

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// pour afficher les billets
$requete="SELECT * FROM billet ORDER BY date DESC LIMIT 3";
$stmt=$db->query($requete);
$result=$stmt->fetchall(PDO::FETCH_ASSOC);

// pour afficher l'auteur
$auteur='SELECT prenom FROM utilisateur WHERE id_utilisateur = 4';
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
			<h1 class="col p-8">Focus Actus </h1>
		</div>   
        <p>Le blog d'Andie est un blog d'actualités sur les nouvelles technologies, les jeux vidéos et les séries TV.</p>

	</div>
    <h2 class="col p-8">Les derniers articles</h2>
<?php
    foreach ($result as $billet){
        
        

    echo "<div class='container overflow-hidden text-center'>
					<div class='row p-5'>
						<div class='col-6'>
								<h3 class='p-4'>{$billet["titre"]}</h3>
								<p>{$billet["texte"]} </p>
								<p>{$billet["date"]} </p>
								<p>Autrice : {$utilisateur["prenom"]} </p>
								<a href='affiche_post.php?id={$billet['id_nom']} '> Voir le post </a>
						</div>

						<div class='col-6'>
							<img class='img-fluid' src='./meduses.avif' >
						</div>
					
				</div>";
    }

?>



</body>
</html>