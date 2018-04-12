<?php require('includes/config.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('compo/head.php');?>
    <title>Fais Moi Vibrer</title>
</head>
<body>

	<div id="wrapper">
    <?php include('compo/navbar.php');?>
<?php
try {
  //Requête pour afficher tous les toys en ordre décroissant (par rapport au id) de la table Toys
  $stmt = $bdd->query('SELECT id, nom, image, marque, prix FROM Toys ORDER BY id DESC');
  //Les articles passent dans une boucle pour les afficher un par un (en colonne)
  while($row = $stmt->fetch()){
    echo '<div>';

      echo '<h2><a href="view-produit.php?id='.$row['id'].'">'.$row['nom'].'</a></h2>';
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

<?php include('compo/footer.php');?>
	</div>

  <?php include('compo/script.php');?>
</body>
</html>
