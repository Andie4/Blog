<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// Pour afficher les utilisateurs
$requete = "SELECT * FROM utilisateur";
$stmt = $db->query($requete);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// pour afficher les billets
$requeteBillet="SELECT * FROM billet";
$stmtBillet=$db->prepare($requeteBillet);
$resultBillet=$stmtBillet->fetchall(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🕷️</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="lien_post.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="saisie_login.php">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="saisie_inscription.php">Inscription</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="archive.php">Archive</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-disabled="true" href="profil.php">Profil</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<h1 class="text-center">Espace admin</h1>
<h2 class="p-m-5 ">Utilisateurs</h2>
      <?php 
      echo "<a href='gestion_utilisateur.php'>Modifier/supprimer</a>   <br>
       <br> <br>";
      ?>     
    
<h2>Billets :</h2>  
<?php
  echo "<a href='gestion_billet.php'>Ajouter/Modifier/supprimer</a>   <br> <br> <br>
  ";
  ?>

<h2 class="p-m-5 ">Commentaires</h2>
      <?php 
      echo "<a href='gestion_commentaire.php'>Modifier/supprimer</a>   <br>
       <br> <br>";
      ?>         
<br>
<br>
<a href="deconect.php">Se déconnecter</a>
</body>
</html>


<?php

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Préparer et exécuter la requête de suppression
    $requete = $db->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    if ($requete->execute()) {
        echo "L'utilisateur a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur.";
    }
} 

// pour modifier et supprimer les posts
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Préparer et exécuter la requête de suppression
    $requete = $db->prepare("UPDATE * FROM billet WHERE id_nom =:id_nom ");
    $requete->bindParam(':id', $id, PDO::PARAM_INT);

    if ($requete->execute()) {
        echo "le billet à été modifier";
    } else {
        echo "Erreur modification billet";
    }
} 




// header("Location: profil_admin.php");
// exit();

?>