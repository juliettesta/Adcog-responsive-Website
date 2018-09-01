<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
      include("includes/head.php");
      include("includes/header.php");
      include("includes/esTuAdmin.php");?>
        <title>Gestion des offres</title>
    </head>
    
    <body>
        <?php require("db/connect.php"); // Accès à la BDD 
        include("includes/ViderSessionFormulaire.php");?>
        <!-- Une offre a-t-elle été modifiée ? -->
        <?php 
        if(isset ($_SESSION['IAOffreModifiee'])){
        if ($_SESSION['IAOffreModifiee']== true) {
            print "<div class='confirmation'> Offre modifiée </div>";
            $_SESSION['IAOffreModifiee']= false;
        }} ?>
        
        <div class="container"> 
        <!-- Navigation Admin -->
        <nav  class="navbar navbar-default gris" role="navigation">
             <ul class="nav navbar-nav">
                 <li><a href="IAoffres.php" class="navCouleurContainer">Gérer les offres</a></li>
                 <li><a href="IAusers.php" class="navPrincipale"> Gérer les utilisateurs</a></li>
                 <li><a href="IAEntreprises.php" class="navPrincipale"> Gérer les entreprises</a></li>
                 <li><a href="IAContacts.php" class="navPrincipale"> Gérer les contacts</a></li>
             </ul>
        </nav>
        
        </br></br>
        <!--  POUR CHAQUE OFFRE -->
            <!--  Si Offre est à valider -->
            <div class="row centreOffre" style="border:1px solid #ddd;">
                <h3>Offres à valider</h3>
                </div>
                    <?php
                        $OffreOk=0;  // L'offre n'est pas en ligne
                        $requete='SELECT * FROM offre WHERE offre_valide="0"';
                        $resultat=$BDD->query($requete);
                        if ($resultat->rowCount()==0)
                        {
                            print '<div class="h5">Aucune offre non validée</div>';
                        }
                        else 
                        {
                            $tableauResultat=$resultat->fetchall();
                            $valide=true; // L'offre est à valider
                            $bool=true; 
                            foreach($tableauResultat as $offre)
                            {
                                $bool=!$bool; // Permet d'alterner les couleurs des lignes à l'affichage
                                AfficherOffre($offre['offre_id'],$valide,$bool, $OffreOk);
                            }
                        }
                    ?>

            <!--  Si Offre signaléee-->
            <div class="row centreOffre" style="border:1px solid #ddd;">
                <h3>Offres signalées</h3>
                </div>                    <?php
                        $OffreOk=0;  // L'offre n'est pas en ligne
                        $requete='SELECT * FROM offre WHERE offre_signalee="1"';
                        $resultat=$BDD->query($requete);
                        if ($resultat->rowCount()==0)
                        {
                            print '<div class="h5">Aucune offre signalée</div>';
                        }
                        else 
                        {
                            $bool=true;
                            $valide=false; // L'offre n'est pas à valider
                            $tableauResultat=$resultat->fetchall();
                            foreach($tableauResultat as $offre)
                            {
                                $bool=!$bool; // Permet d'alterner les couleurs des lignes à l'affichage
                                AfficherOffre($offre['offre_id'],$valide,$bool, $OffreOk);
                            }
                        }
                    ?>
            
            <!--  Si Offre validée et non signalée -->
            <div class="row centreOffre" style="border:1px solid #ddd;">
                <h3>Offres</h3>
                </div>
                    <?php
                        $OffreOk=1; // Offre ni signalé ni non validé donc en ligne
                        $requete='SELECT * FROM offre WHERE offre_valide="1" AND offre_signalee="0"';
                        $resultat=$BDD->query($requete);
                        if ($resultat->rowCount()==0)
                        {
                            print '<div class="h5"> Aucune offre disponible !</div>';
                        }
                        else 
                        {
                            $tableauResultat=$resultat->fetchall();
                            $valide=true; // On doit remplir la variable pour utiliser la fonction mais n'a aucun impact
                            $bool=true;
                            foreach($tableauResultat as $offre)
                            {
                                $bool=!$bool; // Permet d'alterner les couleurs des lignes à l'affichage
                                AfficherOffre($offre['offre_id'],$valide,$bool, $OffreOk);
                            }
                        }
                    ?>
        </div>
        
    </body>
    <?php include("includes/footer.php"); ?>
