<?php 
session_start();
?>

<?php
$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM utilisateur";
$stmt=$db->query($requete);

$result=$stmt->fetchall(PDO::FETCH_ASSOC);
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
    echo 'Bonjour !';
    ?>
   

    <form method="post" action="post">
        <input type="file" name="photo">
        <input type="submit" name="upload">
    </form>

    <?php
         echo '<img  src="./pdp.webp" width="150" />';
    ?>
    
</body>
</html>



    

<!-- 
    inscription
    connection
    voir tout les billets les 3 dernier billet 
    detail du billet + commentaires


    sur une meme page index il faut reussir 
    2 pages a faire en tout  pour le front office

    saisir un nouveau billet 

    POUR LES ADMIN :
    - saisir un nouveau billet 
    - 
-->

