<?php session_start(); ?>
<!DOCTYPE html>

<html>
    <head>
        <?php
        include("includes/head.php");
        include("includes/header.php");
        ?>
        <title>Déposer une offre</title>
    </head>
    <body>
        
        <div class="container">
            <h1> Déposer une offre </h1> 
            * mention obligatoire </br></br>
            
            <form method="POST" action="TraitementDepotOffre.php" enctype="multipart/form-data"> <!-- spécifie que le formulaire envoie des données binaires (fichier et du texte) -->
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576" /> <!-- 1mo:  Limite la taille totale des fichiers envoyés en octets -->
                <div class="formulaire">
                <fieldset><legend>Entreprise</legend>
                    <table class="formulaire"> 
                        <tr><td><label for="nomE">Nom* : </label></td><td><input type="text" name="nomE" id="nomE" required value="<?php if(isset($_SESSION['nomE'])) { echo $_SESSION['nomE'] ; } ?>"/></td></tr>
                        <tr><td><label for="siteE">Site Internet : </label></td><td><input type="url" name="siteE" id="siteE" value="<?php if(isset($_SESSION['siteE'])) { echo $_SESSION['siteE'] ; } ?>"/></td></tr>
                        <!-- Partie adresse-->
                        <tr><td><label for="adresseE">Adresse : </label></td><td><input type="text" name="adresseE" id="adresseE" value="<?php if(isset($_SESSION['adresseE'])) { echo $_SESSION['adresseE'] ; } ?>"/></td></tr>
                        <tr><td><label for="villeE">Ville : </label></td><td><input type="text" name="villeE" id="villeE" value="<?php if(isset($_SESSION['villeE'])) { echo $_SESSION['villeE'] ; } ?>"/></td></tr>
                        <tr><td><label for="cpE">Code Postal : </label></td><td><input type="text" name="cpE" id="cpE" value="<?php if(isset($_SESSION['cpE'])) { echo $_SESSION['cpE'] ; } ?>" /></td></tr>
                        <tr><td><label for="paysE">Pays : </label></td><td><input type="text" name="paysE" id="paysE" value="<?php if(isset($_SESSION['paysE'])) { echo $_SESSION['paysE'] ; } ?>" /></td></tr>
                        
                        <tr><td><label for="descripCE">Decription courte : </label></td><td><input type="text" name="descripCE" id="descripCE" value="<?php if(isset($_SESSION['descripCE'])) { echo $_SESSION['descripCE'] ; } ?>"/></td></tr>
                        <tr><td><label for="descripLE">Description longue*: </label></td><td>
                                <textarea rows="4" name="descripLE" id="descripLE" required ><?php if(isset($_SESSION['descripLE'])) { echo $_SESSION['descripLE'] ; } ?></textarea></td></tr> 
                        <tr><td><label for="logoE">Logo : </label></td><td><input type="file" name="logoE" id="logoE" /></td>
                            <td class="erreur"><?php if(isset ($_SESSION['erreurlogoE'])){ if($_SESSION['erreurlogoE']==true) { echo "Reuploadez l'image."; }} 
                                      if(isset ($_SESSION['erreurIext'])){  if($_SESSION['erreurIext']==true) { echo "Vous devez uploader un fichier de type png, gif, jpg, jpeg..."; }}
                                      if(isset ($_SESSION['erreurItaille'])){ if($_SESSION['erreurItaille']==true) { echo "L\'image dépasse la taille max"; }}
                            ?></td></tr>
                    </table>
                    </br></br></fieldset>
                
                <fieldset><legend>Contact</legend>
                    <table class="formulaire">
                        <tr><td><label for="nomC">Nom* : </label></td><td><input type="text" name="nomC" id="nomC" required value="<?php if(isset($_SESSION['nomC'])) { echo $_SESSION['nomC'] ; } ?>" /></td></tr>
                        <tr><td><label for="prenomC">Prénom : </label></td><td><input type="text" name="prenomC" id="prenomC" value="<?php if(isset($_SESSION['prenomC'])) { echo $_SESSION['prenomC'] ; } ?>" /></td></tr>
                        <tr><td><label for="mailC">Mail* : </label></td><td><input type="email" name="mailC" id="mailC" required  value="<?php if(isset($_SESSION['mailC'])) { echo $_SESSION['mailC'] ; } ?>" /></td></tr>
                        <tr><td><label for="telC">Tel : </label></td><td><input type="text" name="telC" id="telC" value="<?php if(isset($_SESSION['telC'])) { echo $_SESSION['telC'] ; } ?>" /></td></tr>
                    </table>
                </br></br></fieldset>
                
                <fieldset><legend>Offre</legend>
                <table class="formulaire">
                    <tr><td><label for="profilO">Profil* : </label></td><td><select name="profilO" id="ProfilO" required >
                                <option value="Stage" <?php if(isset($_SESSION['profilO'])&&($_SESSION['profilO']=="Stage")) { echo "selected" ; } ?>>Stage</option>
                                <option value="Emploi" <?php if(isset($_SESSION['profilO'])&&($_SESSION['profilO']=="Emploi")) { echo "selected" ; } ?>>Emploi</option>
                            </select></td></tr>
                        <tr><td><label for="nomO">Nom de l'offre* : </label></td><td><input type="text" name="nomO" id="nomO" required value="<?php if(isset($_SESSION['nomO'])) { echo $_SESSION['nomO'] ; } ?>" /></td></tr>
                        <tr><td><label for="dateDO">Date de début (YYYY-mm-dd): </label></td><td><input type="date" name="dateDO" id="dateDO" value="<?php if(isset($_SESSION['dateDO'])) { echo $_SESSION['dateDO'] ; } ?>"/></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurdateDO'])){ if($_SESSION['erreurdateDO']==true) { echo "Date incorrecte (ex : YYYY-mm-jj)" ; }} ?></td></tr>
                        <tr><td><label for="dureeO">Durée : </label></td><td><input type="text" name="dureeO" id="dureeO" value="<?php if(isset($_SESSION['dureeO'])) { echo $_SESSION['dureeO'] ; } ?>"/></td></tr>
                        <tr><td><label for="remunO">Rémunération* : </label></td><td>
                                <input type="number" name="remunO1" id="remunO1" min="0" required  value="<?php if(isset($_SESSION['remunO1'])) { echo $_SESSION['remunO1'] ; } ?>"/> <!-- obligatoire pour selection obligatoire de remunO2-->
                                <select name="remunO2" id="remunO2" required >
                                <option value="euros/Semaine" <?php if(isset($_SESSION['remunO2'])&&($_SESSION['remunO2']=="euros/Semaine")) { echo "selected" ; } ?>>euros/Semaine</option>
                                <option value="euros/Mois" <?php if(isset($_SESSION['remunO2'])&&($_SESSION['remunO2']=="euros/Mois")) { echo "selected" ; } ?>>euros/Mois</option>
                                <option value="euros/Stage Complet" <?php if(isset($_SESSION['remunO2'])&&($_SESSION['remunO2']=="euros/Stage Complet")) { echo "selected" ; } ?>>euros/Stage complet</option>
                            </select></td></tr>
                        <tr><td><label for="descripCO">Decription courte : </label></td><td><input type="text" name="descripCO" id="descripCO"  value="<?php if(isset($_SESSION['descripCO'])) { echo $_SESSION['descripCO'] ; } ?>"/></td></tr>
                        <tr><td><label for="descripLO">Description longue*: </label></td><td>
                                <textarea rows="4" name="descripLO" id="descripLO" required><?php if(isset($_SESSION['descripLO'])) { echo $_SESSION['descripLO'] ; } ?></textarea> </td></tr>
                        <tr><td><label for="fichierO">Fichier : </label></td><td><input type="file" name="fichierO" id="fichierO" /></td>
                            <td class="erreur"><?php if(isset ($_SESSION['erreurfichierO'])){ if($_SESSION['erreurfichierO']==true) { echo "Reuploadez le fichier."; }} 
                                      if(isset ($_SESSION['erreurFext'])){  if($_SESSION['erreurFext']==true) { echo "Vous devez uploader un fichier de type pdf, txt, docx, pptx, xlsx, odt,  png, gif, jpg, ou jpeg."; }}
                                      if(isset ($_SESSION['erreurFtaille'])){ if($_SESSION['erreurFtaille']==true) { echo "Le fichier dépasse la taille max"; }}
                            ?></td></tr>
                </table>
                </br></br></fieldset>
                
                <fieldset> <legend>Sécurité</legend>
                    <table class="formulaire">
                        <tr><td><label for="mdpO">Mot de Passe*: </label></td><td><input type="password" name="mdpO" id="mdpO" required /></td><!-- on ne garde pas le mdp en mémoire en cas d'erreur -->
                        <td class="erreur"><?php if(isset ($_SESSION['erreurmdpO'])){ if($_SESSION['erreurmdpO']==true) { echo "Votre mot de passe doit contenir 4 caractères minimum" ; }} ?></td></tr> 
                    </table>
                <br /><br /></fieldset> 
                
                <br />
                <div class="submit"><input type="submit" value="Envoyer" /><br /><br /></div>
                
            </form>
            </div>
    
        </div>
            <?php include("includes/footer.php"); ?>
    </body>
</html>
