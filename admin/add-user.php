<?php //inclure le fichier de configuration pour vérifier la connection de l'admi
require_once('../includes/config.php');

//si c'est non, on le dirige ver la page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Ajouter un Utilisateur</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="users.php">Retourner aux utilisateurs</a></p>

	<h2>Ajouter un utilisateur</h2>

	<?php

  //Si le formulaire a été soumis, on le traite
	if(isset($_POST['submit'])){

    //On extrait les éléments de POST à l'intérieur de cette fonction
		extract($_POST);

    //Tout élément POST est accessible en utilisant son nom $_POST['pseudo'] ==> $pseudo
		if($pseudo ==''){
			$error[] = 'Entrez un pseudo.';
		}

		if($password ==''){
			$error[] = 'Entrez un mot de passe.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Confirmez le mot de passe.';
		}

		if($password != $passwordConfirm){
			$error[] = 'Les mots de passe ne correspondent pas.';
		}

		if($email ==''){
			$error[] = 'Entrez un e-mail.';
		}

    //On valide ensuite les données, si l'une des instruction est vraie, une erreur est nécessaire
		if(!isset($error)){

			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

			try {

        //Si aucune erreur n'a été détectée, les données sont insérées dans la bdd
        //On prépare les instructions pour les mettres dans les champs correspondant
				$stmt = $bdd->prepare('INSERT INTO Admi (pseudo,password,email) VALUES (:pseudo, :password, :email)') ;
				$stmt->execute(array(
					':pseudo' => $pseudo,
					':password' => $hashedpassword,
					':email' => $email
				));

        //L'admin est redirigé vers son bashboard et un statut d'action est ajouté à l'url
				header('Location: users.php?action=added');
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

	<form action='' method='post'>

		<p><label>Pseudo :</label><br />
		<input type='text' name='pseudo' value='<?php if(isset($error)){ echo $_POST['pseudo'];}?>'></p>

		<p><label>Mot de passe :</label><br />
		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

		<p><label>Confirmer le mot de passe :</label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

		<p><label>Email :</label><br />
		<input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>

		<p><input type='submit' name='submit' value='Ajouter utilisateur'></p>

	</form>

</div>
