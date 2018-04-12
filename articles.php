<?php require('includes/config.php');?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('compo/head.php');?>
    <title>Fais Moi Vibrer - Les articles</title>
</head>
<body>

	<div id="wrapper">
    <?php include('compo/navbar.php');?>

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
    <?php include('compo/footer.php');?>

	</div>

  <?php include('compo/script.php');?>
</body>
</html>
