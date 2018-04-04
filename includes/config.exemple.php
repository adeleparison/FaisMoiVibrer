<?php
//Mise en mémoire
ob_start();
//On démarre les sessions pour la zone administration
session_start();

//Definir les détails de connexion pour la bdd
define('DBHOST','localhost');
define('DBUSER','DBUSER');
define('DBPASS','DBPASS');
define('DBNAME','DBNAME');

//Ouvrir connexion PDO
$bdd = new PDO("mysql:host=".DBHOST.";port=8888;dbname=".DBNAME, DBUSER, DBPASS);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//Régler le fuseau horaire
date_default_timezone_set('Europe/London');

//Fonction de chargement automatique, inclura n'importe quelle classe
function __autoload($class) {

   //Converti en minuscule ==> strtolower()
   $class = strtolower($class);

	//Condition de vérification sur l'existence du fichier ==> file_exists()
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}

  //Condition de vérification sur l'existence du fichier
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}

  //Condition de vérification sur l'existence du fichier
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}

}
/*classe $user est instanciée (la mise à zéro et démarrage d'un programme) ==> new User et transmet la connexion à la bdd ($bdd), pour que la classe
user est acces à la bdd*/
$user = new User($bdd);
?>
