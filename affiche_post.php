<?php
session_start();

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

//pour afficher les billets individuellment au clique voir le post 
$requete="SELECT * FROM billet WHERE billet.id_nom = :id_nom";
$stmt=$db->prepare($requete);
$result=$stmt->fetchall(PDO::FETCH_ASSOC);

// pour affivcher les commentaires
$commentaire="SELECT * FROM commentaire WHERE commentaire.id_billet = :id_billet";
$commentaireStmt=$db->prepare($commentaire);
$commentaireResult=$commentaireStmt->fetchall(PDO::FETCH_ASSOC);

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
	<div class="container text-center ">
		<div class="row"">
			<h1 class="col p-8"></h1>
		</div>
	</div>
	
	
	
	
	<?php
		// afficher les détails du post + les commentaires ( pas tous les posts les uns en dessous des autres)
		foreach ($result as $billet){
			echo "<div class='container overflow-hidden text-center'>
					<div class='row p-5'>
						<div class='col-6'>
								<h3 class='p-4'>{$billet["titre"]}</h3>
								<p>{$billet["texte"]} </p>
								<p>{$billet["date_creation"]} </p>
								<p>{$billet["id_utilisateur"]} </p>
						</div>
					</div>
				</div>";
		}
		

		
	?>

<!-- lien page id=$post[id] -->

</body>
</html>