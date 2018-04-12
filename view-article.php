<?php require('includes/config.php');
//Ce fichier nous permet d'afficher l'article sur lequel on a cliqué

//On fait une requête ==> prepare() pour récuperer les informations de l'article sur lequel on a cliqué
//On prepare la bdd pour que la requête soit exécutée
$stmt = $bdd->prepare('SELECT id, titre, image, brief, contenu, datePubli FROM Articles WHERE id = :id');
//L'article à afficher est basé sur l'id qui passe à partir d'une requête $ GET['id']
//Quand ==> $stmt->execute est exécuté, les élèments du tableau sont liés et envoyés au serveur de la bdd
$stmt->execute(array(':id' => $_GET['id']));
$row = $stmt->fetch();

//si le id n'existe pas, on renvoit le visiteur sur la page de tous les articles (index.php)
if($row['id'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('compo/head.php');?>
    <title>Fais Moi Vibrer - <?php echo $row['titre'];?></title>
</head>
<body>

	<div id="wrapper">
		<?php include('compo/navbar.php');?>
		<p><a href="articles.php">Retour</a></p>


		<?php
		//On affiche l'article sélectionné en entier
			echo '<div>';
				echo '<h1>'.$row['titre'].'</h1>';
				echo '<img'.$row['image'].'/>';
				echo '<p>Publié le : '.strftime(date('j M Y', strtotime($row['datePubli']))).'</p>';
				echo '<p>'.$row['contenu'].'</p>';
			echo '</div>';
		?>
<?php include('compo/footer.php');?>
	</div>
	<?php include('compo/script.php');?>
</body>
</html>
