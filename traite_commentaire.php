<?php
session_start();
// var_dump($_SESSION);
if (isset($_SESSION["login"]))

{ 

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM utilisateur";
$stmt=$db->query($requete);

$commentaire="SELECT * FROM commentaire WHERE utilisateur_id=:utilisateur_id";
$stmtCommentaire=$db->prepare($commentaire);
$stmtCommentaire->bindParam(':utilisateur_id',$_SESSION["utilisateur_id"], PDO::PARAM_STR);
$stmtCommentaire->execute();

$resultCommentaire=$stmtCommentaire->fetchall(PDO::FETCH_ASSOC);
}

// ajouter un commentaire 
if( ){
    $requete= "INSERT INTO commentaire (texte, date, utilisateur_id, billet_id) VALUES (:texte, :date, :utilisateur_id, :billet_id)";
    $stmtBillet= $db->prepare($requete);
    $stmtBillet->bindValue(':texte',$_POST["texte"] , PDO::PARAM_STR);
    $stmtBillet->bindValue(':date',$_POST["date"] , PDO::PARAM_STR); 
    $stmtBillet->bindValue(':utilisateur_id',$_POST["utilisateur_id"] , PDO::PARAM_STR); 
    $stmtBillet->bindValue(':billet_id',$_POST["billet_id"] , PDO::PARAM_STR); 
}

// redirection et mise à jour de la page profil 
header('Location: affiche_post.php');
exit();




?>