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

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🎮</a>
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
 


	<?php	if (isset($_SESSION["login"])){ 
		header('location: profil.php');
		echo "Bonjour {$_SESSION["login"]}<BR>"; 
		exit();
	}
	?>
<!-- 	
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
		</FORM> -->

	
<form class="formConnexion mx-auto col-5">

<div class='titreFormConnexion text-center'>
			<h1 class='col bruno-ace-regular'>Connexion</h1>
	</div>


  <div class="mb-3 mt-300 col-6 mx-auto mt-200">
    <label for="exemplelogin" class="form-label">Login</label>
    <input type="login" class="form-control" id="exemplelogin" aria-describedby="login">
  </div>
  <div class="mb-3 col-6 mx-auto mt-80">
    <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3 col-6 mx-auto d-grid mt-80">
  	<button type="submit" class="btn btn-primary">Connexion</button>
  </div>
</form>



</body>
</html>