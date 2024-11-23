<?php
session_start();
// var_dump($_SESSION);
if (!isset($_SESSION["login"])){
    // Redirection si l'utilisateur n'est pas connecté
    header("Location: saisie_login.php");
    exit();
}

if(!empty($_POST['texte']) && !empty($_POST['billet_id'])) {
    try {
        $db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

        // récupérer l'id de l'utilisateur logué
        $requeteUtilisateur = "SELECT id_utilisateur FROM utilisateur WHERE login = :login";
        $stmtUtilisateur = $db->prepare($requeteUtilisateur);
        $stmtUtilisateur->bindParam(':login', $_SESSION["login"], PDO::PARAM_STR);
        $stmtUtilisateur->execute();
        $utilisateur = $stmtUtilisateur->fetch(PDO::FETCH_ASSOC);

        // je précise que utilisateur_id est la clé étrangère dans la table commentaire et la clé primaire sous le nom id_utilisateur dans la table utilisateur
        if ($utilisateur){
            $utilisateur_id = $utilisateur['id_utilisateur'];
            $billet_id = $_POST['billet_id'];
            $texte = $_POST['texte'];
            $date = date('Y-m-d H:i:s');
            
        // ajouter un commentaire 
        $requeteCommentaire="INSERT INTO commentaire (texte, date, utilisateur_id, billet_id) VALUES (:texte, :date, :utilisateur_id, :billet_id)";
        $stmtCommentaire=$db->prepare($requeteCommentaire);
        $stmtCommentaire->execute(['texte' => $texte, 'utilisateur_id' => $utilisateur_id, 'billet_id' => $billet_id, 'date' => $date]);

        

// redirection et mise à jour de la page profil 
header("Location: affiche_post.php?id=" . $billet_id);
exit();
    }else{
        echo "Utilisateur non trouvé.";
    }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "erreur avec des données";
}
?>