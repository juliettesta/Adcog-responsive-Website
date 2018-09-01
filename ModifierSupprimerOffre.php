<?php session_start(); ?>
<!DOCTYPE html>

<html>
    <head>
      <?php
      include("includes/head.php");
      include("includes/header.php");
      ?>
        <title>Modifier/Supprimer une Offre</title>
    </head>
    
    <body>
        <?php require("db/connect.php"); // Accès à la BDD ?>
        <div class="container"> 
            <h1> Accèder à une offre </h1> </br></br>
            
            <form method="POST" action="TraitementModifierSupprimerOffre.php">
                
                <div class="formulaire">
                <fieldset>
                    <table class="formulaire">
                        <tr><td><label for="numO">N° Offre : </label></td><td><input type="int" name="numO" id="numO" required value="<?php if(isset($_SESSION['numO'])) { echo $_SESSION['numO'] ; } ?>"/></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurnumOffre'])){ if($_SESSION['erreurnumOffre']==true) { echo "N° Offre inexistant" ; }} ?></td></tr>
                        <tr><td><label for="mdpO">Mot de Passe : </label></td><td><input type="password" name="mdpO" id="mdpO" required /></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurmdp'])){ if($_SESSION['erreurmdp']==true) { echo "Mauvais mot de Passe" ; }} ?></td></tr>
                        
                    </table>
                    </br></br></fieldset>
                       <div class="submit"><input type="submit" value="Modifier" /><br /><br /></div>
                
                </div></form>
            
        </div>
    </body>
    <?php include("includes/footer.php"); ?>
</html>
