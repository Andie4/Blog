<?php
session_start();
if (isset($_SESSION["login"]))
{ 

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM utilisateur";
$stmt=$db->query($requete);


$result=$stmt->fetchall(PDO::FETCH_ASSOC);
}

// ajouter un commentaire 

?>