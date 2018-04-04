<?php //inclure le fichier de configuration pour vérifier la connection de l'admi
require_once('../includes/config.php');

//si c'est non, on le dirige ver la page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Ajouter un article</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <!-- CDN pour charger l'éditeur de texte (tinyMCE) -->
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          //Option de configuration de l'éditeur de texte
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

	<h2>Ajouter un article</h2>

	<?php

	//Si le formulaire a été soumis, on le traite
	if(isset($_POST['submit'])){
    //
		$_POST = array_map('stripslashes', $_POST);

		//On extrait les éléments de POST à l'intérieur de cette fonction
		extract($_POST);

		//Tout élément POST est accessible en utilisant son nom $_POST['titre'] ==> $titre
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

				//Si aucune erreur n'a été détectée, les données sont insérées dans la bdd
        //On prépare les instructions pour les mettres dans les champs correspondant
				$stmt = $bdd->prepare('INSERT INTO Articles (titre,brief,contenu,datePubli) VALUES (:titre, :brief, :contenu, :datePubli)') ;
				$stmt->execute(array(
					':titre' => $titre,
					':brief' => $brief,
					':contenu' => $contenu,
					':datePubli' => date('Y-m-d')
				));

				//L'admin est redirigé vers son bashboard et un statut d'action est ajouté à l'url
				header('Location: index.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//Si des erreurs ont été détectées, une boucle parcours le tableau d'erreurs pour les afficher.
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>
  <!-- Ce formulaire permet de rajouter un article, chaque section deviendra una variable en php lorsque le formulaire sera soumis-->
  <form method="post" action="">
    <div><label for="titre">Titre :</label></br>
    <input type="text" name="titre" id="titre" required><?php if(isset($error)){ echo $_POST['titre'];}?></input></div></br>

    <div><label for="brief">Description :</label>
    <textarea name="brief" id="brief" cols="60" rows="10"><?php if(isset($error)){ echo $_POST['brief'];}?></textarea></div></br>

    <div><label for="contenu">Contenu :</label>
    <textarea name="contenu" id="contenu" cols="60" rows="10"><?php if(isset($error)){ echo $_POST['contenu'];}?></textarea></p>

    <div><input type="submit" name="submit" value="Envoyer"></div>
  </form>
</div>
</body>
</html>
