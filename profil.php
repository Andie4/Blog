<?php 
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: saisie_login.php"); // pour aller à la connexion si non connecté
    exit();
}


$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

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
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-teriary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul>
                    <li><a class="navbar-brand" href="lien_post.php">Accueil</a></li>
                    <li><a class="navbar-brand" href="saisie_login.php">Connexion</a></li>
                    <li><a class="navbar-brand" href="saisie_inscription.php">Inscription</a></li>
					<li><a class="navbar-brand" href="profil.php">Profil</a></li>
                </ul> 
            </div>
           
        </div>
        
    </nav>


    
<?php
if ($utilisateur) {
    echo "<h1>🔆 BONJOUR et bienvenue {$utilisateur['prenom']} 🔆</h1><br> 
    <ul>
        <li>Login : {$utilisateur['login']}</li>
        <li>Prénom : {$utilisateur['prenom']}</li>
        <li>Photo : <img src='photo/{$utilisateur['photo']}' alt='photo de profil'></li>
    </ul>";

    // Formulaire d'upload de photo
    echo "<form action='traite_login2.php' method='post' enctype='multipart/form-data'>
        <input type='file' name='photo' required>
        <input type='submit' name='upload' value='Changer la photo de profil'>
    </form>";
}

//modification de la pdp fait avec un tuto : https://www.youtube.com/watch?v=lDZLZAdr1is
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
    } else {
        echo "Aucune photo sélectionnée.";
    }
?>
<a href="deconect.php">Déconnexion</a>
    
</body>
</html>



    