</html>

<?php
function AfficherOffre($offre_id,$valide,$bool, $OffreOk)
{
    require("db/connect.php"); // conexion BDD
    $requete="SELECT * FROM offre WHERE offre_id = $offre_id";
    $resultat=$BDD->query($requete);
    //on obtient la ligne entière de la BDD décrivant l'offre d'emploi, stockée dans $offre
    $offre=$resultat->fetch();
    //on récupère les informations de l'entreprise liée à l'offre
    $requete='SELECT * FROM entreprise WHERE entreprise_id ='. $offre ["entreprise_id"];
    $resultat=$BDD->query($requete);
    $entreprise=$resultat->fetch();
    //on récupère les informations de l'adresse liée à l'offre
    if ($offre ["adresse_id"] != null) {
    $requete='SELECT * FROM adresse WHERE adresse_id ='. $offre ["adresse_id"];
    $resultat=$BDD->query($requete);
    $adresse=$resultat->fetch();}
    
    // Pour les offres à valider
    if ($OffreOk != 1) { // Si l'offre n'est pas en ligne
        //Pour les offres non valides
        if ($valide) {
            if ($bool) print '<div class="row centreOffre" id="div'.$offre_id.'" style="background-color:#FDF7A6;">';
            else print '<div class="row centreOffre" id="div'.$offre_id.'" style="background-color:#FEFEC4;">';
        }
        // Pour les offres signalées
        if (!$valide) { 
            if($bool)print '<div class="row centreOffre" id="div'.$offre_id.'" style="background-color:#FECD95;">';
            else print '<div class="row centreOffre" id="div'.$offre_id.'" style="background-color:#FEB895;">';
        }      
    }
    else { // Si l'offre est en ligne
        if($bool)print '<div class="row centreOffre" id="div'.$offre_id.'" style="background-color:#DDE1E0;">';
        else print '<div class="row centreOffre" id="div'.$offre_id.'" style="background-color: #C6CDCC;">';
        
    }
    
    print '
    <div class="col-xs-2 col-sm-3 col-md-9 col-lg-2">
        <a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">
        <img class="imageOffre" alt="logoEntreprise" src="logos/'.$entreprise['entreprise_logo'].'"/></a><br/><h4>'
        . '<a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">'.
        $entreprise['entreprise_nom'].'</a><h4/>
    </div>
    <div class="col-xs-10 col-sm-9 col-md-3 col-lg-3 "> 
        <div class="margeSimpson">
        <h2> <a href="detailEmploi.php?offre='.$offre['offre_id'].'">'.
            $offre['offre_nom'].'</a></h2>';
            if (isset($adresse['adresse_ville'])){ // L'adresse n'existe pas forcément 
               print $adresse['adresse_ville'] .'<br/>';}
             print 'Durée : '.$offre['offre_duree']
            . '<br/>Remunération : '.$offre['offre_renum'].
            '<br/><br/><br/><i>postée le '.$offre['offre_datePoste'].'</i>
        </div>
</div>
<div class="col-xs-8 col-sm-9 col-md-9 col-lg-6 "> 
    <div class="margeSimpson2">'.
        $offre['offre_descrCourte'].
    '</div>
</div>
<div class="col-xs-4 col-sm-3 col-md-3 col-lg-1  enBasADroite">
    <a href="detailEmploi.php?offre='.$offre['offre_id'].'">
    <i>voir plus </i>
    </a><br/>';

    //bouton de validation
    if ($OffreOk != 1) { //Si l'offre est en ligne on affiche ni le bouton valider, ni re-valider
        //l'offre est à valider
        if ($valide) { print '<button type="button" id="btn_valide'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctValide('.$offre_id.')"> valider </button>';}
        //l'offre est signalée
        if (!$valide) { print '<button type="button" id="btn_valide'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctValide('.$offre_id.')">re-valider</button>';}
        print '<br/><br/>';
    }
    //bouton de modification
    print '<a href="IAModifierOffre.php?id='.$offre['offre_id'].'" class="btn btn-primary btn-sm " >modifier</a>';
    print '<br/><br/>';
    //bouton de suppression
    print '<button type="button" id="btn_supprime'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctSupprimerOffre('.$offre_id.')">supprimer</button>';

    print '</div></div>';
    }
?>
