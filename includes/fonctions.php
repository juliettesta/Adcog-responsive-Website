<?php
//Fonction qui permet d'afficher toutes les informations concernant une offre 
//en prenant en argument son idEmploi qui est la clé primaire
//et un booléen qui permet d'alterner la couleur de l'affichage des offres pour une meilleure visibilité
function AfficherEmploi($offre_id,$bool)
{
    require("db/connect.php");
    $requete=$BDD->prepare("SELECT * FROM offre WHERE offre_id = ?");
    $requete->execute(array($offre_id));
    //on obtient la ligne entière de la BDD décrivant l'offre d'emploi, stockée dans $offre
    $offre=$requete->fetch();        
    //on récupère les informations de l'entreprise liée à l'offre
    $requete='SELECT * FROM entreprise WHERE entreprise_id ='. $offre ["entreprise_id"];
    $resultat=$BDD->query($requete);
    $entreprise=$resultat->fetch();
    //on récupère les informations de l'adresse liée à l'offre si elle existe
    if ($offre ["adresse_id"]!=NULL)
    {
        $requete='SELECT * FROM adresse WHERE adresse_id ='. $offre ["adresse_id"];
        $resultat=$BDD->query($requete);
        $adresse=$resultat->fetch();
    }
    //on regarde si l'utilisateur a sauvegardé l'offre
    $requete='SELECT * FROM liaison_panier,offre WHERE utilisateur_id='.$_SESSION['id'].' AND offre_valide=1 '
            . 'AND offre_signalee=0 AND liaison_panier.offre_id='.$offre_id;
    $resultatLiaison=$BDD->query($requete);
    if ($resultatLiaison->rowCount()!=0)
    {
        $liaison=$resultatLiaison->fetch();
        $postule=$liaison['liaisonPanier_postule'];
        $save=$liaison['liaisonPanier_save'];
        $liaison_id=$liaison['liaisonPanier_id'];
    }
    if ($bool) print '<div class="row centreOffre" style="background-color:#ccc;">';
    if (!$bool) print '<div class="row centreOffre" style="background-color:#ddd;">';       
    print '
    <div class="col-xs-2 col-sm-3 col-md-9 col-lg-2">
        <a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">
        <img class="imageOffre" alt="logo_entreprise" src="logos/'.$entreprise['entreprise_logo'].'"/></a><br/><h4>'
        . '<a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">'.
        $entreprise['entreprise_nom'].'</a><h4/>
    </div>
    <div class="col-xs-10 col-sm-9 col-md-3 col-lg-3 "> 
        <div class="margeSimpson">
        <h2> <a href="detailEmploi.php?offre='.$offre['offre_id'].'">'.
            $offre['offre_nom'].'</a></h2>';
            if ($offre ["adresse_id"]!=NULL)
            {
                print $adresse['adresse_ville'].'<br/>';
            }
            else { print '<br/>';}
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
    </a><br/><br/>';

    //signalement de l'offre
    print '<button type="button" id="btn_signale'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctSignale('.$offre_id.')">Signaler</button>';

    print '<br/><br/>';
    //avez-vous save ?
    if (isset($save) && ($save==1)) print '<a type="button" id="btn_save'.$offre_id.'" class="btn " onClick="fctDejaSave2('.$liaison_id.','.$offre_id.')"><img src="images/panierMoins.PNG" class="imagePanier" alt="..."></a>';
    else if (isset($save) && ($save==0)) { print '<a type="button" id="btn_save'.$offre_id.'" class="btn " onClick="fctSave2('.$liaison_id.','.$offre_id.')"><img src="images/panierPlus.PNG" class="imagePanier" alt="..."></a>';}         
    else { print '<a type="button" id="btn_save'.$offre_id.'" class="btn " onClick="fctCreerSave2('.$_SESSION['id'].','.$offre_id.')"><img src="images/panierPlus.PNG" class="imagePanier" alt="..."></a>';}

    print '<br/><br/>';

    //avez-vous postulé?
    //l'offre est dans son panier et il a postulé
    if (isset($postule) && ($postule==1)) print '<button type="button" id="btn_postule'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctDejaPostuler('.$_SESSION['id'].','.$liaison_id.','.$offre_id.')"><i>déjà postulé</i></button>';
    //l'offre est dans son panier mais il n'a pas postulé
    else if (isset($postule) && ($postule==0)){ print '<button type="button" id="btn_postule'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctPostuler('.$_SESSION['id'].','.$liaison_id.','.$offre_id.')">postuler</button>';}
    else { print '<button type="button" id="btn_postule'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctCreerPostuler('.$_SESSION['id'].','.$offre_id.')">postuler</button>';}
    print '</div></div>';
}
