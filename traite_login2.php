<?php
session_start();
$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$db->query('SET NAMES utf8');
$requete="SELECT * FROM utilisateur WHERE login=:login";
$stmt=$db->prepare($requete);
$stmt->bindParam(':login',$_GET["login"], PDO::PARAM_STR);
$stmt->execute();


if ($utilisateur=$stmt->fetch(PDO::FETCH_ASSOC)){
	if ($utilisateur["mot_de_passe"]==$_GET["mot_de_passe"]) {
	echo "vous etes connecté";
	$_SESSION["login"]=$utilisateur["login"];
	echo "<a href=\"affiche_utilisateurs.php\">afficher les utilisateurs</a>";
	} 
	else {
		echo "mot de passe incorrect";
		}
	}
else {
	echo "login incorrect";
	}
?>


