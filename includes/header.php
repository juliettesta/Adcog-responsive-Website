<!DOCTYPE html>

<html>
    <!-- Bootstrap -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <script src="js/javascript.js"></script> 
  
  
    <!-- Barre header -->
     <nav  class="navbar navbar-default blanc" role="navigation">
         <ul class="nav navbar-nav">
             <li><a class="navbar-brand" href="index.php"><IMG SRC="images/logo_adcog.jpg" ALT="ADCOG" TITLE="ADCOG"/></a></li>
         </ul>
         <ul class="nav navbar-nav  navbar-right">
             
             <?php
             require("db/connect.php"); // Accès à la BDD 
             // Partie Admin
             if (isset($_SESSION['statut']) && $_SESSION['statut']=="admin") 
            {
                // Recherche s'il y  a des offres à valider ou signalée
                $requete= $BDD -> prepare("SELECT * FROM OFFRE WHERE offre_signalee=? OR offre_valide=0");
                $requete -> execute (array (1));
                // Recherche s'il y  a des utilisateurs à valider
                $Requete= $BDD -> prepare("SELECT * FROM UTILISATEUR WHERE utilisateur_valide=?");
                $Requete -> execute (array (0));
                
                //S'il y a des lignes retournées; on affiche la molette avec le signal
                 if ( ($requete -> rowcount() != 0) || ($Requete -> rowcount() != 0)) 
                 {
                     
                     print '<li><a class="navbar-brand" href="IAoffres.php"><IMG SRC="images/administrateursignal.png" ALT="admin" TITLE="admin"/></a></li>';
                 }
                 else { // Sinon ion affiche la simple molette
                 print '<li><a class="navbar-brand" href="IAoffres.php"><IMG SRC="images/administrateur.png" ALT="admin" TITLE="admin"/></a></li>';}
            }
            
            // Avec connexion : profil, panier 
             if (isset($_SESSION['statut']) && ($_SESSION['statut']=="adherent" || $_SESSION['statut']=="normal" || $_SESSION['statut']=="admin")) 
            { 
             print '<li><a class="navbar-brand" href="Profil.php"><IMG SRC="images/profil.png" ALT="profil" TITLE="profil"/></a></li>
             <li><a class="navbar-brand" href="panierSave.php"><IMG SRC="images/panier.png" ALT="panier" TITLE="panier"/></a></li>';
            }?> 
             
            <!-- Sans connexion : Contact -->
            <li><a class="navbar-brand" href="Contact.php"><IMG SRC="images/contact.png" ALT="contact" TITLE="contact"/></a></li>
            
            <!-- Connexion -->
            <?php
            if (!(isset($_SESSION['statut'])))
            {
                print '<li><a class="navbar-brand" href="connexion.php">Connexion</a></li>';
            }
             if (isset($_SESSION['statut']) && ($_SESSION['statut']=="adherent" || $_SESSION['statut']=="normal" || $_SESSION['statut']=="admin")) 
            { 
             print '<li><a class="navbar-brand" href="TraiteConnexion.php"><IMG SRC="images/logout.png" ALT="logout" TITLE="logout"/></a></li>';
            }?> 
         </ul>
    </nav>  
    
    <!-- Barre de navigation principale -->
    <nav  class="navbar navbar-default gris" role="navigation">
         <ul class="nav navbar-nav">
             <li><a href="Deposeroffre.php" class="navPrincipale">Déposer une offre</a></li>
             <li><a href="ModifierSupprimerOffre.php" class="navPrincipale">Modifier/Supprimer une offre</a></li>
         </ul>
    </nav>  

    <!-- Barre de navigation secondaire -->
    <?php if (isset($_SESSION['statut']) && ($_SESSION['statut']=="adherent" || $_SESSION['statut']=="normal" || $_SESSION['statut']=="admin"))
    {

        print '<nav  class="navbar navbar-default grisclair" role="navigation">
               <div class="dropdown navSecondaire">
               <button class="dropbtn grisclair">Offres</button>
               <div class="dropdown-content ">
               <a href="stages.php">Stages</a>
               <a href="emplois.php">Emplois</a>
               </div>

               </div>
               <a href="entreprises.php" class="navSecondaire">Entreprises</a>
               </nav>';
    }
    ?>

</html>