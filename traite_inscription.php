<?php
session_start();
$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM users WHERE login=:login";
$stmt=$db->prepare($requete);
$stmt->bindParam(':login',$_GET["login"], PDO::PARAM_STR);
$stmt->execute();
var_dump


    if ($utilisateur=$stmt->fetch(PDO::FETCH_ASSOC)){
        header('Location:saisie_inscription.php?err=login');
}
    else {
        $requete= "INSERT INTO utilisateur VALUES (:prenom,:login,:mot_de_passe)";
        $stmt= $db->prepare($requete);
        $stmt->bindValue(':prenom',$_GET["prenom"] , PDO::PARAM_STR);
        $stmt->bindValue(':login',$_GET["login"] , PDO::PARAM_STR); 
        $hash= password_hash($_GET["mot_de_passe"],PASSWORD_DEFAULT);
        $stmt->bindValue(':mot_de_passe',$hash , PDO::PARAM_STR); 
        $stmt->execute();
}

?>