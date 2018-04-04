<?php //inclure le fichier de configuration pour vérifier la connection de l'admi
require_once('../includes/config.php');

//si c'est non, on le dirige ver la page de connexion
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit User</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="users.php">User Admin Index</a></p>

	<h2>Edit User</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($pseudo ==''){
			$error[] = 'Please enter the pseudo.';
		}

		if( strlen($password) > 0){

			if($password ==''){
				$error[] = 'Please enter the password.';
			}

			if($passwordConfirm ==''){
				$error[] = 'Please confirm the password.';
			}

			if($password != $passwordConfirm){
				$error[] = 'Passwords do not match.';
			}

		}


		if($email ==''){
			$error[] = 'Please enter the email address.';
		}

		if(!isset($error)){

			try {

				if(isset($password)){

					$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

					//update into database
					$stmt = $bdd->prepare('UPDATE Admi SET pseudo = :pseudo, password = :password, email = :email WHERE id = :id') ;
					$stmt->execute(array(
						':pseudo' => $pseudo,
						':password' => $hashedpassword,
						':email' => $email,
						':id' => $id
					));


				} else {

					//update database
					$stmt = $bdd->prepare('UPDATE Admi SET pseudo = :pseudo, email = :email WHERE id = :id') ;
					$stmt->execute(array(
						':pseudo' => $pseudo,
						':email' => $email,
						':id' => $id
					));

				}


				//redirect to index page
				header('Location: users.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $bdd->prepare('SELECT id, pseudo, email FROM Admi WHERE id = :id') ;
			$stmt->execute(array(':id' => $_GET['id']));
			$row = $stmt->fetch();

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='id' value='<?php echo $row['id'];?>'>

		<p><label>pseudo</label><br />
		<input type='text' name='pseudo' value='<?php echo $row['pseudo'];?>'></p>

		<p><label>Password (only to change)</label><br />
		<input type='password' name='password' value=''></p>

		<p><label>Confirm Password</label><br />
		<input type='password' name='passwordConfirm' value=''></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php echo $row['email'];?>'></p>

		<p><input type='submit' name='submit' value='Update User'></p>

	</form>

</div>

</body>
</html>
