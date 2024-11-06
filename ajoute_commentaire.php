<?php
session_start();
if (isset($_SESSION["login"]))
{ 

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM utilisateur";
$stmt=$db->query($requete);

$result=$stmt->fetchall(PDO::FETCH_ASSOC);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h3>Ajouter un commentaire</h3>
<?php 
if (isset($_SESSION["login"])){
    echo"
        <form action='traite_commentaire.php' method='post'>
        <textarea name='texte' id='' cols='30' rows='10' placeholder='Écrivez votre texte'></textarea>
        <input type='hidden' name='billet_id' value='$id_billet'>
        <input type='submit' value='Ajouter'>
        </form>";
} else{
    echo "connectez vous pour ajouter un commentaire";
}
?>
    
</body>
</html>