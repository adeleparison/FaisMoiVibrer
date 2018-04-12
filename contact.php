<?php require('includes/config.php');?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <?php include('compo/head.php');?>
    <title>FaisMoiVibrer - Contact</title>
  </head>
  <body>
    <div id="wrapper">
      <?php include('compo/navbar.php');?>

      <?php
      $info = NULL;
      //Si le formulaire a été soumis, on le traite
      if(isset($_POST['submit'])){
        //On extrait les éléments de POST à l'intérieur de cette fonction
        extract($_POST);

        /*$prenom = htmlspecialchars($prenom);
        $nom = htmlspecialchars($nom);
        $mail = htmlspecialchars($mail);
        $message = htmlspecialchars($message);
        $destinataire = "adele.parison@hotmail.fr";
        $sujet = "Forulaire de contact";

        mail($destinataire, $sujet, $message);*/



        //Tout élément POST est accessible en utilisant son nom $_POST['nom'] ==> $nom
        if($prenom ==''){
          $error[] = 'Entrez votre prénom.';
        }

        if($nom ==''){
          $error[] = 'Entrez votre nom.';
        }

        if($mail ==''){
          $error[] = 'Entrez votre e-mail.';
        }

        if($message ==''){
          $error[] = 'Entrez votre message.';
        }

        //On valide ensuite les données, si l'une des instruction est vraie, une erreur est nécessaire
    		if(!isset($error)){

          try {

            //Si aucune erreur n'a été détectée, les données sont insérées dans la bdd
            //On prépare les instructions pour les mettres dans les champs correspondant
            $stmt = $bdd->prepare('INSERT INTO Message (nom, prenom, mail, message) VALUES (:nom, :prenom, :mail, :message)') ;
            $stmt->execute(array(
              ':nom' => $nom,
              ':prenom' => $prenom,
              ':mail' => $mail,
              ':message' => $message
            ));

            $info = "Votre email à été envoyé";

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

        <section class="contact">
              <div class="container-fluid" style="">
                <div class="row">
                  <div class="above col-sm-4 offset-sm-4 col-md-4 offset-md-4 col-lg-2 offset-lg-5">
                    <legend class="legend text-uppercase">Contact</legend>
                  </div>
                </div>
                <div>
                  <form method="POST" class="below col-sm-8 col-md-8 mx-auto">
                    <p class="intro">N'hésitez pas à nous solliciter pour toutes questions ou juste pour nous dire bonjour ! <br> Nous vous contacterons dans les meilleurs délais afin de répondre à votre demande.</p>
                    <div class="form-row">
                      <div class="col-md-5 mx-auto">
                        <!-- <label for="prenom">Votre prénom :</label> -->
                        <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?php if(isset($_POST['prenom'])) echo htmlspecialchars($_POST['prenom']);?>">
                      </div>
                      <div class="col-md-5 mx-auto">
                        <!-- <label for="nom">Votre nom :</label> -->
                        <input type="text" id="nom" name="nom" placeholder="Nom" value="<?php if(isset($_POST['nom'])) echo htmlspecialchars($_POST['nom']);?>">
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="col-md-11 mx-auto">
                        <!-- <label for="mail">Votre e-mail :</label> -->
                        <input type="email" id="mail" name="mail" placeholder="E-Mail" value="<?php if(isset($_POST['mail'])) echo htmlspecialchars($_POST['mail']);?>">
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="col-md-11 mx-auto">
                      <!-- <label for="msg">Votre message :</label> -->
                      <textarea id="message" name="message" rows="3" placeholder="Veuillez écrire votre message ici ..."><?php if(isset($_POST['message'])) echo htmlspecialchars($_POST['message']);?></textarea>
                      </div>
                    </div>

                    <div class="form-row text-center">
                        <div class="col-12">
                            <button type="submit" name="submit" class="btnContact btn btn-outline-dark">Envoyer le message</button>
                            <p class="error"><?php echo $info; ?></p>
                        </div>
                     </div>

                  </form>
                  </div>
              </div>
            </section>
        <?php include('compo/footer.php');?>
    </div>
    <?php include('compo/script.php');?>
  </body>
</html>
