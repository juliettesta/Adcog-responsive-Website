<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include("includes/head.php");
      include("includes/header.php");
      include("includes/esTuConnecte.php");?>
        <title>Mon profil</title> 
    </head>
    <body>
        <?php require("db/connect.php"); // Accès à la BDD ?>
        <?php 
        include("includes/ViderSessionFormulaire.php"); // Réinitialise les variables des formulaires
        // Affiche si le profil vient d'être modifié
        if(isset ($_SESSION['ProfilModifie'])){
        if ($_SESSION['ProfilModifie']== true) {
            print "<div class='confirmation'> Profil modifié </div>";
            $_SESSION['ProfilModifie']= false;
        }}
        ?>
        <div class="container"> 
            
            
            
            <!--  Formulaire modifier utilisateur -->
            <h1> Mon Profil </h1> </br></br>

                <div class="formulaire">
                
                    <table class="formulaire">
                        <?php 
                        //On récupère les informations de l'utilisateur connecté                     
                        $requete= "SELECT * FROM UTILISATEUR WHERE utilisateur_id=".$_SESSION['id'];
                        $resultat = $BDD -> query($requete);
                        $ligne = $resultat -> fetch(); 
                        //Récupération de l'adresse si elle existe
                        if ($ligne['adresse_id'] != null)    
                        {
                        $Requete= "SELECT * FROM ADRESSE WHERE adresse_id= ".$ligne['adresse_id'];
                        $resultatA = $BDD -> query($Requete);
                        $ligneA = $resultatA -> fetch(); }?>
                        
                        <!-- On affiche les informations qui existent -->
                        <tr><td><label for="nomU">Nom : </label></td><td><?php echo $ligne['utilisateur_nom']; ?></td></tr>
                        <tr><td><label for="prenomU">Prénom : </label></td><td><?php echo $ligne['utilisateur_prenom']; ?></td></tr>
                        <tr><td><label for="dateneeU">Date de naissance (YYYY-mm-dd) : </label></td><td><?php if ($ligne['utilisateur_dateNaissance'] != "0000-00-00") {echo $ligne['utilisateur_dateNaissance'];} ?></td></tr>
                        <tr><td><label for="dateInscriptionU">Date d'inscription: </label></td><td><?php echo $ligne['utilisateur_dateInscription']; ?> </td></tr>
                        <tr><td><label for="statutU">Statut : </label></td><td><?php echo $ligne['utilisateur_statut']; ?> </td></tr>
                        <tr><td><label for="mailU">Mail : </label></td><td><?php echo $ligne['utilisateur_mail']; ?></td></tr>
                        <tr><td><label for="telU">Tel : </label></td><td><?php echo $ligne['utilisateur_tel'];?></td></tr>
                        <tr><td><label for="loginU">Login : </label></td><td><?php echo $ligne['utilisateur_login'];?></td></tr>
                        <tr><td><label for="mdpU">Mot de passe : </label></td><td> ***** </td> <!-- On ne retient pas le mdp--></tr>
                        <tr><td><label for="adresseU">Adresse : </label></td><td><?php if ($ligne['adresse_id'] != null) echo $ligneA['adresse_voie']; ?></td></tr>
                        <tr><td><label for="villeU">Ville : </label></td><td><?php if ($ligne['adresse_id'] != null) echo $ligneA['adresse_ville']; ?></td></tr>
                        <tr><td><label for="cpU">Code Postal : </label></td><td><?php if ($ligne['adresse_id'] != null) echo $ligneA['adresse_cp']; ?></td></tr>
                        <tr><td><label for="paysU">Pays : </label></td><td> <?php if ($ligne['adresse_id'] != null) echo $ligneA['adresse_pays']; ?> </td></tr>
                        
                    </table>
                    </br></br>
                    <div class="submit"><a href='ModifierProfil.php'> <input type='submit' value= 'Modifier' /></a></div>   
                                    </br></br>

                </div>
            
            
        </div>
    </body>
    <?php include("includes/footer.php"); ?>
</html>
