<?php require('includes/config.php');?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <?php include('compo/head.php');?>
    <title>FaisMoiVibrer - Autorisation</title>
  </head>
  <body style="background-color:#B21242;">
    <section class="avertissement">
          <div class="container-fluid">
            <div class="row">
              <div class="cadre col-sm-8 col-md-8 mx-auto">
                <h2 class="logo text-uppercase">Fais moi vibrer</h2>
                <h5 class="decription" style="color:#F885A1;">INTERDIT AUX MOINS DE 18 ANS - AVERTISSEMENT !</h5>
                <p class="decription" style="font-size:15px;">Ce site est réservé à un public majeur et averti.<br>En cliquant sur «J'ai plus de 18 ans» vous certifiez avoir pris connaissance des obligations suivantes :</p>
                <ul class="loi">
                  <li>Etre majeur selon les lois françaises et que ces lois vous autorisent à accéder à ce service.</li>
                  <li>A ne pas diffuser le contenu de ce service qui est la propriété de l’éditeur.</li>
                  <li>A ne pas faire connaître ce service à des mineurs, sous peine de sanctions pénales.</li>
                  <li>A ne pas poursuivre l’éditeur de ce service pour toute action judiciaire.</li>
                </ul>

                <div class="row text-center">
                    <div class="col-sm-6 col-md-5 offset-md-1 col-lg-3 offset-lg-2">
                        <button type="submit" name="submit" class="btnAvertissement btn btn-outline-dark"><a class="lienGoSite" href="https://www.google.fr/">Je n'ai pas 18 ans</a></button>
                    </div>
                    <div class="col-sm-6 col-md-5 col-lg-3 offset-lg-2">
                        <button type="submit" name="submit" class="btnAvertissement btn btn-outline-dark"><a class="lienGoSite" href="accueil.php">J'ai plus de 18 ans</a></button>
                    </div>
                 </div>
              </div>
            </div>
            <div>
        </section>
  </body>
  <?php include('compo/script.php');?>
</html>
