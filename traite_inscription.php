<?php
session_start();
$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM users WHERE login=:login";
$stmt=$db->prepare($requete);
$stmt->bindParam(':login',$_GET["login"], PDO::PARAM_STR);
$stmt->execute();

// le login est déjà utilisé
    if ($utilisateur=$stmt->fetch(PDO::FETCH_ASSOC)){
        header('Location:saisie_inscription.php?err=login');
}
// ajout d'un nouvel utilisateur à la base de données
    else {
        $requete= "INSERT INTO utilisateur (prenom, login, mot_de_passe) VALUES (:prenom,:login,:mot_de_passe)";
        $stmt= $db->prepare($requete);
        $stmt->bindValue(':prenom',$_GET["prenom"] , PDO::PARAM_STR);
        $stmt->bindValue(':login',$_GET["login"] , PDO::PARAM_STR); 
        $hash= password_hash($_GET["mot_de_passe"],PASSWORD_DEFAULT);
        $stmt->bindValue(':mot_de_passe',$hash , PDO::PARAM_STR); 

}   // Vérification de l'ajout de l'utilisateur à la  base de données
    if ($stmt->execute()) {
    echo "Utilisateur ajouté avec succès. <br>
    <a href=\"lien_post.php\">Voir les posts</a>"; 
}   else {
    echo "Erreur lors de l'ajout de l'utilisateur.";
}

?>