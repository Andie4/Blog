<?php 
session_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kdam+Thmor+Pro&family=Luckiest+Guy&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">

</head>
<body>

<!-- image de fond accueil -->
<img src="./photo/spider-man2.jpeg" alt="" class="imgfond">

<?php include("nav.php"); ?>

 


	<?php	if (isset($_SESSION["login"])){ 
		header('location: profil.php');
		echo "Bonjour {$_SESSION["login"]}<BR>"; 
		exit();
	}
	?>
	
		<form action="traite_login2.php" method="post" class="formConnexion mx-auto col-5">

      <div class='titreFormConnexion text-center'>
        <h1 class='col bruno-ace-regular'>Connexion</h1>
      </div>
			<div class=" mb-3 mt-300 col-6 mx-auto mt-200">
        <label class="form-label d-grid">Login :<INPUT type=text name="login" class="form-control col-8"></label><br>
			<?php 
		if (isset($_GET["err"]) && $_GET["err"]=="login") { echo "ATTENTION MAUVAIS LOGIN";}
			?>
			

			<label class="form-label d-grid">Mot de passe :<input type="password" name="mot_de_passe" class="form-control"></label>
				<?php 
		if (isset($_GET["err"]) && $_GET["err"]=="mdp") { echo "ATTENTION MAUVAIS MOT DE PASSE";}
			?>
      </div>
			

<div class="mb-3 col-6 mx-auto d-grid mt-200">
  	<button type="submit" class="btn btn-primary">Connexion</button>
  </div>
</form>


<?php
// affichage du footer
include("footer.php");
?>

</body>
</html>