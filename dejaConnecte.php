<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
    <?php
      include("includes/head.php");
      print     '<title>Connexion</title></head>';
      include("includes/header.php");
      include("includes/esTuConnecte.php");
    ?>
        
    <body>
        <div class="container">
            <h1 class="text-center login-title">Connexion aux offres de l'AdCog</h1>
                <div class="col-sm-6 col-md-4 col-md-offset-4" align="center">
                    <div class="imageconnexion">
                        <img class="imageProfil" src="images\profil.jpg"/></div>
                    <div class="account-wall">
                        
                        <div class="alert alert-info" role="alert">
                            Vous êtes déjà connecté !
                        </div>
                        
                        <div class="imageconnexion"><a href="TraiteConnexion.php" >Se déconnecter ?</a></div>
                </div>
        </div>
        </div>
    </body>
    <?php include("includes/footer.php"); ?>
<html/>