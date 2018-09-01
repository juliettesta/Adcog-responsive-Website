<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
    <?php
      include("includes/head.php");
      print     '<title>Panier</title></head>';
      include("includes/header.php");
      //l'utilisateur doit etre connecté
      include("includes/esTuConnecte.php");
    ?>

    
    <body>
        <div class="container">    
            
           <!-- Trier par -->
            <div class="enBasADroite margeDroite">
            <div class="btn-group ">
              <button type="button" class="btn btn-default dropdown-toggle grisclair" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="panierPost.php?tri=recent">+ récent</a></li>
                <li><a href="panierPost.php?tri=ancien">+ ancien</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="panierPost.php?tri=az">A-Z</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="panierPost.php?tri=commenceBientot">Commence bientôt</a></li>
              </ul>
            </div></div>

        <?php
        require("db/connect.php");
        function AfficherOffre($offre_id,$postule,$liaison_id,$save,$bool)
            {
                require("db/connect.php");
                $requete="SELECT * FROM offre WHERE offre_id = $offre_id";
                $resultat=$BDD->query($requete);
                //on obtient la ligne entière de la BDD décrivant l'offre d'emploi, stockée dans $offre
                $offre=$resultat->fetch();
                //on récupère les informations de l'entreprise liée à l'offre
                $requete='SELECT * FROM entreprise WHERE entreprise_id ='. $offre ["entreprise_id"];
                $resultat=$BDD->query($requete);
                $entreprise=$resultat->fetch();
                //on récupère les informations de l'adresse liée à l'offre si elle existe
                if ($offre ["adresse_id"] != null) {
                $requete='SELECT * FROM adresse WHERE adresse_id ='. $offre ["adresse_id"];
                $resultat=$BDD->query($requete);
                $adresse=$resultat->fetch();}

                if ($bool) print '<div class="row centreOffre fondClair">';
                if (!$bool) print '<div class="row centreOffre fondFonce">';   

                print '
                <div class="col-xs-2 col-sm-3 col-md-9 col-lg-2">';
                //affichage entreprise
                print'<a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">
                    <img class="imageOffre"  alt="logoEntreprise" src="logos/'.$entreprise['entreprise_logo'].'"/></a><br/><h4>'
                        . '<a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">'.
                    $entreprise['entreprise_nom'].'</a><h4/>
                </div>
                <div class="col-xs-10 col-sm-9 col-md-3 col-lg-3 "> 
                    <div class="margeSimpson">
                    <h2> <a href="detailEmploi.php?offre='.$offre['offre_id'].'">'.
                        $offre['offre_nom'].'</a></h2>';
                //affichage adresse
                if (isset($adresse)) {print $adresse['adresse_ville'].'<br/>';}
                print   'Durée : '.$offre['offre_duree']
                        . '<br/>Remunération : '.$offre['offre_renum'].
                        '<br/><br/><br/><i>postée le '.$offre['offre_datePoste'].'</i>
                    </div>
            </div>';
            //affichage dscritption
            print'<div class="col-xs-8 col-sm-9 col-md-9 col-lg-6 "> 
                <div class="margeSimpson2">'.
                    $offre['offre_descrCourte'].
                '</div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-1 enBasADroite">
            <br/>
                <a href="detailEmploi.php?offre='.$offre['offre_id'].'">
                <i>voir plus</i>
                </a><br/><br/><br/>';
                         
                //avez-vous save ?
                if (($save==1)) print '<a type="button" id="btn_save'.$offre_id.'" class="btn " onClick="fctDejaSave2('.$liaison_id.','.$offre_id.')"><img src="images/panierMoins.PNG" class="imagePanier" alt="..."></a>';
                else { print '<a type="button" id="btn_save'.$offre_id.'" class="btn " onClick="fctSave2('.$liaison_id.','.$offre_id.')"><img src="images/panierPlus.PNG" class="imagePanier" alt="..."></a>';}         

                print '<br/>';
                
                //avez-vous postulé?
                if ($postule==1) print '<button type="button" id="btn_postule'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctDejaPostuler('.$_SESSION['id'].','.$liaison_id.','.$offre_id.')"><i>déjà postulé</i></button>';
                else { print '<button type="button" id="btn_postule'.$offre_id.'" class="btn btn-primary btn-sm" onClick="fctPostuler('.$_SESSION['id'].','.$liaison_id.','.$offre_id.')">postuler</button>';}
            
            print'</div>
        </div>';
            }
            
                print '
        <nav  class="navbar navbar-default gris" role="navigation">
             <ul class="nav navbar-nav">
                 <li><a href="panierSave.php" class="navPrincipale">Annonces sauvegardées</a></li>
                 <li><a href="panierPost.php" class="navCouleurContainer">Annonces postulées</a></li>
             </ul>
        </nav>
        <br/>';
  
        
        require("db/connect.php");
        if(isset($_SESSION['id']))
        {
                //code qui permet de récupérer toutes les offre_id de type emploi
                ////l'utilisateur normal ne peut pas voir les offres de plus de 1 semaine
                //Tri par +recent
                if ( (isset($_GET['tri']) && $_GET['tri']=="recent") || !(isset($_GET['tri'])) )
                { 
                    $requete='SELECT * FROM liaison_panier,offre WHERE utilisateur_id='.$_SESSION['id'].' AND offre_valide=1 '
                            . 'AND offre_signalee=0 AND liaison_panier.offre_id=offre.offre_id ORDER BY offre_datePoste DESC';
                }
                //Tri par +ancien
                if (isset($_GET['tri']) && $_GET['tri']=="ancien")
                { 
                    $requete='SELECT * FROM liaison_panier,offre WHERE utilisateur_id='.$_SESSION['id'].' AND offre_valide=1 '
                            . 'AND offre_signalee=0 AND liaison_panier.offre_id=offre.offre_id ORDER BY offre_datePoste';
                }
                //Tri par A-Z
                if (isset($_GET['tri']) && $_GET['tri']=="az")
                { 
                    $requete='SELECT * FROM liaison_panier,offre WHERE utilisateur_id='.$_SESSION['id'].' AND offre_valide=1 '
                            . 'AND offre_signalee=0 AND liaison_panier.offre_id=offre.offre_id ORDER BY offre_nom '; 
                }
                //Tri par commence au plus tôt commenceBientot
                 if (isset($_GET['tri']) && $_GET['tri']=="commenceBientot")
                { 
                    $requete='SELECT * FROM liaison_panier,offre WHERE utilisateur_id='.$_SESSION['id'].' AND offre_valide=1 '
                    . 'AND offre_signalee=0 AND liaison_panier.offre_id=offre.offre_id ORDER BY offre_dateDeb DESC';

                }    
                $resultat=$BDD -> query($requete);
                //on stocke les résultats de la requete dans un tableau, une ligne par offre dans le panier
                $tableauResultat=$resultat->fetchAll();
                $bool=true;
                if ($resultat->rowCount()==0)
                {
                    print 'Vous n\'avez postulé à aucune offre pour le moment !<br/>';
                }
                else {
                    //chaque ligne est $liaison, on doit préciser entre crochets la colonne
                    foreach($tableauResultat as $liaison)
                    {
                        $offre_id=$liaison['offre_id'];
                        $postule=$liaison['liaisonPanier_postule'];
                        $save=$liaison['liaisonPanier_save'];
                        $liaison_id=$liaison['liaisonPanier_id'];
                        if ($postule==1)
                        {
                            $bool=!$bool;
                            AfficherOffre($offre_id,$postule,$liaison_id,$save,$bool);
                            $testOffre=true;
                        }
                    }
                }
            }
            
            ?>    </br>
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
<html/>
 