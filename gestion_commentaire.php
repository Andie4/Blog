<?php
session_start();

$db = new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');

// Pour afficher les utilisateurs
$requete = "SELECT * FROM utilisateur";
$stmt = $db->query($requete);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// pour afficher les billets
$requeteBillet="SELECT * FROM billet";
$stmtBillet=$db->query($requeteBillet);
$resultBillet=$stmtBillet->fetchall(PDO::FETCH_ASSOC);
?>