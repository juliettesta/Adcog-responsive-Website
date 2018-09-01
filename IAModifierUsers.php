<?php session_start(); ?>
<!DOCTYPE html>

<html>
    <head>
        <?php include("includes/head.php");
      include("includes/header.php");
      include("includes/esTuAdmin.php");
?>
        <title>Modifier utilisateur</title> 
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
        

        <!--  Formulaire Modifier utilisateurs -->
            <h1> Modifier Utilisateur </h1>
            <div class="Adroite">
                <?php
                if (!isset($_GET["id"]) && (!isset($_SESSION['users_id']))) {header("Location: IAusers.php");} // Si on rentre un id qui n'existe pas, on revient à la page des utilisateurs
                if (isset($_GET["id"])) {
                $_SESSION['users_id']=$_GET["id"]; }  // Récupérer id de l'utilisateur
                
                // Bouton supprimer utilisateur
                print ' 
                       <button type="button" class="btn btnSupprimer" onClick="fctSupprimerUser('.$_GET["id"].')">Supprimer l\'utilisateur</button>
                        ';?>
            </div>
            * mention obligatoire </br></br>
            <form method="POST" action="IATraitementModifierUsers.php">
                
                <div class="formulaire">
                <fieldset>
                    <table class="formulaire">
                        <?php 
                        // Récupérer les informations de l'utilisateur                       
                        //$requete= "SELECT * FROM UTILISATEUR WHERE utilisateur_id= ".$_SESSION['users_id'];
                        //$resultat = $BDD -> query($requete);
                        //if ($resultat->rowcount()==0) {header("Location: IAusers.php");}
                        //$ligne = $resultat -> fetch(); 
                        
                        $Requete=$BDD->prepare("SELECT * FROM UTILISATEUR WHERE utilisateur_id=?");
                        $Requete->execute(array($_SESSION['users_id']));
                        if ($Requete->rowcount()==0) {header("Location: IAusers.php");}
                        
                        $ligne = $Requete -> fetch();
                        
                        //Récupération de l'adresse
                        if ($ligne['adresse_id'] != null)    
                        {
                        $Requete= "SELECT * FROM ADRESSE WHERE adresse_id= ".$ligne['adresse_id'];
                        $resultatA = $BDD -> query($Requete);
                        $ligneA = $resultatA -> fetch(); 
                        }
                        ?>
                        <!-- On pré-remplit le formulaire avec les informations qui existent ou avec les nouvelles informations insérées -->
                        <tr><td><label for="nomU">Nom : </label></td><td><input type="text" name="nomU" id="nomU" value="<?php if(isset($_SESSION['nomU'])) { echo $_SESSION['nomU'] ;} else{ echo $ligne['utilisateur_nom'];}?>"/></td></tr>
                        <tr><td><label for="prenomU">Prénom : </label></td><td><input type="text" name="prenomU" id="prenomU" value="<?php if(isset($_SESSION['prenomU'])) { echo $_SESSION['prenomU'] ;} else{ echo $ligne['utilisateur_prenom'];}?>"/></td></tr>
                        <tr><td><label for="dateneeU">Date de naissance (YYYY-mm-dd) : </label></td><td><input type="date" name="dateneeU" id="dateneeU" value="<?php if(isset($_SESSION['dateneeU'])) { echo $_SESSION['dateneeU'] ;} else{ if ($ligne['utilisateur_dateNaissance'] != "0000-00-00") {echo $ligne['utilisateur_dateNaissance'];}} ?>"/></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurdateneeU'])){ if($_SESSION['erreurdateneeU']==true) { echo "Date incorrecte (ex : YYYY-mm-jj)" ; }} ?></td></tr>
                        <tr><td><label for="statutU">Statut* : </label></td><td><select name="statutU" id="statutU" required >
                                <option value="normal" <?php if(isset($_SESSION['statutU'])&&($_SESSION['statutU']=="normal")) { echo "selected" ;} else{ if($ligne['utilisateur_statut']=="normal") echo "selected" ;} ?> >Normal</option>
                                <option value="adherent" <?php if(isset($_SESSION['statutU'])&&($_SESSION['statutU']=="adherent")) { echo "selected" ;} else{ if($ligne['utilisateur_statut']=="adherent") echo "selected" ;} ?> >Adherent</option>
                                <option value="admin" <?php if(isset($_SESSION['statutU'])&&($_SESSION['statutU']=="admin")) { echo "selected" ;} else{ if($ligne['utilisateur_statut']=="admin") echo "selected" ;} ?> >Admin</option>
                            </select></td></tr>
                        <tr><td><label for="mailU">Mail : </label></td><td><input type="email" name="mailU" id="mailU" value="<?php if(isset($_SESSION['mailU'])) { echo $_SESSION['mailU'] ;} else{ echo $ligne['utilisateur_mail'];}?>"/></td></tr>
                        <tr><td><label for="telU">Tel : </label></td><td><input type="text" name="telU" id="telU" value="<?php if(isset($_SESSION['telU'])) { echo $_SESSION['telU'] ;} else{ echo $ligne['utilisateur_tel'];}?>"/></td></tr>
                        <tr><td><label for="loginU">Login* : </label></td><td><input type="text" name="loginU" id="loginU" required value="<?php if(isset($_SESSION['loginU'])) { echo $_SESSION['loginU'] ;} else{ echo $ligne['utilisateur_login'];}?>"/></td>
                        <td class="erreur"><?php if(isset ($_SESSION['erreurloginU'])){ if($_SESSION['erreurloginU']==true) { echo "Login déjà utilisé" ; }} ?></td></tr>
                        <tr><td><label for="mdpU">Nouveau mot de passe : </label></td><td><input type="password" name="mdpU" id="mdpU" /></td> <!-- On ne retient pas le mdp ni on l'affiche -->
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
