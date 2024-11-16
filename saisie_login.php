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
	<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🎮</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="lien_post.php">Accueil</a>
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
 


	<div class='container text-center '>
		<div class='row'>
			<h1 class='col p-8'>Connexion</h1>
		</div>
	</div>

	<?php	if (isset($_SESSION["login"])){ 
		header('location: profil.php');
		echo "Bonjour {$_SESSION["login"]}<BR>"; 
		exit();
	}
	?>
	
		<FORM action="traite_login2.php" method="post">
			
			<p>Saisissez votre login :<INPUT type=text name="login"> 
			<?php 
		if (isset($_GET["err"]) && $_GET["err"]=="login") { echo "ATTENTION MAUVAIS LOGIN";}
			?>
			<BR>

			<p>et votre passwd :<input type="password" name="mot_de_passe">
				<?php 
		if (isset($_GET["err"]) && $_GET["err"]=="mdp") { echo "ATTENTION MAUVAIS MOT DE PASSE";}
			?>
			<br><input type=submit value= "OK">
		</FORM>

	
</body>
</html>