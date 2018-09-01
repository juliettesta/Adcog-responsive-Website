<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
    <?php
      include("includes/head.php");
      print     '<title>Offre d\'emploi</title></head>';
      include("includes/header.php");
      //l'utilisateur doit etre connecte pour accéder à cette page
      include("includes/esTuConnecte.php");
    ?>
    </head>
    
    <body>
        <div class="container">
        
            <?php
                        
            require("db/connect.php");
            
            //Fonction qui permet d'afficher toutes les informations concernant un emploi en prenant en argument son idEmploi qui est la clé primaire
            function AfficherOffre($offre_id)
            {
                require("db/connect.php");
                //l'utilisateur connecté ne voit que les offres valides de plus de 1 semaine
                if ($_SESSION['statut']=="normal") 
                {
                     $requete=$BDD->prepare("SELECT * FROM offre WHERE offre_id = ? AND offre_valide = 1 AND offre_signalee = 0 AND offre_datePoste<DATE_ADD(NOW(),INTERVAL -1 WEEK)");
                }
                //l'adhérent voit toutes les offres valides
                else if ($_SESSION['statut']=="adherent")
                {
                     $requete=$BDD->prepare("SELECT * FROM offre WHERE offre_id = ? AND offre_valide = 1 AND offre_signalee = 0");
                }
                //l'administrateur voit toutes les offres
                else 
                {
                    $requete=$BDD->prepare("SELECT * FROM offre WHERE offre_id = ?");
                }
                $requete->execute(array($offre_id));
                //on vérifie que l'offre existe
                if($requete->rowcount()==0) {
                    print ("Cette offre n'est plus disponible");
                }
                else {
                //on obtient la ligne entière de la BDD décrivant l'offre d'emploi, stockée dans $offre
                $offre=$requete->fetch();
                //on récupère les informations de l'entreprise liée à l'offre
                $requete='SELECT * FROM entreprise WHERE entreprise_id ='. $offre ["entreprise_id"];
                $resultat=$BDD->query($requete);
                $entreprise=$resultat->fetch();
                //on récupère les informations de l'adresse liée à l'offre, si elle existe
                if ($offre ["adresse_id"]!=NULL)
                {
                    $requete='SELECT * FROM adresse WHERE adresse_id ='. $offre ["adresse_id"];
                    $resultat=$BDD->query($requete);
                    $adresse=$resultat->fetch();
                }
                //on récupère les informations du contact lié à l'offre
                $requete='SELECT * FROM contact WHERE contact_id ='. $offre ["contact_id"];
                $resultat=$BDD->query($requete);
                $contact=$resultat->fetch();
                
                //affichage titre + retour page stages ou emplois
                if ($offre['offre_profil']=="Stage")
                    {print '<a href="stages.php"><img class="imageTailleLogo" src="images/fleche.png"/></a>  Stage';}
                else 
                    {print '<a href="emplois.php"><img class="imageTailleLogo" src="images/fleche.png"/></a>  Emploi';}
                print '<h1>'.$offre['offre_nom'].'</h1></br>'.
                    '<span class="margeGauchebis">Postée le '.$offre['offre_datePoste'];
                print '</span><span class="pull-right margeDroite">';
                
                print '<p>';
                
                //on compte le nombre de personnes ayant postulé pour cette offre
                $requete='SELECT COUNT(liaisonPanier_id) AS resultat FROM liaison_panier WHERE liaisonPanier_postule=1 AND liaison_panier.offre_id='.$offre_id;
                $resultatCount=$BDD->query($requete);
                $nbPostule=$resultatCount->fetch();
                print 'Nombre de postulants pour cette offre : ';
                print $nbPostule['resultat'];
                print '</p>';
                
                //on récupère les informations du panier de l'utilisateur
                $requete='SELECT * FROM liaison_panier WHERE utilisateur_id='.$_SESSION['id'].' AND offre_id='.$offre_id.';';
                $resultat=$BDD -> query($requete);
                if ($resultat->rowCount()!=0)
                {
                    $liaison=$resultat->fetch();
                    $postule=$liaison['liaisonPanier_postule'];
                    $save=$liaison['liaisonPanier_save']; 
                    $liaison_id=$liaison['liaisonPanier_id'];
                }
                //signaler
                print '<button type="button" id="btn_signale'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctSignale('.$offre_id.')">Signaler comme n\'étant plus valide</button>  ';
                //postuler
                if (isset($postule) &&($postule==1)) print '  <button type="button" id="btn_postule'.$offre_id.'" class="btn btn-primary btn-sm " onClick="fctDejaPostuler('.$_SESSION['id'].','.$liaison_id.','.$offre_id.')"><i>déjà postulé</i></button>';
                else if (isset($postule) &&($postule==0)) { print '  <button type="button" id="btn_postule'.$offre_id.'" class="btn btn-primary btn-sm" onClick="fctPostuler('.$_SESSION['id'].','.$liaison_id.','.$offre_id.')">postuler</button>';}
                else { print '  <button type="button" id="btn_postule'.$offre_id.'" class="btn btn-primary btn-sm" onClick="fctCreerPostuler('.$_SESSION['id'].','.$offre_id.')">postuler</button>';}
                //sauvegarder
                if (isset($save) && ($save==1)) print '<a type="button" id="btn_save'.$offre_id.'" class="btn " onClick="fctDejaSave2('.$liaison_id.','.$offre_id.')"><img src="images/panierMoins.PNG" class="imagePanier" alt="..."></a>';
                else if (isset($save) && ($save==0)) { print '<a type="button" id="btn_save'.$offre_id.'" class="btn " onClick="fctSave2('.$liaison_id.','.$offre_id.')"><img src="images/panierPlus.PNG" class="imagePanier" alt="..."></a>';}         
                else { print '<a type="button" id="btn_save'.$offre_id.'" class="btn " onClick="fctCreerSave2('.$_SESSION['id'].','.$offre_id.')"><img src="images/panierPlus.PNG" class="imagePanier" alt="..."></a>';}
                print '</span><br/><br/></br></br>';
                //affichage entreprise
                print '<div class="row centreOffre fondFonce bordureTresDouce">
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 fondFoncea" 
                            style="height:200px;">
                            <a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">
                            <img class="imageOffre" alt="logo_entreprise" src="logos/'.$entreprise['entreprise_logo'].'"/></a>
                            </div>
                            <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4 " 
                            style="height:200px;"> 
                                <div class="margeSimpson">
                                    <h2><a href="entreprise.php?entreprise='.$entreprise['entreprise_id'].'">'.
                                        $entreprise['entreprise_nom'].'</a>';
                                    if ($offre ["adresse_id"]!=NULL)
                                    { 
                                        print '        
                                        </h2><a href="https://www.google.fr/maps/place/'.$adresse['adresse_voie'].' '.$adresse['adresse_cp'].' '.$adresse['adresse_ville'].'">'.
                                        $adresse['adresse_voie'].'<br/>'.
                                        $adresse['adresse_cp'].' '.$adresse['adresse_ville'].'</a>';
                                    }
                                    else { print '<br/><br/>'; }
                                    print '<br/><br/>
                                    <a href="'.$entreprise['entreprise_siteInternet'].'">'.
                                    $entreprise['entreprise_siteInternet']
                                .'</a>
                                </div>
                            </div>
                            <div class="col-xs-7 col-sm-6 col-md-6 col-lg-6 " 
                            style="height:200px;"> 
                                <div class="margeSimpson2">'.
                                   $entreprise['entreprise_descrCourte']
                                .'</div>
                            </div>
                        </div>';
            //affichage contact
            print'
                <div class="row centreOffre bordureTresDouce">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 fondFoncea" 
                    style="height:180px;">
                        <h3>Contact</h3> 
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 fondFonce" 
                    style="height:180px;"> 
                        <div class="margeSimpson">
                             <table><tr><td>Nom :</td> 
                             <span class= "gros"><td>'
                                    .$contact['contact_nom'].'
                             </td></span></tr>
                            <tr><td>Prénom :</td>  <td><span class="gros">'.$contact['contact_prenom'].' </span></td></tr>
                            <tr><td>Mail : </td> <td><span class="gros"><a href="mailto:'.$contact['contact_mail'].'">'.$contact['contact_mail']. '</a></span></td></tr>
                            <tr><td>Numéro : </td><td> <span class="gros">'.$contact['contact_tel']. '</span></td></tr></table>
                        </div>
                    </div>
                </div>';
            
            //affichage offre
            print'
                <div class="row centreOffre fondFoncea bordureTresDouce">
                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                        <h3>Offre</h3> 
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 fondClair" > 
                        <div class="margeSimpson">
                        <table>
                            <tr>
                                    <td width="120" >Date de début : </td><td class="espacement2 gros" >'.$offre['offre_dateDeb'].'</td>
                            </tr>
                            <tr>
                               <td>Durée : </td><td class="espacement2 gros" >'.$offre['offre_duree'].'</td>
                            </tr>
                            <tr>
                                <td  >Rémunération : </td><td class="espacement2 gros" >'.$offre['offre_renum'].'</td>
                            </tr>
                            <tr>
                                <td  >Fichier : </td><td class="espacement2" ><a href="fichiers/'.$offre['offre_fichier'].'">'.$offre['offre_fichier'].'</a></td>
                            </tr>
                            </table>
                            <table>
                            <tr>
                                <td>Description : </td><td class="espacement2"  style ="width:77%;">'.$offre['offre_descrLongue'].'</td>
                            </tr>
                        </table>
                        </div>
                    </div>
                </div>';
                
               
            //fin du else    
            }
            //fin de la fonction
            }
            
            //appel de la fontion sur l'offre
             if (isset($_GET['offre']))
            {
                AfficherOffre($_GET['offre']);
            }
            else {header("Location: index.php");}

            ?>   </br> 
        </div>
        <?php include("includes/footer.php"); ?>
    </body>
<html/>