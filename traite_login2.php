<?php
session_start();
$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$db->query('SET NAMES utf8');
$requete="SELECT * FROM utilisateur WHERE login=:login";
$stmt=$db->prepare($requete);
$stmt->bindParam(':login',$_GET["login"], PDO::PARAM_STR);
$stmt->execute();
$hash=password_hash("mot_de_passe", PASSWORD_DEFAULT);



if ($utilisateur=$stmt->fetch(PDO::FETCH_ASSOC)){
	if ($utilisateur["mot_de_passe"]==$_GET["mot_de_passe"]) {
	echo "vous etes connecté";
	$_SESSION["login"]=$utilisateur["login"];
	echo "<a href=\"affiche_utilisateurs.php\">afficher les utilisateurs</a>";
	} 
		if (password_verify('mot_de_passe', $hash)) {
			echo "mot de passe valide
			<a href=\"lien_post.php\">afficher les posts</a>";

			

		}
		else {
			echo "mot de passe incorrect";
			}
		}
else {
	echo "login incorrect";
	}
?>


