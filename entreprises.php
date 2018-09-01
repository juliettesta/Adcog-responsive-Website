<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
    <?php
      include("includes/head.php");
      print     '<title>Entreprises</title></head>';
      include("includes/header.php");
      include("includes/esTuConnecte.php");
    ?>
    
    <body>
        <div class="container">             
            
            <h2 class='margeGauche'>Les entreprises ayant déjà proposé des stages</h2></br></br>
            
            <!-- Trier par -->
            <div class="enBasADroite margeDroite">
            <div class="btn-group ">
              <button type="button" class="btn btn-default dropdown-toggle grisclair" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Trier par <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="entreprises.php?tri=az">A-Z</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="entreprises.php?tri=ville">Ville</a></li>
              </ul>
            </div></div>

            <?php
            require("db/connect.php");
            //Fonction qui permet d'afficher toutes les informations concernant une entrepise en prenant en argument son id qui est la clé primaire
            function AfficherEntreprise($entreprise_id,$bool)
            {
                require("db/connect.php");
                $requete="SELECT * FROM entreprise WHERE entreprise_id = $entreprise_id";
                $resultat=$BDD->query($requete);
                //on obtient la ligne entière de la BDD décrivant l'entreprise
                $entreprise=$resultat->fetch();
                if ($bool) print '<div class="row centreOffre fondFonce">';
                if (!$bool) print '<div class="row centreOffre fondClair">';       
                print '
                <div class="col-xs-2 col-sm-3 col-md-9 col-lg-2">
                
                <a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">
                    <img class="imageOffre"  alt="logoEntreprise" src="logos/'.$entreprise['entreprise_logo'].'"/></a><br/><h4>'
                        . '<a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">'.
                    $entreprise['entreprise_nom'].'</a><h4/>
                </div>
                <div class="col-xs-10 col-sm-9 col-md-3 col-lg-3 "> 
                    <div class="margeSimpson">
                    <h2> <a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">'.
                        $entreprise['entreprise_nom'].'</a></h2><br/><br/>'
                        . '<table><tr><td><i> Site(s) :  </i></td><td>';
                //on récupère les informations des adresses liées à l'entreprise si elle existe           
                $requete='SELECT adresse_id FROM liaison_entrepriseadresse WHERE entreprise_id ='. $entreprise ["entreprise_id"];
                $resultat=$BDD -> query($requete);
                //on stocke les résultats de la requete dans un tableau, une ligne par adresse liée a l'entreprise
                if ($resultat->rowcount()!=0)
                {
                    $tableauAdresse=$resultat->fetchAll();
                    //chaque ligne est une adresse : adresse_id
                    //chaque ligne est $liaison
                    foreach($tableauAdresse as $liaison)
                    {
                        $adresse_id=$liaison['adresse_id'];
                        $requete="SELECT * FROM adresse WHERE adresse_id = $adresse_id";
                        $resultat=$BDD -> query($requete);
                        //on stocke les résultats de la requete dans $adresse
                        $adresse=$resultat->fetch();
                        print $adresse['adresse_ville'].'<br/>';
                    }
                }
                print
                        '</td></tr></table><br/></div>
            </div>
            <div class="col-xs-8 col-sm-9 col-md-9 col-lg-6"> 
                <div class="margeSimpson2">'.
                    $entreprise['entreprise_descrCourte'].
                '</div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-3 col-lg-1  enBasADroite">
                <a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">
                <br/><br/><i>voir plus</i>
                </a>
                
            </div>
        </div>';
            }
            
            //code qui permet de trier par adresse
            if (isset($_GET['tri']) && $_GET['tri']=="ville")
            {
                print '<div class="margeGauchebis">Les entreprises sans adresse ne sont pas visibles.</div>';
                $requete='SELECT * FROM entreprise,liaison_entrepriseadresse,adresse WHERE liaison_entrepriseadresse.entreprise_id=entreprise.entreprise_id '
                        . 'AND adresse.adresse_id=liaison_entrepriseadresse.adresse_id ORDER BY adresse_ville';
            }
            if ((isset($_GET['tri']) && $_GET['tri']=="az") || !(isset($_GET['tri'])))
            {
                $requete='SELECT * FROM entreprise ORDER BY entreprise_nom';
            }
           //envoi de la requête
            $resultat=$BDD -> query($requete);
            //on stocke les résultats de la requete dans un tableau, une ligne par entreprise
            $tableauResultat=$resultat->fetchAll();
            //chaque ligne est $entreprise, on doit préciser entre crochets la colonne
            //booléen pour alterner les couleurs
            $bool=true;
            foreach($tableauResultat as $entreprise)
            {
                $bool=!$bool;
                AfficherEntreprise($entreprise['entreprise_id'],$bool);
            }
            ?>    
            </br>
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
<html/>