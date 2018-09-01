<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
    <?php
      include("includes/head.php");
      print     '<title>Emplois</title></head>';
      include("includes/header.php");
      //l'utilisateur doit etre connecte pour accéder à cette page
      include("includes/esTuConnecte.php");
    ?>
    
    <body>
        <div class="container">             
            
            <h2 class='margeGauche'>Les annonces d'emplois</h2>

            <!-- Trier par -->
            <div class="enBasADroite margeDroite">
            <div class="btn-group ">
              <button type="button" class="btn btn-default dropdown-toggle grisclair" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="emplois.php?tri=recent">+ récent</a></li>
                <li><a href="emplois.php?tri=ancien">+ ancien</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="emplois.php?tri=az">A-Z</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="emplois.php?tri=commenceBientot">Commence bientôt</a></li>
              </ul>
            </div></div>

            <?php
            require("db/connect.php");
            
            //code qui permet de récupérer toutes les offre_id de type emploi
            //l'utilisateur non adhérent ne peut voir les offres postées il y a plus de 1 semaine
            //Tri par +recent
            if ( (isset($_GET['tri']) && $_GET['tri']=="recent") || !(isset($_GET['tri'])) )
            { 
                if (isset($_SESSION['statut']) && $_SESSION['statut']=="normal") 
                {
                     $requete='SELECT * FROM offre WHERE offre_profil="Emploi" AND offre_datePoste<DATE_ADD(NOW(),INTERVAL -1 WEEK) AND offre_signalee=0 AND offre_valide=1 ORDER BY offre_datePoste DESC'; 
                }
                else 
                {
                     $requete='SELECT * FROM offre WHERE offre_profil="Emploi" AND offre_valide=1  AND offre_signalee=0 ORDER BY offre_datePoste DESC';
                }
            }
            //Tri par +ancien
            if (isset($_GET['tri']) && $_GET['tri']=="ancien")
            { 
                if (isset($_SESSION['statut']) && $_SESSION['statut']=="normal") 
                {
                     $requete='SELECT * FROM offre WHERE offre_profil="Emploi" AND offre_datePoste<DATE_ADD(NOW(),INTERVAL -1 WEEK) AND offre_signalee=0 AND offre_valide=1 ORDER BY offre_datePoste '; 
                }
                else
                {
                     $requete='SELECT * FROM offre WHERE offre_profil="Emploi" AND offre_valide=1  AND offre_signalee=0 ORDER BY offre_datePoste ';
                }
            }
            //Tri par A-Z
            if (isset($_GET['tri']) && $_GET['tri']=="az")
            { 
                if (isset($_SESSION['statut']) && $_SESSION['statut']=="normal") 
                {
                     $requete='SELECT * FROM offre WHERE offre_profil="Emploi" AND offre_datePoste<DATE_ADD(NOW(),INTERVAL -1 WEEK) AND offre_signalee=0 AND offre_valide=1 ORDER BY offre_nom '; 
                }
                else
                {
                     $requete='SELECT * FROM offre WHERE offre_profil="Emploi" AND offre_valide=1  AND offre_signalee=0 ORDER BY offre_nom ';
                }
            }
            //Tri par commence au plus tôt commenceBientot
             if (isset($_GET['tri']) && $_GET['tri']=="commenceBientot")
            { 
                if (isset($_SESSION['statut']) && $_SESSION['statut']=="normal") 
                {
                     $requete='SELECT * FROM offre WHERE offre_profil="Emploi" AND offre_datePoste<DATE_ADD(NOW(),INTERVAL -1 WEEK) AND offre_signalee=0 AND offre_valide=1 ORDER BY offre_dateDeb '; 
                }
                else
                {
                     $requete='SELECT * FROM offre WHERE offre_profil="Emploi" AND offre_valide=1  AND offre_signalee=0 ORDER BY offre_dateDeb ';
                }
            }         
            
           //envoi de la requête
            $resultat=$BDD -> query($requete);
            //on stocke les résultats de la requete dans un tableau, une ligne par offre
            $tableauResultat=$resultat->fetchAll();
            //chaque ligne est $offre, on doit préciser entre crochets la colonne
            //le booléen permet d'alterner les couleurs
            $bool=true;
            foreach($tableauResultat as $offre)
            {
                $bool=!$bool;
                AfficherEmploi($offre['offre_id'],$bool);
            }
            ?>    </br>
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
<html/>