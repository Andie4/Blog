<?php 
session_start();
if (isset($_SESSION['login'])) {
    try {
        $db= new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
        
        // Récupérer l'ID de l'utilisateur
        $requete = "SELECT id_utilisateur FROM utilisateur WHERE login = :login";
        $stmt = $db->prepare($requete);
        $stmt->bindParam(':login', $_SESSION['login'], PDO::PARAM_STR);
        $stmt->execute();
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        
// test des 2 possibilits soit c'est le profil d'un utilisateur lambda soit c'est mon profil 

        // reconnaisance de mon id en tant qu'admin
        if ($utilisateur && $utilisateur['id_utilisateur'] == 18) {
            $_SESSION['is_admin'] = true;
            // redirection vers ma page dédié si mon id est reconnu
            header('Location: profil_admin.php');
            exit();

        //utilisateur lambda
        } else {
            $_SESSION['is_admin'] = false;
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

// JE SOUHAITE SUPPRIMER CETTE PARTIE CAR JE L'AI AU DEBUT DE MON CODE MAIS SANS ÇA IL NE FONCTIONNE PAS
$db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete = "SELECT * FROM utilisateur WHERE login = :login";
$stmt = $db->prepare($requete);
$stmt->bindParam(':login', $_SESSION["login"], PDO::PARAM_STR);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🎮</a>
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


    
<?php
if (!isset($_SESSION['login'])) {
    echo"<p>Veuillez vous connecter pour avoir accès a cette page</p>";
}

if ($utilisateur) {
    echo "<h1>🔆 BONJOUR et bienvenue {$utilisateur['prenom']} 🔆</h1><br> 
    <ul>
        <li>Login : {$utilisateur['login']}</li>
        <li>Prénom : {$utilisateur['prenom']}</li>
        <li>Photo : <img class='img-fluid' src='photo/{$utilisateur['photo']}' alt='photo de profil'></li>
    </ul>";

    // ajout de photo
    echo "<form action='profil.php' method='post' enctype='multipart/form-data'>
        <input type='file' name='photo' required>
        <input type='submit' name='upload' value='Changer la photo de profil'>
    </form>";
            echo "<a href='deconect.php'>Déconnexion</a>";
}

//modification de la pdp fait avec ce tuto : https://www.youtube.com/watch?v=lDZLZAdr1is
    if (isset($_FILES["photo"]) && !empty($_FILES['photo']['name'])) {
        $tailleMax = 2097152;
        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
    
        if ($_FILES['photo']['size'] <= $tailleMax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
            if (in_array($extensionUpload, $extensionsValides)) {
                $chemin = "photo/" . $_SESSION['login'] . "." . $extensionUpload;
                $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
    
                if ($resultat) {
                    $updatephoto = $db->prepare('UPDATE utilisateur SET photo = :photo WHERE login = :login');
                    $updatephoto->execute(array(
                        'photo' => $_SESSION['login'] . "." . $extensionUpload,
                        'login' => $_SESSION['login']
                    ));
                    
                    // redirection et mise à jour de la page profil 
                    header('Location: profil.php');
                    exit();
                } else {
                    echo "Erreur durant l'importation de la photo.";
                }
            } else {
                echo "Votre photo doit être au format jpg, jpeg, gif ou png.";
            }
        } else {
            echo "Votre photo ne doit pas dépasser 2Mo.";
        }
        echo "<a href='deconect.php>Déconnexion</a>";

    }

?>
    
</body>
</html>



    

