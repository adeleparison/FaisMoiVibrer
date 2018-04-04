<?php //inclure le fichier de configuration pour vérifier la connection de l'admin
require_once('../includes/config.php');

//si c'est non, on le dirige ver la page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Modifier article</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          //Option de la librairie de l'éditeur de texte
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="./">Retourner</a></p>

	<h2>Modifier un article</h2>


	<?php

	//Si le formulaire a été soumis, on le traite
	if(isset($_POST['submit'])){
    //
		$_POST = array_map( 'stripslashes', $_POST );

    //On extrait les éléments de POST à l'intérieur de cette fonction
		extract($_POST);

    //Tout élément POST est accessible en utilisant son nom $_POST['titre'] ==> $titre
		if($id ==''){
			$error[] = 'Il manque un identifiant valide à ce message !';
		}

    if($titre ==''){
			$error[] = 'Entrez un titre.';
		}

		if($brief ==''){
			$error[] = 'Entrez une description.';
		}

		if($contenu ==''){
			$error[] = 'Entrez le texte.';
		}

    //On valide ensuite les données, si l'une des instruction est vraie, une erreur est nécessaire
		if(!isset($error)){

			try {

				//Requete pour mettre à jour les données (prepare et execute) on met à jour les colonnes spécifiées par les espaces réservés
				$stmt = $bdd->prepare('UPDATE Articles SET titre = :titre, brief = :brief, contenu = :contenu WHERE id = :id') ;
				$stmt->execute(array(
					':titre' => $titre,
					':brief' => $brief,
					':contenu' => $contenu,
					':id' => $id
				));

        //L'admin est redirigé vers son bashboard et un statut d'action est ajouté à l'url
				header('Location: index.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
  //Si des erreurs ont été détectées, une boucle parcours le tableau d'erreurs pour les afficher.
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {
      //Requête pour sélectionner l'article dans la bdd par rapport à son id
			$stmt = $bdd->prepare('SELECT id, titre, brief, contenu FROM Articles WHERE id = :id');
			$stmt->execute(array(':id' => $_GET['id']));
			$row = $stmt->fetch();

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form method='POST' action=''>
    <div><label for="id">Identifiant :</label></br>
    <input type="id" name="id" id="id" value='<?php echo $row['id'];?>'>

    <div><label for="titre">Titre :</label></br>
    <input type="text" name="titre" id="titre" value='<?php echo $row['titre'];?>'></div>

    <div><label for="brief">Description :</label>
    <textarea name="brief" id="brief" cols="60" rows="10"><?php echo $row['brief'];?></textarea></div>

    <div><label for="contenu">Contenu :</label>
    <textarea name="contenu" id="contenu" cols="60" rows="10"><?php echo $row['contenu'];?></textarea></div>

		<div><input type='submit' name='submit' value='Mettre à jour'></div>
	</form>

</div>

</body>
</html>
