<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
    <?php
      include("includes/head.php");
      print     '<title>Accueil</title></head>';
      include("includes/header.php");
    ?>
    
    <body>
    <?php 
        include("includes/ViderSessionFormulaire.php");
        //Bandeau de confirmation d'une offre envoyée
        if(isset ($_SESSION['OffreEnvoyee'])){
        if ($_SESSION['OffreEnvoyee']== true) {
            print "<div class='confirmation'> Offre envoyée </br>"; 
            print "Retenez votre mot de passe et le numero de l'offre pour pouvoir la modifier ou la supprimer à tout moment </br>";
            print "N° de l'offre : ".$_GET['numoffre']."    Mot de Passe : ".$_GET['mdp']."</div>";
            $_SESSION['OffreEnvoyee']= false;
            }}
        //Offre modifiée
        if(isset ($_SESSION['OffreModifiee'])){
        if ($_SESSION['OffreModifiee']== true) {
            print "<div class='confirmation'> Offre modifiée </div>"; 
            $_SESSION['OffreModifiee']= false;
            }}    
    ?>
        
        <div class="container">   
            <h1>Bienvenue sur le site de l'AdCog !</h1></br>
            <p class="bienvenue">
                 - - - - - - - - - - - - - - - - - - - - - - - - - - </br>
                Vous pouvez ici déposer ou consulter des offres d'emplois et de stages <i>(connectez-vous pour les consulter !)</i>
            </br> - - - - - - - - - - - - - - - - - - - - - - - - - - </br>
            </p>
            
            <table class="tableCentre">
                <tr>
                    <td class='espacement'>
                        <a href="DeposerOffre.php" class="thumbnail">
                              <img src="images/deposerOffre.PNG" alt="deposer une offre">
                        </a>
                    </td>
                    <td class='espacement'>
                        <a href="stages.php" class="thumbnail">
                            <img src="images/ConsulterStage1.PNG" alt="consulter stage">
                        </a>
                    </td>
                    <td class='espacement'>
                        <a href="emplois.php" class="thumbnail">
                              <img src="images/ConsulterEmploi1.PNG" alt="consulter emplois">
                        </a>
                    </td>   
                </tr>
            </table></br></br>

      
            
        <?php
            require("db\connect.php");
            
        ?>    
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
<html/>