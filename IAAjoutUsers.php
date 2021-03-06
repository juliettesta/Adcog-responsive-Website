<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
      include("includes/head.php");
      include("includes/header.php");
      include("includes/esTuAdmin.php");
      ?>
        <title>Ajouter utilisateur</title>
        
    </head>
    <body>
        <?php require("db/connect.php"); // Accès à la BDD ?>
        <div class="container"> 
        <!-- Navigation Admin -->
        <nav  class="navbar navbar-default gris" role="navigation">
             <ul class="nav navbar-nav">
                 <li><a href="IAoffres.php" class="navPrincipale">Gérer les offres</a></li>
                 <li><a href="IAusers.php" class="navCouleurContainer"> Gérer les utilisateurs</a></li>
                 <li><a href="IAEntreprisesContacts.php" class="navPrincipale"> Gérer les entreprises & contacts</a></li>
             </ul>
        </nav>
        
            <!--  Formulaire ajouter utilisateurs -->
            <h1> Ajouter un utilisateur </h1> </br>
            * mention obligatoire </br></br>
            <form method="POST" action="IATraitementAjoutUsers.php">
                
                <div class="formulaire">
                <fieldset>
                    <table class="formulaire">
                        <!-- Utilisateur -->
                        <tr><td><label for="nomU">Nom : </label></td><td><input type="text" name="nomU" id="nomU" value="<?php if(isset($_SESSION['nomU'])) { echo $_SESSION['nomU'] ; } ?>"/></td></tr>
                        <tr><td><label for="prenomU">Prénom : </label></td><td><input type="text" name="prenomU" id="prenomU" value="<?php if(isset($_SESSION['prenomU'])) { echo $_SESSION['prenomU'] ; } ?>"/></td></tr>
                        <tr><td><label for="dateneeU">Date de naissance (YYYY-mm-dd): </label></td><td><input type="date" name="dateneeU" id="dateneeU" value="<?php if(isset($_SESSION['dateneeU'])) { echo $_SESSION['dateneeU'] ; } ?>"/></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurdateneeU'])){ if($_SESSION['erreurdateneeU']==true) { echo "Date incorrecte (ex : YYYY-mm-jj)" ; }} ?></td></tr>
                        <tr><td><label for="statutU">Statut* : </label></td><td><select name="statutU" id="statutU" required >
                                <option value="normal" <?php if(isset($_SESSION['statutU'])&&($_SESSION['statutU']=="normal")) { echo "selected" ; } ?> >Normal</option>
                                <option value="adherent" <?php if(isset($_SESSION['statutU'])&&($_SESSION['statutU']=="adherent")) { echo "selected" ; } ?> >Adherent</option>
                                <option value="admin" <?php if(isset($_SESSION['statutU'])&&($_SESSION['statutU']=="admin")) { echo "selected" ; } ?> >Admin</option>
                            </select></td></tr>
                        <tr><td><label for="mailU">Mail : </label></td><td><input type="email" name="mailU" id="mailU" value="<?php if(isset($_SESSION['mailU'])) { echo $_SESSION['mailU'] ; } ?>"/></td></tr>
                        <tr><td><label for="telU">Tel : </label></td><td><input type="text" name="telU" id="telU" value="<?php if(isset($_SESSION['telU'])) { echo $_SESSION['telU'] ; } ?>"/></td></tr>
                        <tr><td><label for="loginU">Login* : </label></td><td><input type="text" name="loginU" id="loginU" required value="<?php if(isset($_SESSION['loginU'])) { echo $_SESSION['loginU'] ; } ?>"/></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurloginU'])){ if($_SESSION['erreurloginU']==true) { echo "Login déjà utilisé" ; }} ?></td></tr>
                        <tr><td><label for="mdpU">Mot de passe* : </label></td><td><input type="password" name="mdpU" id="mdpU" required /></td> <!-- On ne retient pas le mdp-->
                        <td class="erreur"><?php if(isset ($_SESSION['erreurmdpU'])){ if($_SESSION['erreurmdpU']==true) { echo "Votre mot de passe doit contenir 4 caractères minimum" ; }} ?></td></tr>
                        <!-- Adresse -->
                        <tr><td><label for="adresseU">Adresse : </label></td><td><input type="text" name="adresseU" id="adresseU" value="<?php if(isset($_SESSION['adresseU'])) { echo $_SESSION['adresseU'] ; } ?>"/></td></tr>
                        <tr><td><label for="villeU">Ville : </label></td><td><input type="text" name="villeU" id="villeU"  value="<?php if(isset($_SESSION['villeU'])) { echo $_SESSION['villeU'] ; } ?>"/></td></tr>
                        <tr><td><label for="cpU">Code Postal : </label></td><td><input type="text" name="cpU" id="cpU" value="<?php if(isset($_SESSION['cpU'])) { echo $_SESSION['cpU'] ; } ?>"/></td></tr>
                        <tr><td><label for="paysU">Pays : </label></td><td><input type="text" name="paysU" id="paysU" value="<?php if(isset($_SESSION['paysU'])) { echo $_SESSION['paysU'] ; } ?>" /></td></tr>
                        
                    </table>
                    </br></br></fieldset>
                       <div class="submit"><input type="submit" value="Envoyer" /><br /><br /></div>
                
                </div></form>

                
        </div>
    </body>
    <?php include("includes/footer.php"); ?>
</html>
