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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
	<div class="container text-center ">
		<div class="row"">
			<h1 class="col p-8">Les derniers posts</h1>
		</div>
	</div>
	
	<?php
		foreach ($result as $billet){
			echo "<div class='container overflow-hidden text-center'>
					<div class='row p-5'>
						<div class='col-6'>
								<h3 class='p-4'>{$billet["titre"]}</h3>
								{$billet["texte"]}<br>
								{$billet["date"]}
						</div>
						<div class='col-6'>
							<img src='https://picsum.photos/536/354' >
					</div>
				</div>";
		}
	?>
</body>
</html>