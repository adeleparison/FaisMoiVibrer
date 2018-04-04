<?php
//inclure le fichier de configuration pour vérifier la connection de l'admi
require_once('../includes/config.php');

//si c'est non, on le dirige ver la page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['deluser'])){

	//if user id is 1 ignore
	if($_GET['deluser'] !='1'){

		$stmt = $bdd->prepare('DELETE FROM Admi WHERE id = :id') ;
		$stmt->execute(array(':id' => $_GET['deluser']));

		header('Location: users.php?action=deleted');
		exit;

	}
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Utilisateur</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
	  if (confirm("Etes-vous sûr de supprimer : '" + title + "'"))
	  {
	  	window.location.href = 'users.php?deluser=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php
	//show message from add / edit page
	if(isset($_GET['action'])){
		echo '<h3>User '.$_GET['action'].'.</h3>';
	}
	?>

	<table>
	<tr>
		<th>Numéro</th>
		<th>Pseudo</th>
		<th>Email</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$stmt = $bdd->query('SELECT id, pseudo, email, password FROM Admi ORDER BY id');
			while($row = $stmt->fetch()){

				echo '<tr>';
				echo '<td>'.$row['id'].'</td>';
				echo '<td>'.$row['pseudo'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				?>

				<td>
					<a href="edit-user.php?id=<?php echo $row['id'];?>">Modifier</a>
					<?php if($row['id'] != 1){?>
						| <a href="javascript:deluser('<?php echo $row['id'];?>','<?php echo $row['pseudo'];?>')">Supprimer</a>
					<?php } ?>
				</td>

				<?php
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-user.php'>Ajouter un utilisateur</a></p>

</div>

</body>
</html>
