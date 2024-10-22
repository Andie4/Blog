<?php
session_start();

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// pour afficher les commentaires
$commentaire="SELECT * FROM commentaire";
$commentaire_stmt=$db->query($commentaire);
$result=$commentaire_stmt->fetchall(PDO::FETCH_ASSOC);
$auteurCommentaire = "SELECT prenom FROM utilisteur WHERE id_utilisateur = :id_utilisateur";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiche commentaire</title>
</head>
<body>
<?php
		foreach ($result as $commentaire){
			
			echo "<div class='container overflow-hidden text-center'>
					<div class='row p-5'>
						<div class='col-6'>
								<h3 class='p-4'>Commentaires :</h3>
								<p>{$commentaire["date"]} </p>
                                <p>{$commentaire["utilisateur_id"]} </p>
								<p>{$commentaire["texte"]} </p>
								<p>{$commentaire["billet_id"]} </p>					
						</div>
						
				</div>";
		}
?>

</body>
</html>

