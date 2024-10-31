<?php 
session_start();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
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
                </ul> 
            </div>
           
        </div>
        
    </nav>
 


	<div class='container text-center '>
		<div class='row'>
			<h1 class='col p-8'>Connexion</h1>
		</div>
	</div>

	<?php	if (isset($_SESSION["login"]))
	{ 
	echo "Bonjour {$_SESSION["login"]}<BR>"; 
	}
	?>
	
		<FORM action="traite_login2.php" method="post"=>
			
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