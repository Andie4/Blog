<?php
session_start();

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// pour afficher les billets
$requete="SELECT * FROM billet";
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
  <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kdam+Thmor+Pro&family=Luckiest+Guy&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">

</head>
<body>
<?php include("nav.php"); ?>



<!-- image de fond accueil -->
<img src="photo/accueil.jpg" alt="" class="imgfond">

	<div class="container text-center ">
		<div class="row">
			<h1 class="col p-8 bruno-ace-regular titre">Tous mes articles :</h1>
		</div>   
	</div>

<?php
    foreach ($result as $billet){
        // echo "<ul>
        //         <li><a href='affiche_post.php?'>{$billet["titre"]}</a></li>
        //     </ul>";
        

    echo "<div class='container overflow-hidden text- .contour'>
					<div class='row center p-5'>
          <div class='col-2'></div>
						<div class='col-5 post'>
								<h3 class='p-4 bruno-ace-regular'>{$billet["titre"]}</h3>
								<p>{$billet["texte"]} </p>
								<p>{$billet["date"]} </p>
								<p>Autrice : {$utilisateur["prenom"]} </p>
								<a href='affiche_post.php?id={$billet['id_nom']}' class='btn'> Voir le post </a>
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