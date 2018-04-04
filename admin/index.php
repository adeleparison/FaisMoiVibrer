<?php
//inclure le fichier de configuration pour vérifier la connection de l'admin
require_once('../includes/config.php');

//si c'est non, on le dirige ver la page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }

//Si GET de delpost a été envoyée, une requête prepare et execute permet de supprimer l'article grâce à son id
if(isset($_GET['delpost'])){

	$stmt = $bdd->prepare('DELETE FROM Articles WHERE id = :id') ;
	$stmt->execute(array(':id' => $_GET['delpost']));
	//La page est rechargée en passant un statut dans l'url qui confirme la suppression
	header('Location: index.php?action=deleted');
	exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Article</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
	//La fonction de confirmation de js, renvoie une commande ==> window.location.href qui ridirige la page vers 'index.php mais y ajoute ?delpost=id du message supprimer'
  function delpost(id, titre)
  {
	  if (confirm("Êtes vous sûr de supprimer l'article : '" + titre + "' ? "))
	  {
	  	window.location.href = 'index.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">
	<!--Inclure le fichier pour afficher le menu -->
	<?php include('menu.php');?>

	<?php
	//Si une action est passée dans une requête $_GET, l'article est affiché
	if(isset($_GET['action'])){
		echo '<h3>Article '.$_GET['action'].'.</h3>';
	}
	?>

	<table>
	<tr>
		<th>Titre</th>
		<th>Contenu</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {
			//Les articles sont répertoriés dans une table, pour y acceder on fait une requête pour les afficher et triés par ordre décroissant
			$stmt = $bdd->query('SELECT id, titre, contenu, datePubli FROM Articles ORDER BY id DESC');
			//on boucle ensuite pour lister les articles
			while($row = $stmt->fetch()){

				echo '<tr>';
				echo '<td>'.$row['titre'].'</td>';
				echo '<td>'.$row['contenu'].'</td>';
				echo '<td>'.strftime(date('j M Y', strtotime($row['datePubli']))).'</td>';
				?>

				<td>
					<!--Chaque article à un lien d'édition et de suppression -->
					<!--Le fichier edit-post.php permet d'éditer l'article-->
					<a href="edit-post.php?id=<?php echo $row['id'];?>">Éditer</a> |
					<!--Pour supprimer un article on fait appelle à une fonction JS ==> delpost, il attend un id et un titre de l'article, on appuie sur le bouton, la fonction renvoie un pop-up de confirmation-->
					<a href="javascript:delpost('<?php echo $row['id'];?>','<?php echo $row['titre'];?>')">Supprimer</a>
				</td>

				<?php
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-post.php'>Ajouter un article</a></p>

</div>

</body>
</html>
