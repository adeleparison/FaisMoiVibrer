<?php //inclure le fichier de configuration pour vérifier la connection de l'admi
require_once('../includes/config.php');

//si c'est non, on le dirige ver la page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Ajouter un toy</title>
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
	<p><a href="toy.php">Retourner</a></p>

	<h2>Ajouter un toy :</h2>

	<?php

	//Si le formulaire a été soumis, on le traite
	if(isset($_POST['submit'])){
    //
		/*$_POST = array_map('stripslashes', $_POST);*/

		//On extrait les éléments de POST à l'intérieur de cette fonction
		extract($_POST);

		//Tout élément POST est accessible en utilisant son nom $_POST['titre'] ==> $titre
		if($nom ==''){
			$error[] = "Entrez le nom du toy.";
		}

		if($image ==''){
			$error[] = "Entrez l'image du toy.";
		}

    if($marque ==''){
			$error[] = "Choisissez une marque.";
		}

    if($prix ==''){
			$error[] = "Indiquez un prix.";
		}

    if($description ==''){
      $error[] = "Indiquez une description.";
    }



    //On valide ensuite les données, si l'une des instruction est vraie, une erreur est nécessaire
		if(!isset($error)){

      if(isset($_POST['sexe']) && is_array($_POST['sexe']))
      {
        $sexe = implode(', ', $_POST['sexe']);
      }

			try {

				//Si aucune erreur n'a été détectée, les données sont insérées dans la bdd
        //On prépare les instructions pour les mettres dans les champs correspondant
				$stmt = $bdd->prepare('INSERT INTO Toys (nom,image,marque,prix,description,sexe) VALUES (:nom, :image, :marque, :prix, :description, :sexe)') ;
				$stmt->execute(array(
					':nom' => $nom,
					':image' => $image,
          ':marque' => $marque,
          ':prix' => $prix,
          ':description' => $description,
          ':sexe' => $sexe
				));

				//L'admin est redirigé vers son bashboard et un statut d'action est ajouté à l'url
				header('Location: toy.php?action=added');
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
    <div><label for="nom">Nom du toy :</label></br>
      <input type="text" name="nom" id="nom"><?php if(isset($error)){ echo $_POST['nom'];}?></input>
    </div></br>

    <div><label for="image">Image du toy :</label></br>
      <input type="text" name="image" id="image"><?php if(isset($error)){ echo $_POST['image'];}?></input>
    </div></br>

    <div><label for="marque">Marque du toy :</label></br>
      <select name="marque" id="marque"><?php if(isset($error)){ echo $_POST['marque'];}?>
        <option value="Rocks-Off">Rocks-Off</option>
        <option value="Seven Creations">Seven Creations</option>
        <option value="Fun Factory">Fun Factory</option>
        <option value="Pipedream">Pipedream</option>
        <option value="ToyJoy">ToyJoy</option>
      </select>
    </div></br>

    <div><label for="prix">Prix du toy :</label></br>
      <input type="number" name="prix" id="prix" step="0.01"><?php if(isset($error)){ echo $_POST['prix'];}?></input>
    </div></br>

    <div><label for="description">Description :</label>
    <textarea name="description" id="description" cols="60" rows="10"><?php if(isset($error)){ echo $_POST['description'];}?></textarea></div></br>

    <fieldset>
      <legend>Choix du sexe :</legend>
        <div>
          <input type="checkbox" id="femme" name="sexe[]" value="Femme">
          <label for="femme">Femme</label>
        </div>
        <div>
          <input type="checkbox" id="homme" name="sexe[]" value="Homme">
          <label for="homme">Homme</label>
        </div>
        <div>
          <input type="checkbox" id="femmeHomme" name="sexe[]" value="Femme et Homme">
          <label for="femmeHomme">Femme et Homme</label>
        </div>
        <div>
          <input type="checkbox" id="femmeFemme" name="sexe[]" value="Femme et Femme">
          <label for="femmeFemme">Femme et Femme</label>
        </div>
        <div>
          <input type="checkbox" id="hommeHomme" name="sexe[]" value="Homme et Homme">
          <label for="hommeHomme">Homme et Homme</label>
        </div>
      </fieldset>

    <div><input type="submit" name="submit" value="Envoyer"></div>
  </form>
</div>
</body>
</html>
