<?php
session_start();
$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM users WHERE login=:login";
$stmt=$db->prepare($requete);
$stmt->bindParam(':login',$_GET["login"], PDO::PARAM_STR);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kdam+Thmor+Pro&family=Luckiest+Guy&display=swap" rel="stylesheet">
</head>
<body>




<?php include("nav.php"); ?>

</body>
</html>

<?php

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
    echo "<h1 class='titre text-center bruno-ace-regular'>Bonne nouvelle!  <br> Votre compte à été crée avec succès. </h1> <br>
    <a class='btn' href=\"index.php\">Voir les posts</a>"; 
}   else {
    echo "Erreur lors de l'ajout de l'utilisateur.";
}

?>

