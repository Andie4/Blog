<?php
session_start();
if (isset($_SESSION["login"]))
{ 

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM utilisateur";
$stmt=$db->query($requete);


$result=$stmt->fetchall(PDO::FETCH_ASSOC);
?>
<table border=1>
<tr><th>Id</th><th>Prenom</th><th>Login</th><th>Mdp</th></tr>
<?php
foreach ($result as $utilisateurs){
	echo "<tr><td>{$utilisateurs["id_utilisateur"]}</td><td>{$utilisateurs["prenom"]}</td><td>{$utilisateurs["login"]}</td><td>{$utilisateurs["mot_de_passe"]}</td></tr>";
}
echo "</table>";
echo "<a href=\"deconect.php\">Se déconnecter</a>";
} 
else { echo "Vous n'avez pas le droit de visualiser cette page si vous n'etes pas logué";}
?>