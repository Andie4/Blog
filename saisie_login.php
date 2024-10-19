<?php 
session_start();
?>

<html>
<head>
	<meta charset="UTF-8">
</head>

<body>
<?php	if (isset($_SESSION["login"]))
{ 
echo "Bonjour {$_SESSION["login"]}<BR>"; 
}


?>
	<FORM action="traite_login2.php">
		
		<p>Saisissez votre login :<INPUT type=text name="login"> 
		<?php 
	if (isset($_GET["err"]) && $_GET["err"]=="login") { echo "ATTENTION MAUVAIS LOGIN";}
		?>
		<BR>

		 <p>et votre passwd :<input type="password" name="mot_de_passe">
		 	<?php 
	if (isset($_GET["err"]) && $_GET["err"]=="mdp") { echo "ATTENTION MAUVAIS MOT DE PASSE";}
		?>
		<br><input type=submit value= "OK">
	</FORM>

<?php
// echo password_hash("toto", PASSWORD_DEFAULT);
?>
</BODY>

