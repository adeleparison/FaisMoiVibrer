<?php
//inclure le fichier de configuration pour vérifier la connexion de l'admin
require_once('../includes/config.php');

//si c'est non, on le dirige vers la page de connexion
if( $user->is_logged_in() ){ header('Location: index.php'); }
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
      <title>Connexion Admin</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
  </head>
  <body>

    <div id="login">

	<?php
  echo password_hash('FaisMoiVibrer', PASSWORD_DEFAULT);
	//Pour se connecter sur la page d'admin, on récupére les informations du formulaire
	if(isset($_POST['submit'])){
    // trim est une fonction  pour enlever les espaces, on regarde si tout correspond par rapport à la bdd
		$pseudo = trim($_POST['pseudo']);
		$password = trim($_POST['password']);

    //Si tout est ok, il est redirigé sur la page index.php (côte admin)
		if($user->login($pseudo,$password)){
			header('Location: index.php');
			exit;
		}
    //si ce n'est pas bon, message d'erreur
    else {
			$message = '<p class="error">Votre pseudo ou votre mot de passe n\'est pas correct</p>';
		}

	}//le message d'erreur s'affiche ici
	if(isset($message)){ echo $message; }
	?>

  <h3>Veuillez vous connecter :</h3>
  <form method="post" action="">
    <div><label for="pseudo">Pseudo :</label>
    <input type="text" name="pseudo" id="pseudo" required></input></div></br>
    <div><label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required></input></div></br>
    <div><input type="submit" name="submit" value="Connexion"></input></div>
  </form>

  </div>
  </body>
</html>
