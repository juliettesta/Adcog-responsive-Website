<?php session_start(); ?>
<!DOCTYPE html>

<html>
    <head>
        <?php include("includes/head.php");
      include("includes/header.php");
      include("includes/esTuConnecte.php");?>
        <title>Modifier profil</title> 
    </head>
    <body>
        <?php require("db/connect.php"); // Accès à la BDD ?>
        <div class="container"> 
            
            <!--  Formulaire Modifier utilisateurs -->
            <h1> Modifier Utilisateur </h1> </br></br>
            * mention obligatoire  </br></br>

            <form method="POST" action="TraitementModifierProfil.php">
                
                <div class="formulaire">
                <fieldset>
                    <table class="formulaire">
                        <?php 
                        //Récupération des informations de l'utilisateur connecté
                        $requete= "SELECT * FROM UTILISATEUR WHERE utilisateur_id=".$_SESSION['id'];
                        $resultat = $BDD -> query($requete);
                        $ligne = $resultat -> fetch(); 
 
                        //Récupération de l'adresse
                        if ($ligne['adresse_id'] != null)    
                        {
                        $Requete= "SELECT * FROM ADRESSE WHERE adresse_id= ".$ligne['adresse_id'];
                        $resultatA = $BDD -> query($Requete);
                        $ligneA = $resultatA -> fetch(); } ?>
                        
                        <!-- Si l'information existe on l'affiche sinon on affiche un champ vide tant que l'utilisateur n'a rien rentré -->
                        <tr><td><label for="nomU">Nom : </label></td><td><input type="text" name="nomU" id="nomU" value="<?php if(isset($_SESSION['nomU'])) { echo $_SESSION['nomU'] ;} else{ echo $ligne['utilisateur_nom'];}?>"/></td></tr>
                        <tr><td><label for="prenomU">Prénom : </label></td><td><input type="text" name="prenomU" id="prenomU" value="<?php if(isset($_SESSION['prenomU'])) { echo $_SESSION['prenomU'] ;} else{ echo $ligne['utilisateur_prenom'];}?>"/></td></tr>
                        <tr><td><label for="dateneeU">Date de naissance (YYYY-mm-dd): </label></td><td><input type="date" name="dateneeU" id="dateneeU" value="<?php if(isset($_SESSION['dateneeU'])) { echo $_SESSION['dateneeU'] ;} else{ if ($ligne['utilisateur_dateNaissance'] != "0000-00-00") {echo $ligne['utilisateur_dateNaissance'];}} ?>"/></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurdateneeU'])){ if($_SESSION['erreurdateneeU']==true) { echo "Date incorrecte (ex : YYYY-mm-jj)" ; }} ?></td></tr>
                        <tr><td><label for="dateInscriptionU">Date d'inscription: </label></td><td><?php echo $ligne['utilisateur_dateInscription']; ?> </td></tr>
                        <tr><td><label for="statutU">Statut : </label></td><td><?php echo $ligne['utilisateur_statut']; ?> </td></tr>
                        <tr><td><label for="mailU">Mail : </label></td><td><input type="email" name="mailU" id="mailU" value="<?php if(isset($_SESSION['mailU'])) { echo $_SESSION['mailU'] ;} else{ echo $ligne['utilisateur_mail'];}?>"/></td></tr>
                        <tr><td><label for="telU">Tel : </label></td><td><input type="text" name="telU" id="telU" value="<?php if(isset($_SESSION['telU'])) { echo $_SESSION['telU'] ;} else{ echo $ligne['utilisateur_tel'];}?>"/></td></tr>
                        <tr><td><label for="loginU">Login : </label></td><td> <?php echo $ligne['utilisateur_login'];?> </td></tr>
                        <tr><td><label for="mdpU">Nouveau mot de passe : </label></td><td><input type="password" name="mdpU" id="mdpU"/></td> <!-- On ne retient pas le mdp--></tr>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurmdpU'])){ if($_SESSION['erreurmdpU']==true) { echo "Votre mot de passe doit contenir 4 caractères minimum" ; }} ?></td></tr>
                        <tr><td><label for="adresseU">Adresse : </label></td><td><input type="text" name="adresseU" id="adresseU" value="<?php if(isset($_SESSION['adresseU'])) { echo $_SESSION['adresseU'] ;} else{ if ($ligne['adresse_id'] != null) echo $ligneA['adresse_voie'];} ?>"/></td></tr>
                        <tr><td><label for="villeU">Ville : </label></td><td><input type="text" name="villeU" id="villeU"  value="<?php if(isset($_SESSION['villeU'])) { echo $_SESSION['villeU'] ;} else{ if ($ligne['adresse_id'] != null) echo $ligneA['adresse_ville'];} ?>"/></td></tr>
                        <tr><td><label for="cpU">Code Postal : </label></td><td><input type="text" name="cpU" id="cpU" value="<?php if(isset($_SESSION['cpU'])) { echo $_SESSION['cpU'] ;} else{ if ($ligne['adresse_id'] != null) echo $ligneA['adresse_cp'];} ?>"/></td></tr>
                        <tr><td><label for="paysU">Pays : </label></td><td><input type="text" name="paysU" id="paysU" value="<?php if(isset($_SESSION['paysU'])) { echo $_SESSION['paysU'] ;} else{ if ($ligne['adresse_id'] != null) echo $ligneA['adresse_pays'];} ?>" /></td></tr>
                        
                    </table>
                    </br></br></fieldset>
                       <div class="submit"><input type="submit" value="Modifier" /><br /><br /></div>
                
                </div></form>
            
        </div>
    </body>
    <?php include("includes/footer.php"); ?>
</html>
