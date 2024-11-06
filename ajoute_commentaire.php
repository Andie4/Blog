<?php
session_start();
if (isset($_SESSION["login"]))
{ 

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM utilisateur";
$stmt=$db->query($requete);

$result=$stmt->fetchall(PDO::FETCH_ASSOC);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h3>Ajouter un commentaire</h3>
<form action="traite_commentaire" method="post">
    <textarea name="" id="texte" cols="30" rows="10"></textarea>
    <p placeholder="Écrivez votre texte" required></p>
    <input type="submit" value="Ajouter">

</form>
    
</body>
</html>