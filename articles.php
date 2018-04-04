<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Fais Moi Vibrer</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	<div id="wrapper">

		<h1>Fais Moi Vibrer</h1>
		<hr />

		<?php
			try {
        //Requête pour afficher tous les articles en ordre décroissant (par rapport au id) de la table Articles
				$stmt = $bdd->query('SELECT id, titre, image, brief, contenu, datePubli FROM Articles ORDER BY id DESC');
        //Les articles passent dans une boucle pour les afficher un par un (en colonne)
				while($row = $stmt->fetch()){

          //Sur chaque boucle on affiche le titre, la date de publication, le brief et un lien pour "lire la suite" de l'article
					echo '<div>';
						echo '<h2><a href="view-article.php?id='.$row['id'].'">'.$row['titre'].'</a></h2>';
						echo '<p>Publié le : '.strftime(date('j M Y', strtotime($row['datePubli']))).'</p>';
						echo '<p>'.$row['brief'].'</p>';
						echo '<p><a href="view-article.php?id='.$row['id'].'">Lire la suite</a></p>';
					echo '</div>';

				}
        //Message d'erreur, si échec de la connexion de bdd
			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

	</div>


</body>
</html>
