<?php require('includes/config.php');
//Ce fichier nous permet d'afficher l'article sur lequel on a cliqué

//On fait une requête ==> prepare() pour récuperer les informations du toy sur lequel on a cliqué
//On prepare la bdd pour que la requête soit exécutée
$stmt = $bdd->prepare('SELECT id, nom, sexe, stimulation, marque, matiere, taille, prix, couleur, description, image FROM Toys WHERE id = :id');
//Le toy à afficher est basé sur l'id qui passe à partir d'une requête $ GET['id']
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
    <title>Fais Moi Vibrer - <?php echo $row ['nom'];?></title>
  </head>
  <body>
    <div id="wrapper">
      <?php include('compo/navbar.php');?>

      <?php
      //On affiche le toy sélectionné en entier
        echo '<div>';
          echo '<p>'.$row['nom'].'</p>';
          echo '<p><img style="height:400px; width:400px; border:1px solid" src="image/'.$row['image'].'" alt="toysimage"/></p>';
          echo '<p>'.$row['marque'].'</p>';
          echo '<p>'.$row['prix'].' € </p>';
          echo '<p>'.$row['description'].'</p>';
          echo '<p>'.$row['sexe'].'</p>';
          echo '<p>'.$row['stimulation'].'</p>';
          echo '<p>'.$row['matiere'].'</p>';
          echo '<p>'.$row['taille'].' cm </p>';
          echo '<p>'.$row['couleur'].'</p>';
        echo '</div>';
      ?>

      <p><a href="produits.php">Retour</a></p>
<?php include('compo/footer.php');?>
    </div>
		<?php include('compo/script.php');?>
  </body>
</html>
