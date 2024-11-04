<?php
session_start();
// var_dump($_SESSION);
if (isset($_SESSION["login"]))
{ 

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM utilisateur";
$stmt=$db->query($requete);

$commentaire="SELECT * FROM commentaire WHERE utilisateur_id=:utilisateur_id";


$result=$stmt->fetchall(PDO::FETCH_ASSOC);
}

// ajouter un commentaire 
if(utilisateur_id == $_SESSION["utilisateur_id"]){
    $requete= "INSERT INTO commentaire (texte, date, utilisateur_id, billet_id) VALUES (:texte, :date, :utilisateur_id, :billet_id)";
    $stmt= $db->prepare($requete);
    $stmt->bindValue(':texte',$_POST["texte"] , PDO::PARAM_STR);
    $stmt->bindValue(':date',$_POST["date"] , PDO::PARAM_STR); 
    $stmt->bindValue(':utilisateur_id',$_POST["utilisateur_id"] , PDO::PARAM_STR); 
    $stmt->bindValue(':billet_id',$_POST["billet_id"] , PDO::PARAM_STR); 
}




?>