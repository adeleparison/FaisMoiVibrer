<?php
//ce fichier est utilisé pour connecter, déconnecter l'admin et vérifier le mot de passe
include('class.password.php');

class User extends Password{

    private $bdd;
  //fonction appelée dès que la classe est exécutée, elle permet la connexion à une bdd
	function __construct($bdd){
		parent::__construct();

		$this->_bdd = $bdd;
	}
  //Pour vérifier si un utilisateur est connecté à une méthode, is_logged_in recherche une SESSION = loggedin
	public function is_logged_in(){
    //Si cette SESSION est définie et si elle est vraie, il s'agit d'un utilisateur connecté
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
      //Si c'est "ok", elle renvoit true, sinon rien
			return true;
		}
	}
  //La méthode ==> get_user_hash() est utilisée pour récupérer les colonnes de la bdd et les retournes
	private function get_user_hash($pseudo){

		try {

			$stmt = $this->_bdd->prepare('SELECT id, pseudo, password FROM Admi WHERE pseudo = :pseudo');
			$stmt->execute(array('pseudo' => $pseudo));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="error">'.$e->getMessage().'</p>';
		}
	}


	public function login($pseudo,$password){

		$user = $this->get_user_hash($pseudo);
    //Pour vérifier un hachage, la méthode ==> password_verify()
    //Le mot de passe du formulaire doit être égal au formulaire du mot de passe haché de la bdd, et doit être égal à 1, sinon cela signifie qu'il ne correspond pas
		if($this->password_verify($password,$user['password']) == 1){

		    $_SESSION['loggedin'] = true;
		    $_SESSION['id'] = $user['id'];
		    $_SESSION['pseudo'] = $user['pseudo'];
		    return true;
		}
	}


	public function logout(){
		session_destroy();
	}

}


?>
