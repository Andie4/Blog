<?php 
session_start();
?>

<?php
$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM utilisateur";
$stmt=$db->query($requete);

$result=$stmt->fetchall(PDO::FETCH_ASSOC);
?>

<form method="post" action="post">
        <input type="file" name="photo">
        <input type="submit" name="upload">
        </form>



    <?php


         echo '<img  src="./pdp.webp" width="150" />';
    ?>


    </form>
</div>

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

