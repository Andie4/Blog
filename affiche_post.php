<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// //pour afficher les billets individuellment
$requete = "SELECT * FROM billet WHERE billet.id_nom = :id_nom";
$stmt = $db->prepare($requete);
$stmt->execute(['id_nom' => $_GET['id']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
	// Afficher les détails du post
	foreach ($result as $billet) {
		echo "<div class='container overflow-hidden text-center'>
				<div class='row p-5'>
					<div class='col-6'>
						<h3 class='p-4'>{$billet['titre']}</h3>
						<p>{$billet['texte']}</p>
						<p>{$billet['date']}</p>
						<p>{$billet['auteur']}</p>
					</div>
				</div>
			</div>";
	}
	
	?>

<!-- lien page id=$post[id] -->

</body>
</html>