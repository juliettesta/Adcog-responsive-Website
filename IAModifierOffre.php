<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include("includes/head.php");
      include("includes/header.php");
      include("includes/esTuAdmin.php");
?>
        <title>Modifier Offre</title> 
    </head>
    <body>
        <?php require("db/connect.php"); // Accès à la BDD ?>
        <div class="container"> 
            <!-- Navigation Admin -->
        <nav  class="navbar navbar-default gris" role="navigation">
             <ul class="nav navbar-nav">
                 <li><a href="IAoffres.php" class="navCouleurContainer">Gérer les offres</a></li>
                 <li><a href="IAusers.php" class="navPrincipale"> Gérer les utilisateurs</a></li>
                 <li><a href="IAEntreprisesContacts.php" class="navPrincipale"> Gérer les entreprises & contacts</a></li>
             </ul>
        </nav>
            
            <h1> Modifier offre </h1> </br></br>
        
            * mention obligatoire </br></br>
            
            <form method="POST" action="IATraitementModifierOffre.php" enctype="multipart/form-data"> <!-- spécifie que le formulaire envoie des données binaires (fichier) et du texte -->
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576" /> <!-- 1mo:  Limite la taille totale des fichiers envoyés en octets -->
                <div class="formulaire">
                <fieldset><legend>Entreprise</legend>
                    <table class="formulaire">
                        <?php  
                        if (!isset($_GET["id"])&& (!isset($_SESSION['offre_idIA']))) {header("Location: IAoffres.php");} // Si l'id n'existe pas, on retourne à la page des offres
                        if (isset($_GET["id"])) { 
                        $_SESSION['offre_idIA']=$_GET["id"];} // On récupère l'id de l'offre à modifier
                
                        // Récupérer entreprise_id dans la base de donnée offre
                        $Requete=$BDD->prepare("SELECT entreprise_id FROM OFFRE WHERE offre_id=?");
                        $Requete->execute(array($_SESSION['offre_idIA']));
                        if ($Requete->rowcount()==0) {header("Location: IAoffres.php");}
                        
                        $entreprise_id = $Requete -> fetch();
                        //Récupération des informations de l'entreprise lié à l'offre                        
                        $Requete= "SELECT * FROM ENTREPRISE WHERE entreprise_id= ".$entreprise_id['entreprise_id'];
                        $resultat = $BDD -> query($Requete);
                        $ligne = $resultat -> fetch(); 
                        
                        //Adresse non obligatoire
                        //Récupérer adresse_id si elle existe
                        $Requete= "SELECT adresse_id FROM OFFRE WHERE offre_id= ".$_SESSION['offre_idIA'];
                        $resultat = $BDD -> query($Requete);
                        $adresse_id = $resultat -> fetch();
                        if ($adresse_id['adresse_id'] != null)    
                        {
                        $Requete= "SELECT * FROM ADRESSE WHERE adresse_id= ".$adresse_id['adresse_id'];
                        $resultat = $BDD -> query($Requete);
                        $ligneA = $resultat -> fetch(); }
                        ?>
                        
                        <!-- On pré-remplit le formulaire avec les informations qui existent ou avec les nouvelles informations insérées -->
                        <tr><td><label for="nomE">Nom* : </label></td><td><input type="text" name="nomE" id="nomE" required value="<?php if(isset($_SESSION['nomE'])) { echo $_SESSION['nomE'] ; }  else{ echo $ligne['entreprise_nom'];}?>"/></td></tr>
                        <tr><td><label for="siteE">Site Internet : </label></td><td><input type="url" name="siteE" id="siteE" value="<?php if(isset($_SESSION['siteE'])) { echo $_SESSION['siteE'] ; }else{ echo $ligne['entreprise_siteInternet'];}?>"/></td></tr>
                        <tr><td><label for="adresseE">Adresse : </label></td><td><input type="text" name="adresseE" id="adresseE" value="<?php if(isset($_SESSION['adresseE'])) { echo $_SESSION['adresseE'] ; } else{ if ($adresse_id['adresse_id'] != null) echo $ligneA['adresse_voie'];}?>"/></td></tr>
                        <tr><td><label for="villeE">Ville : </label></td><td><input type="text" name="villeE" id="villeE" value="<?php if(isset($_SESSION['villeE'])) { echo $_SESSION['villeE'] ; } else{ if ($adresse_id['adresse_id'] != null) echo $ligneA['adresse_ville'];}?>"/></td></tr>
                        <tr><td><label for="cpE">Code Postal : </label></td><td><input type="text" name="cpE" id="cpE" value="<?php if(isset($_SESSION['cpE'])) { echo $_SESSION['cpE'] ; } else{ if ($adresse_id['adresse_id'] != null) echo $ligneA['adresse_cp'];} ?>" /></td></tr>
                        <tr><td><label for="paysE">Pays : </label></td><td><input type="text" name="paysE" id="paysE" value="<?php if(isset($_SESSION['paysE'])) { echo $_SESSION['paysE'];} else{ if ($adresse_id['adresse_id'] != null) echo $ligneA['adresse_pays'];}?>" /></td></tr>
                        <tr><td><label for="descripCE">Decription courte : </label></td><td><input type="text" name="descripCE" id="descripCE" value="<?php if(isset($_SESSION['descripCE'])) { echo $_SESSION['descripCE'] ; } else{ echo $ligne['entreprise_descrCourte'];}?>"/></td></tr>
                        <tr><td><label for="descripLE">Description longue*: </label></td><td>
                                <textarea rows="4" name="descripLE" id="descripLE" required ><?php if(isset($_SESSION['descripLE'])) { echo $_SESSION['descripLE'] ; }else{ echo $ligne['entreprise_descrLong'];} ?></textarea></td></tr> 
                        <tr><td><label for="logoE">Logo : </label></td><td><input type="file" name="logoE" id="logoE" /></td>
                            <td class="erreur"><?php if(isset ($_SESSION['erreurlogoE'])){ if($_SESSION['erreurlogoE']==true) { echo "Reuploadez l'image."; }} 
                                      if(isset ($_SESSION['erreurIext'])){  if($_SESSION['erreurIext']==true) { echo "Vous devez uploader un fichier de type png, gif, jpg, jpeg..."; }}
                                      if(isset ($_SESSION['erreurItaille'])){ if($_SESSION['erreurItaille']==true) { echo "L\'image dépasse la taille max"; }}
                            ?></td></tr>
                    </table>
                    </br></br></fieldset>
                
                <fieldset><legend>Contact</legend>
                    <table class="formulaire">
                        <?php // Récupérer Contact_id dans la base de donnée offre 
                        $Requete= "SELECT contact_id FROM OFFRE WHERE offre_id= ".$_SESSION['offre_idIA'];
                        $resultat = $BDD -> query($Requete);
                        $contact_id = $resultat -> fetch();
                                                
                        $Requete= "SELECT * FROM CONTACT WHERE contact_id= ".$contact_id['contact_id'];
                        $resultat = $BDD -> query($Requete);
                        $ligne = $resultat -> fetch(); ?>
                        
                        <!-- On pré-remplit le formulaire avec les informations qui existent ou avec les nouvelles informations insérées -->
                        <tr><td><label for="nomC">Nom* : </label></td><td><input type="text" name="nomC" id="nomC" required value="<?php if(isset($_SESSION['nomC'])) { echo $_SESSION['nomC'];} else{ echo $ligne['contact_nom'];} ?>" /></td></tr>
                        <tr><td><label for="prenomC">Prénom : </label></td><td><input type="text" name="prenomC" id="prenomC" value="<?php if(isset($_SESSION['prenomC'])) { echo $_SESSION['prenomC'];} else{ echo $ligne['contact_prenom'];} ?>" /></td></tr>
                        <tr><td><label for="mailC">Mail* : </label></td><td><input type="email" name="mailC" id="mailC" required  value="<?php if(isset($_SESSION['mailC'])) { echo $_SESSION['mailC'];} else{ echo $ligne['contact_mail'];} ?>" /></td></tr>
                        <tr><td><label for="telC">Tel : </label></td><td><input type="text" name="telC" id="telC" value="<?php if(isset($_SESSION['telC'])) { echo $_SESSION['telC'];} else{ echo $ligne['contact_tel'];} ?>" /></td></tr>
                    </table>
                </br></br></fieldset>
                
                <fieldset><legend>Offre</legend>
                <table class="formulaire">
                    <?php $Requete= "SELECT * FROM OFFRE WHERE offre_id= ".$_SESSION['offre_idIA'];
                        $resultat = $BDD -> query($Requete);
                        $ligne = $resultat -> fetch(); ?>
                    
                    <!-- On pré-remplit le formulaire avec les informations qui existent ou avec les nouvelles informations insérées -->
                    <tr><td><label for="profilO">Profil* : </label></td><td><select name="profilO" id="ProfilO" required >
                                <option value="Stage" <?php if(isset($_SESSION['profilO'])&&($_SESSION['profilO']=="Stage")) { echo "selected" ; } else{ if($ligne['offre_profil']=="Stage") echo "selected" ;} ?>>Stage</option>
                                <option value="Emploi" <?php if(isset($_SESSION['profilO'])&&($_SESSION['profilO']=="Emploi")) { echo "selected" ;} else{ if($ligne['offre_profil']=="Emploi") echo "selected" ;} ?>>Emploi</option>
                            </select></td></tr>
                        <tr><td><label for="nomO">Nom de l'offre* : </label></td><td><input type="text" name="nomO" id="nomO" required value="<?php if(isset($_SESSION['nomO'])) { echo $_SESSION['nomO'] ; }else{ echo $ligne['offre_nom'];} ?>" /></td></tr>
                        <tr><td><label for="dateDO">Date de début (YYYY-mm-dd): </label></td><td><input type="date" name="dateDO" id="dateDO" value="<?php if(isset($_SESSION['dateDO'])) { echo $_SESSION['dateDO'] ; } else{ if($ligne['offre_dateDeb'] != "0000-00-00") echo $ligne['offre_dateDeb'];}?>"/></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurdateDO'])){ if($_SESSION['erreurdateDO']==true) { echo "Date incorrecte (ex : YYYY-mm-jj)" ; }} ?></td></tr>
                        <tr><td><label for="dureeO">Durée : </label></td><td><input type="text" name="dureeO" id="dureeO" value="<?php if(isset($_SESSION['dureeO'])) { echo $_SESSION['dureeO'] ; }else{ echo $ligne['offre_duree'];} ?>"/></td></tr>
                        <tr><td><label for="remunO">Rémunération : </label></td><td>
                                <?php //Séparer renumO1 et renumO2
                                $renumO=$ligne['offre_renum'] ;
                                $i=0;
                                $renumO1chaine="";
                                $renumO2="";
                                while ($renumO[$i] != " ")
                                {
                                    $renumO1chaine.=$renumO[$i]; // Ajoute les chiffres
                                    $i ++;
                                }
                                $i++; // pour passer l'espace
                                for ($i; $i < strlen($renumO);$i++)
                                {
                                   $renumO2 .= $renumO[$i]; // ajoute les caractères
                                }
                                //Convertir la chaine 1 en nombre
                                $renumO1= intval($renumO1chaine);?>
                                <input type="number" name="remunO1" id="remunO1" min="0" required  value="<?php if(isset($_SESSION['remunO1'])) { echo $_SESSION['remunO1'] ; } else{ echo $renumO1;}?>"/> <!-- obligatoire pour selection obligatoire de remunO2-->
                                <select name="remunO2" id="remunO2" required >
                                <option value="euros/Semaine" <?php if(isset($_SESSION['remunO2'])&&($_SESSION['remunO2']=="euros/Semaine")) { echo "selected" ; } else{ if($renumO2=="euros/Semaine") echo "selected" ;}?>>euros/Semaine</option>
                                <option value="euros/Mois" <?php if(isset($_SESSION['remunO2'])&&($_SESSION['remunO2']=="euros/Mois")) { echo "selected" ; }  else{ if($renumO2=="euros/Mois") echo "selected" ;}?>>euros/Mois</option>
                                <option value="euros/Stage Complet" <?php if(isset($_SESSION['remunO2'])&&($_SESSION['remunO2']=="euros/Stage Complet")) { echo "selected" ;}  else{ if($renumO2=="euros/Stage Complet") echo "selected" ;}?>>euros/Stage complet</option>
                            </select></td></tr>
                        <tr><td><label for="descripCO">Decription courte : </label></td><td><input type="text" name="descripCO" id="descripCO"  value="<?php if(isset($_SESSION['descripCO'])) { echo $_SESSION['descripCO'] ; }else{ echo $ligne['offre_descrCourte'];} ?>"/></td></tr>
                        <tr><td><label for="descripLO">Description longue*: </label></td><td>
                                <textarea rows="4" name="descripLO" id="descripLO" required><?php if(isset($_SESSION['descripLO'])) { echo $_SESSION['descripLO'] ; } else{ echo $ligne['offre_descrLongue'];} ?></textarea> </td></tr>
                        <tr><td><label for="fichierO">Fichier : </label></td><td><input type="file" name="fichierO" id="fichierO" /></td>
                            <td class="erreur"><?php if(isset ($_SESSION['erreurfichierO'])){ if($_SESSION['erreurfichierO']==true) { echo "Reuploadez le fichier."; }} 
                                      if(isset ($_SESSION['erreurFext'])){  if($_SESSION['erreurFext']==true) { echo "Vous devez uploader un fichier de type pdf, txt, docx, pptx, xlsx, odt,  png, gif, jpg, ou jpeg."; }}
                                      if(isset ($_SESSION['erreurFtaille'])){ if($_SESSION['erreurFtaille']==true) { echo "Le fichier dépasse la taille max"; }}
                            ?></td></tr>
                </table>
                </br></br></fieldset>
                
                <!-- Modification mot de passe -->   
                <fieldset> <legend>Sécurité</legend>
                    <table class="formulaire">
                <tr><td><label for="mdpO">Nouveau mot de passe : </label></td><td><input type="password" name="mdpO" id="mdpO" /></td> <!-- On ne retient pas le mdp ni on l'affiche -->
                            <td class="erreur"><?php if(isset ($_SESSION['erreurmdpO'])){ if($_SESSION['erreurmdpO']==true) { echo "Votre mot de passe doit contenir 4 caractères minimum" ; }} ?></td></tr>
                </table>
                <br /><br /></fieldset> 
                
                <br />
                <div class="submit"><input type="submit" value="Modifier" /><br /><br /></div>
                </div>
            </form>
            
        </div>
    </body>
    <?php include("includes/footer.php"); ?>
</html>
