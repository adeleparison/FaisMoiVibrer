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
  //Requête pour afficher tous les toys en ordre décroissant (par rapport au id) de la table Toys
  $stmt = $bdd->query('SELECT id, nom, image, marque, prix FROM Toys ORDER BY id DESC');
  //Les articles passent dans une boucle pour les afficher un par un (en colonne)
  while($row = $stmt->fetch()){
    echo '<div>';

      echo '<h2><a href="view-toy.php?id='.$row['id'].'">'.$row['nom'].'</a></h2>';
      echo '<p><img style="height:200px; width:200px; border:1px solid" src="image/'.$row['image'].'" alt="toysimage"/></p>';
      echo '<p>'.$row['marque'].'</p>';
      echo '<p>'.$row['prix'].' € </p>';
      echo '<p><a href="view-produit.php?id='.$row['id'].'">Le voir</a></p>';
    echo '</div>';
  }
} catch(PDOException $e) {
  echo $e->getMessage();
}
  ?>

	</div>


</body>
</html>
