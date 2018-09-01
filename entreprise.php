<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
    <?php
      include("includes/head.php");
      print     '<title>Entreprise</title></head>';
      include("includes/header.php");
      //l'utilisateur doit etre connecte pour accéder à cette page
      include("includes/esTuConnecte.php");
    ?>
    
    <body>

        <div class="container">        
            
        <?php
        //fonction pour afficher une entreprise
            function AfficherEntreprise($entreprise)
            {
                require("db/connect.php");
                $requete=$BDD->prepare("SELECT * FROM entreprise WHERE entreprise_id = ?");
                $requete->execute(array($entreprise));
                //on vérifie que l'entreprise existe
                if($requete->rowcount()==0) {
                    print ("Cette entreprise n'existe pas");
                }
                else {
                    //on obtient la ligne entière de la BDD décrivant l'entreprise, stockée dans $entreprise
                    $entreprise=$requete->fetch();
                    print '<a href="entreprises.php"><img class="imageTailleLogo" alt="retour" src="images/fleche.png"/> </a>'
                    . '<h1>'.$entreprise['entreprise_nom'].'</h1></br>';
                    //logo + site internet
                    print '<div class="row centreOffre fondFonce bordureTresDouce" >
                                <div class="col-xs-3 col-sm-3 col-md-4 col-lg-4 fondFonce" 
                                style="height:240px;"></br>
                                <img class="imageEntreprise" alt="LogoEntreprise" src="logos/'.$entreprise['entreprise_logo'].'"/></a>
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-8 col-lg-8 centreVertical fondFonce" 
                                style="height:240px;"> 
                                        Site Internet  <a href="'.$entreprise['entreprise_siteInternet'].'">'.
                                        $entreprise['entreprise_siteInternet'].'</a>
                                </div><br/></div>';
                    //description longue
                    print '<div class="row centreOffre bordureTresDouce" ><h2>Description de l\'entreprise </h2>';
                    print '<div class="fondFonce"></br>'.$entreprise['entreprise_descrLong'].'<br/></br></div>';
                    
                    //sites
                    print '<h2>Adresse(s)</h2>';
                    //on récupère les informations des adresses liées à l'entreprise si elle existe            
                    $requete=$BDD->prepare('SELECT adresse_id FROM liaison_entrepriseadresse WHERE entreprise_id =?;');
                    $requete->execute(array($entreprise ["entreprise_id"]));
                    if ($requete->rowcount()!=0)
                    {
                        //on stocke les résultats de la requete dans un tableau, une ligne par adresse liée a l'entreprise
                        $tableauAdresse=$requete->fetchAll();
                        //le booléen permet d'alterner les couleurs
                        $bool=true;
                        foreach($tableauAdresse as $liaison)
                        {
                            $bool=!$bool;
                            if ($bool) print '<div class="col-xs-3 col-sm-3 col-md-4 col-lg-4 fondClair" 
                                style="height:120px;">';
                            if (!$bool) print '<div class="col-xs-3 col-sm-3 col-md-4 col-lg-4 fondFonce" 
                                style="height:120px;">';
                            $adresse_id=$liaison['adresse_id'];
                            AfficherAdresse($adresse_id);
                            print '</div>';
                        } 
                    }
                    else print '<i>Pas d\'adresse renseignée.</i>';
                    print '</div>';         
                    
                    //contacts
                    print '<div class="row centreOffre" style="border:1px solid #ddd;">';
                    print '<h2>Contact(s)</h2>';
                    $requete=$BDD->prepare("SELECT * FROM contact WHERE contact.entreprise_id =?;");
                    $requete-> execute(array($entreprise['entreprise_id']));
                    if ($requete->rowcount()!=0)
                    {
                        //on stocke les résultats de la requete dans un tableau, une ligne par contact lié a l'entreprise
                        $tableauContact=$requete->fetchAll();
                        $bool=true;
                        foreach($tableauContact as $contact)
                        {
                            $bool=!$bool;
                            if ($bool) print '<div class="col-xs-3 col-sm-3 col-md-4 col-lg-4 fondClair" 
                                style="height:150px;">';
                            if (!$bool) print '<div class="col-xs-3 col-sm-3 col-md-4 col-lg-4 fondFonce" 
                                style="height:150px;">';
                            AfficherContact($contact);
                        } 
                    }
                    else print"<i>Pas de contact renseigné.</i>";
                    print '</div>';
                    //offres proposées
                    print '<div class="row centreOffre" style="border:1px solid #ddd;">';
                    print '<h2>Offre(s) proposée(s)</h2>';
                    //l'utilisateur normal ne peut voir les offres de moins d'une semaine
                    if ($_SESSION['statut']=="normal")
                    {
                        $requete=$BDD->prepare("SELECT * FROM offre WHERE offre.entreprise_id =? AND offre_valide=1  AND offre_signalee=0 AND offre_datePoste<DATE_ADD(NOW(),INTERVAL -1 WEEK) ;");
                    }
                    else {$requete=$BDD->prepare("SELECT * FROM offre WHERE offre.entreprise_id =? AND offre_valide=1  AND offre_signalee=0 ;");}
                    $requete-> execute(array($entreprise['entreprise_id']));
                    $bool=true;
                    if ($requete->rowcount()!=0)
                    {
                        //on stocke les résultats de la requete dans un tableau, une ligne par offre liée a l'entreprise
                        $tableauOffre=$requete->fetchAll();
                        foreach($tableauOffre as $offre)
                        {
                            $bool=!$bool;
                            AfficherOffre($offre,$bool);
                        } 
                    }
                    else print "<i>Pas d'offre proposée en ce moment.</i>";
                    print '</div>';
                }
            }
        
            
            //fonction pour afficher une adresse
            function AfficherAdresse($adresse_id)
            { 
                require("db/connect.php");
                $requete="SELECT * FROM adresse WHERE adresse_id = $adresse_id";
                $resultat=$BDD -> query($requete);
                //on stocke les résultats de la requete dans $adresse
                $adresse=$resultat->fetch();
                print '<h3><a href="https://www.google.fr/maps/place/'.$adresse['adresse_voie'].' '.$adresse['adresse_cp'].' '.$adresse['adresse_ville'].' '.$adresse['adresse_pays'].'">'.$adresse['adresse_ville'].'</a></h3>';
                print $adresse['adresse_voie'].'<br/>';
                print $adresse['adresse_cp'].' '.$adresse['adresse_ville'];
                print '<br/>'.$adresse['adresse_pays'];
            }
            
            //fonction pour afficher une offre
            function AfficherOffre($offre,$bool)
            {
                require("db/connect.php");
                //on récupère les informations de l'adresse liée à l'offre
                if ($offre ["adresse_id"]!=null)
                {
                    $requete='SELECT * FROM adresse WHERE adresse_id ='. $offre ["adresse_id"];
                    $resultat=$BDD->query($requete);
                    $adresse=$resultat->fetch();
                }
                if ($bool) print '<div class="col-xs-8 col-sm-4 col-md-4 col-lg-4 fondClair" 
                style="height:200px;">';
                if (!$bool) print '<div class="col-xs-8 col-sm-4 col-md-4 col-lg-4 fondFonce" 
                style="height:200px;">';
                print '
                    <div class="margeSimpson">
                    <h2> <a href="detailEmploi.php?offre='.$offre['offre_id'].'">'.
                        $offre['offre_nom'].'</a></h2>';
                        if ($offre ["adresse_id"]!=null)
                        {$adresse['adresse_ville'];}                        
                        print '<br/>'
                        . 'Durée : '.$offre['offre_duree']
                        . '<br/>Remunération : '.$offre['offre_renum'].
                        '<br/><br/><br/><i>postée le '.$offre['offre_datePoste'].'</i>
                    </div>
                </div>';
                if ($bool) print '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 fondClair" 
                style="height:200px;"> ';
                if (!$bool) print '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 fondFonce" 
                style="height:200px;"> ';
                print '
                    <div class="margeSimpson2">'.
                        $offre['offre_descrCourte'].
                    '</div>
                </div>';
            }
            
            //fonction pour afficher un contact
            function AfficherContact($contact)
            { 
                print' 
                        <table class="tableCentre ">
                             <tr><td class="espacement3">Prénom : </td>  <td class="gros">'.$contact['contact_prenom'].' </td></tr>
                                 <tr><td class="espacement3">Nom :</td> 
                             <td class="gros">'
                                    .$contact['contact_nom'].'
                             </td></tr>

                            <tr><td class="espacement3">Mail : </td> <td><a href="mailto:'.$contact['contact_mail'].'">'.$contact['contact_mail']. '</a></td></tr>
                            <tr><td class="espacement3">Numéro : </td><td class="gros">'.$contact['contact_tel']. '</td></tr>
                        </table>
                    </div>';
            }
            
            require("db\connect.php");
            if (isset($_GET['entreprise']))
            {
                AfficherEntreprise($_GET['entreprise']);
            }
            else {header("Location: index.php");}
            ?>    </br>
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
<html/>