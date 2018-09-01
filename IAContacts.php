<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
      include("includes/head.php");
      include("includes/header.php");
      include("includes/esTuAdmin.php");
?>
        <title>Gestion des contacts</title>
    </head>
    <body>
        <?php require("db/connect.php"); // Accès à la BDD 
        include("includes/ViderSessionFormulaire.php");?>
        <div class="container"> 
        <!-- Navigation Admin -->
        <nav  class="navbar navbar-default gris" role="navigation">
             <ul class="nav navbar-nav">
                 <li><a href="IAoffres.php" class="navPrincipale">Gérer les offres</a></li>
                 <li><a href="IAusers.php" class="navPrincipale"> Gérer les utilisateurs</a></li>
                 <li><a href="IAEntreprises.php" class="navPrincipale"> Gérer les entreprises</a></li>
                 <li><a href="IAContacts.php" class="navCouleurContainer"> Gérer les contacts</a></li>
             </ul>
        </nav>
        </br>
        
        <i>Attention, vous ne pouvez supprimer que les contacts qui n'ont pas d'offre en cours !</i>
        
        <!-- Trier par -->
        <div class="enBasADroite margeDroite">
        <div class="btn-group ">
          <button type="button" class="btn btn-default dropdown-toggle grisclair" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Trier par <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="IAContacts.php?tri=az">A-Z</a></li>
            <li><a href="IAContacts.php?tri=za">Z-A</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="IAContacts.php?tri=entreprise">Entreprise</a></li>
          </ul>
        </div></div>
        <?php
         //code qui permet de trier
            if (isset($_GET['tri']) && $_GET['tri']=="za")
            {
                $requete='SELECT * FROM contact  ORDER BY contact_nom DESC';
            }
            if (isset($_GET['tri']) && $_GET['tri']=="entreprise")
            {
                print '<div class="margeGauchebis">Les entreprises sans adresse ne sont pas visibles.</div>';
                $requete='SELECT * FROM contact ORDER BY entreprise_id';
            }
            if ((isset($_GET['tri']) && $_GET['tri']=="az") || !(isset($_GET['tri'])))
            {
                $requete='SELECT * FROM contact ORDER BY contact_nom ';
            }
           //envoi de la requête
            $resultat=$BDD -> query($requete);
            //on stocke les résultats de la requete dans un tableau, une ligne par contact
            $tableauResultat=$resultat->fetchAll();
            //chaque ligne est $contact, on doit préciser entre crochets la colonne
            //booléen pour alterner les couleurs
            $bool=true;
            print '<div class="row centreOffre fondClair bordureDouce">'
            . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Prénom</div>'
            . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Nom</div>'
            . '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Tel</div>'
            . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Mail</div>'
            . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Entreprise</div>'
            . '</div>';
            foreach($tableauResultat as $contact)
            {
                $bool=!$bool;
                AfficherContact($contact,$bool);
            }
            ?>    
            </br>
        </div>
        
        
    </body>
    <?php include("includes/footer.php"); ?>
</html>


<?php
function AfficherContact($contact,$bool)
{
    require("db/connect.php");
    print '<div class="row centreOffre fondClair bordureDouce">'
    . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'.
    $contact["contact_prenom"];
    print'</div>'
    . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'.
    $contact["contact_nom"];
    print'</div>'
    . '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">'.
    $contact["contact_tel"];       
    print'</div>'
    . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">'.
    $contact["contact_mail"];
    print'</div>'
    . '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
    $requete="SELECT * FROM entreprise WHERE entreprise_id=".$contact["entreprise_id"].";";
    $resultat=$BDD->query($requete);
    $entreprise=$resultat->fetch();
    print $entreprise['entreprise_nom'];
    print'</div>'.
    //bouton supprimer
    '<button type="button" class="btn btnSupprimer pull-right margeDroite" onClick="fctSupprimerContact('.$contact["contact_id"].')">Supprimer</button>'
            
    . '</div>';
}
?>