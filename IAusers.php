<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
      include("includes/head.php");
      include("includes/header.php");
      include("includes/esTuAdmin.php");;?>
        <title>Gestion entreprises et contacts</title>
    </head>
    <body>
        <?php require("db/connect.php"); // Accès à la BDD 
        include("includes/ViderSessionFormulaire.php");?>
        
        <!-- Si un utilisateur a été ajouté -->
        <?php 
        if(isset ($_SESSION['IAUtilisateurAjoute'])){
        if ($_SESSION['IAUtilisateurAjoute']== true) {
            print "<div class='confirmation'> Utilisateur ajouté </div>";
            $_SESSION['IAUtilisateurAjoute']= false;
        }}
        // Si l'utilisateur a été modifié
        if(isset ($_SESSION['IAUtilisateurModifie'])){
        if ($_SESSION['IAUtilisateurModifie']== true) {
            print "<div class='confirmation'> Utilisateur modifié </div>";
            $_SESSION['IAUtilisateurModifie']= false;
        }}
      ?>
        
        
        <div class="container"> 
        <!-- Navigation Admin -->
        <nav  class="navbar navbar-default gris" role="navigation">
             <ul class="nav navbar-nav">
                 <li><a href="IAoffres.php" class="navPrincipale">Gérer les offres</a></li>
                 <li><a href="IAusers.php" class="navCouleurContainer"> Gérer les utilisateurs</a></li>
                 <li><a href="IAEntreprises.php" class="navPrincipale"> Gérer les entreprises</a></li>
                 <li><a href="IAContacts.php" class="navPrincipale"> Gérer les contacts</a></li>
             </ul>
        </nav>
        
        
        <!--  Ajouter Users --></br>
        <a href='IAAjoutUsers.php'> <input type="submit" value="Ajouter utilisateur" /></a><br/>
        <div class="enBasADroite margeDroite">
            <div class="btn-group ">
              <button type="button" class="btn btn-default dropdown-toggle grisclair" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="IAUsers.php?tri=recent">Inscription récente</a></li>
                <li><a href="IAUsers.php?tri=ancien">Inscription ancienne</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="IAUsers.php?tri=statut">Statut</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="IAUsers.php?tri=nom">Nom</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="IAUsers.php?tri=modifie">Valider/Modifier</a></li>
              </ul>
            </div></div>
        <!--  POUR CHAQUE users -->
        <?php
        if ( (isset($_GET['tri']) && $_GET['tri']=="recent") || !(isset($_GET['tri'])) )
        { 
            $requete='SELECT * FROM utilisateur ORDER BY utilisateur_dateInscription DESC'; 
        }
        if ( (isset($_GET['tri']) && $_GET['tri']=="ancien"))
        { 
            $requete='SELECT * FROM utilisateur ORDER BY utilisateur_dateInscription'; 
        }    
        if ( (isset($_GET['tri']) && $_GET['tri']=="statut"))
        { 
            $requete='SELECT * FROM utilisateur ORDER BY utilisateur_statut'; 
        } 
        if ( (isset($_GET['tri']) && $_GET['tri']=="nom"))
        { 
            $requete='SELECT * FROM utilisateur ORDER BY utilisateur_nom'; 
        } 
        if ( (isset($_GET['tri']) && $_GET['tri']=="modifie"))
        { 
            $requete='SELECT * FROM utilisateur ORDER BY utilisateur_valide'; 
        }
        $resultat=$BDD->query($requete);
        $tableauResultat=$resultat->fetchall();
        $bool=true;
        print '<div class="row centreOffre fondClair bordureDouce">'
            . '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Statut</div>'
            . '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">Nom</div>'
            . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Date de naissance</div>'
            . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Date d\'inscription</div>'
            . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Login</div>'
            . '</div>';
        foreach($tableauResultat as $user)
        {
            $bool=!$bool;
            AfficherUtilisateur($user,$bool);
        }
        ?>
            
            </br>
        </div>
                
                
                
       
    </body>
    <?php include("includes/footer.php"); ?>
</html>



<?php
function  AfficherUtilisateur($id,$bool)
{
    if ($id["utilisateur_valide"]==0)
    {
         if ($bool) print '<div class="row centreOffre fondJauneFonce bordureDouce">';
         else print '<div class="row centreOffre fondJauneClair bordureDouce">';
    }
    else if ($bool)
    {
        print '<div class="row centreOffre fondClair bordureDouce">';
    }
    else {print '<div class="row centreOffre fondFonce bordureDouce">';} 
    print '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">'.
        $id["utilisateur_statut"].'</div> '.
            '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">';
        if ($id["utilisateur_nom"]!=NULL)print $id["utilisateur_nom"].' ';
        if($id["utilisateur_prenom"] != NULL) print $id["utilisateur_prenom"];
        print '</div> '.
            '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
        if ($id["utilisateur_dateNaissance"]!="0000-00-00") print $id["utilisateur_dateNaissance"];
        print '</div>'.
            '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'.
        $id["utilisateur_dateInscription"].'
        </div><div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'.
        $id["utilisateur_login"].'
        </div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">';
        if ($id["utilisateur_valide"]==1)
        {print
        '<a class= "btn" href="IAModifierUsers.php?id='.$id["utilisateur_id"].'" <input type="submit" value="Modifier" />Modifier</a>';}
        if ($id["utilisateur_valide"]==0)
        {print
        '<a type="button" class= "btn" onClick="fctValiderUser('.$id["utilisateur_id"].')")> Valider</a>';}
    print '</div></div>';
}

//onClick="fctValiderUser('.$id["utilisateur_id"].')")