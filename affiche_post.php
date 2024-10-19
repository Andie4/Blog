<?php
session_start();

{ 

$db=new PDO('mysql:host=localhost;dbname=Blog;port=8889;charset=utf8', 'root', 'root');
$requete="SELECT * FROM billet";
$stmt=$db->query($requete);


$result=$stmt->fetchall(PDO::FETCH_ASSOC);
}

?>


   


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Les derniers posts</title>
</head>
<body>
	<h1>Les derniers posts</h1>
	<?php
		foreach ($result as $billet){
			echo "<h3>{$billet["titre"]}</h3>{$billet["texte"]}<br>{$billet["date"]}<br><br><br><br>";
		}
	?>
</body>
</html>