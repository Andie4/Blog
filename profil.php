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
<?php include("nav.php"); ?>

<div class="container mt-50">
  <div class="mb-3 mt-30"></div>
</div>


<div class="container mt-5">   
<?php
if (!isset($_SESSION['login'])) {
    echo"<p class='mb-70 mt-90 text-center''>Veuillez vous connecter pour avoir accès a cette page</p>
     <a href='saisie_login.php'>Connexion</a>";
}

if ($utilisateur) {
    echo "<h1  class='text-center'>🕷️ Bonjour et bienvenue {$utilisateur['prenom']} 🕷️</h1><br> 
    <div class='row mt-4'>
                      <div class='col-md-4 text-center'>
                          <img src='photo/{$utilisateur['photo']}' alt='Photo de profil' class='img-fluid rounded-circle'>
                      </div>
                      <div class='col-md-6'>
                          <ul class='list-group'>
                              <li class='list-group-item'><strong>Login :</strong> {$utilisateur['login']}</li>
                              <li class='list-group-item'><strong>Prénom :</strong> {$utilisateur['prenom']}</li>
                          </ul>
                          <form action='profil.php' method='post' enctype='multipart/form-data' class='mt-3'>
                              <div class='mb-3'>
                                  <input type='file' name='photo' class='form-control' required>
                              </div>
                              <button type='submit' name='upload' class='btn btn-success'>Valider</button>
                          </form>
                      </div>
                      <a href='deconect.php' class='btn btn-danger mt-3 col-md-2'>Déconnexion</a>
                  </div>";
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
</div>
<div class="container mt-50">
    <div class="mb-3 mt-30"></div>
</div>
    
    <?php
// affichage du footer
include("footer.php");
?>
    
</body>
</html>



    

