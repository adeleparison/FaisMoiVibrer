<?php
//inclure le fichier de configuration pour vérifier la connection de l'admin
require_once('../includes/config.php');

//si c'est non, on le dirige ver la page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }

//Si GET de delpost a été envoyée, une requête prepare et execute permet de supprimer l'article grâce à son id
if(isset($_GET['delpost'])){

	$stmt = $bdd->prepare('DELETE FROM Toys WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['delpost']));
	//La page est rechargée en passant un statut dans l'url qui confirme la suppression
	header('Location: toy.php?action=deleted');
	exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Toys</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
	//La fonction de confirmation de js, renvoie une commande ==> window.location.href qui ridirige la page vers 'product.php mais y ajoute ?delpost=id du message supprimer'
  function delpost(id, nom)
  {
	  if (confirm("Êtes vous sûr de supprimer ce toy : '" + nom + "' ? "))
	  {
	  	window.location.href = 'toy.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">
	<!--Inclure le fichier pour afficher le menu -->
	<?php include('menu.php');?>

	<?php
	//Si une action est passée dans une requête $_GET, le toy est affiché
	if(isset($_GET['action'])){
		echo '<h3>Toys '.$_GET['action'].'.</h3>';
	}
	?>

	<table>
	<tr>
		<th>Nom</th>
		<th>Image</th>
		<th>Marque</th>
		<th>Prix</th>
    <th>Description</th>
    <th>Sexe</th>
    <th>Stimulation</th>
    <th>Matière</th>
    <th>Taille</th>
    <th>Couleur</th>
    <th>Action</th>
	</tr>
	<?php
		try {
			//Les toys sont répertoriés dans une table, pour y acceder on fait une requête pour les afficher et triés par ordre décroissant
			$stmt = $bdd->query('SELECT id, nom, image, marque, prix, description, sexe, stimulation, matiere, taille, couleur FROM Toys ORDER BY id DESC');
			//on boucle ensuite pour lister les toys
			while($row = $stmt->fetch()){

/*$row = [
	'id' => '1',
	'nom' => 'titi',
	'image' => 'image.jpg',
	'marque' => 'marc dorcel',
	'prix' => 30,
	'description' => '',
	'sexe' => '',
	'stimulation' => '',
	'matiere'=> '',
	'taille' => '',
	'couleur'=> '',
	]
$row['prix']*/

				echo '<tr>';
				echo '<td>'.$row['nom'].'</td>';
				echo '<td>'.$row['image'].'</td>';
        echo '<td>'.$row['marque'].'</td>';
        echo '<td>'.$row['prix'].'</td>';
        echo '<td>'.substr($row['description'], 0, 100).' ... </td>';
        echo '<td>'.$row['sexe'].'</td>';
        echo '<td>'.$row['stimulation'].'</td>';
        echo '<td>'.$row['matiere'].'</td>';
        echo '<td>'.$row['taille'].'</td>';
        echo '<td>'.$row['couleur'].'</td>';
				?>

				<td>
					<!--Chaque toy à un lien d'édition et de suppression -->
					<!--Le fichier edit-toy.php permet d'éditer le toy-->
					<a href="edit-toy.php?id=<?php echo $row['id'];?>">Éditer</a> |
					<!--Pour supprimer un toy on fait appelle à une fonction JS ==> delpost, il attend un id et un nom du toy, on appuie sur le bouton, la fonction renvoie un pop-up de confirmation-->
					<a href="javascript:delpost('<?php echo $row['id'];?>','<?php echo $row['nom'];?>')">Supprimer</a>
				</td>

				<?php
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-toy.php'>Ajouter un toy</a></p>

</div>

</body>
</html>
