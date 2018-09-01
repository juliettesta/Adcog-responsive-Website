<!-- Permet de vider les variables employées dans les formulaires au cas où un utilisateur rempli un formulaire 
    mais ne va pas jusqu'au bout de la validation -->
<?php

   
    //OFFRE
// Suppression des variables de session des formulaires s'ils existent (c-a-d une offre a été envoyé avec des erreurs mais jamais finalisé)
            // DeposerOffre.php
    if (isset ($_SESSION['adresseE'])) unset ($_SESSION['adresseE']);
    if (isset ($_SESSION['villeE'])) unset ($_SESSION['villeE']);
    if (isset ($_SESSION['cpE'])) unset ($_SESSION['cpE']);
    if (isset ($_SESSION['paysE'])) unset ($_SESSION['paysE']);
    
    if (isset ($_SESSION['nomE'])) unset ($_SESSION['nomE']);
    if (isset ($_SESSION['siteE'])) unset ($_SESSION['siteE']);
    if (isset ($_SESSION['descripLE'])) unset ($_SESSION['descripLE']);
    if (isset ($_SESSION['descripCE'])) unset ($_SESSION['descripCE']);
    
    if (isset ($_SESSION['nomC'])) unset ($_SESSION['nomC']);
    if (isset ($_SESSION['prenomC'])) unset ($_SESSION['prenomC']);
    if (isset ($_SESSION['mailC'])) unset ($_SESSION['mailC']);
    if (isset ($_SESSION['telC'])) unset ($_SESSION['telC']);
    
    if (isset ($_SESSION['nomO'])) unset ($_SESSION['nomO']);
    if (isset ($_SESSION['profilO'])) unset ( $_SESSION['profilO']);
    if (isset ($_SESSION['dateDO'])) unset ($_SESSION['dateDO']);
    if (isset ($_SESSION['dureeO'])) unset ($_SESSION['dureeO']);
    if (isset ($_SESSION['descripCO'])) unset ($_SESSION['descripCO']);
    if (isset ($_SESSION['descripLO'])) unset ($_SESSION['descripLO']);
    if (isset ($_SESSION['remunO1'])) unset ($_SESSION['remunO1']);
    if (isset ($_SESSION['remunO2'])) unset ($_SESSION['remunO2']); 
            // Passage des erreurs possibles à false
    $_SESSION['erreurlogoE']=false;
    $_SESSION['erreurIext']=false;
    $_SESSION['erreurItaille']=false;
    $_SESSION['erreurFext']=false;
    $_SESSION['erreurFtaille']=false;
    $_SESSION['erreurmdpO']=false;
    $_SESSION['erreurFichier']=false;
    $_SESSION['erreurImage']=false;
    $_SESSION['erreurdateDO']=false;
    
            // IAModifierOffre.php
    if (isset ($_SESSION['offre_idIA'])) unset ($_SESSION['offre_idIA']);
   
            //ModifierSupprimerOffre.php
    $_SESSION['erreurnumOffre']=false;
    $_SESSION['erreurmdp']=false;
    
            //ModifierOffre.php
    if (isset ($_SESSION['numO'])) unset ($_SESSION['numO']);
    
        //UTILISATEUR, PROFIL
            // IAAjoutUsers.php
        if (isset ($_SESSION['nomU'])) unset ($_SESSION['nomU']);
        if (isset ($_SESSION['prenomU'])) unset ($_SESSION['prenomU']);
        if (isset ($_SESSION['dateneeU'])) unset ($_SESSION['dateneeU']);
        if (isset ($_SESSION['statutU'])) unset ($_SESSION['statutU']);
        if (isset ($_SESSION['mailU'])) unset ($_SESSION['mailU']);
        if (isset ($_SESSION['telU'])) unset ($_SESSION['telU']);
        if (isset ($_SESSION['loginU'])) unset ($_SESSION['loginU']);
        if (isset ($_SESSION['adresseU'])) unset ($_SESSION['adresseU']);
        if (isset ($_SESSION['villeU'])) unset ($_SESSION['villeU']);
        if (isset ($_SESSION['cpU'])) unset ($_SESSION['cpU']);
        if (isset ($_SESSION['paysU'])) unset ($_SESSION['paysU']);
            // Passage des erreurs possibles à false
        $_SESSION['erreurloginU']=false;
        $_SESSION['erreurdateneeU']=false;
        $_SESSION['erreurmdpU']=false;
        
            // IAModifierUsers.php
        if (isset ($_SESSION['users_id'])) unset ($_SESSION['users_id']);
    
    
?>

