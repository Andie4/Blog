<?php
session_start();
$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
session_start();
$requete="SELECT * FROM utilisateur WHERE login=:login";


$stmt=$db->prepare($requete);
$stmt->bindParam(':login',$_POST["login"], PDO::PARAM_STR);
$stmt->execute();
$hash=password_hash("mot_de_passe", PASSWORD_DEFAULT);

var_dump($_POST)
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
                <li><a class="navbar-brand" href="index.php">Accueil</a></li>
                <li><a class="navbar-brand" href="saisie_login.php">Connexion</a></li>
                <li><a class="navbar-brand" href="saisie_inscription.php">Inscription</a></li>
                <li><a class="navbar-brand" href="profil.php">Profil</a></li>
            </ul> 
        </div>
    </div>
</nav>

<?php
// Vérification du mot de passe
if ($utilisateur = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (password_verify($_POST["mot_de_passe"], $utilisateur["mot_de_passe"])) {
        $_SESSION["login"] = $utilisateur["login"];
        $_SESSION["id_utilisateur"] = $utilisateur["id_utilisateur"];
        header("Location: profil.php");
        
        exit();
    } else {
        echo  "mot de passe incorrect";
    	}
} else {
	echo "login incorrect";
    exit();
}

//vérification de la connexion avant d'avoir accès à la page profil
if (!isset($_SESSION["login"])) {
    header("Location: saisie_login.php"); 
    exit();
}

?>
</body>
</html>
