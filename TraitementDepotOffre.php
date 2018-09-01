<?php session_start(); //Ouverture session pour sauvegarder les donnees dans le formulaire en cas d'erreur ?>
<?php

//Connexion à la BDD
require("db/connect.php");
//Inclure les fonctions de récupérations de fichier
include 'TraitementDepotOffreFonctions.php';


//Initialisation des variables
    //Adresse
$compteurAdresse =""; // Si aucune adresse n'est rentrée, les clés étrangères adresse seront null
$adresseE = "";
$villeE = "";
$cpE = "";  
$paysE="";
    //Entreprise
$nomE = ""; // ne sera jamais null
$siteE = "";
$descripCE = "";
$descripLE = ""; 
$logoE = ""; 
    //Contact
$nomC = "";
$prenomC= "";
$mailC = ""; 
$telC = "";
    // Offre
$nomO = "";  //doit jamais etre null
$mdpO = "";  // doit jamais être null
$profilO = ""; // doit jamais être null
$dateDO = ""; 
$dureeO = ""; 
$descripCO = "";
$descripLO = "";
$fichierO = "";
$remunO = ""; //arrivera jamais

// Initialisation de ces variables sinon elles seront toujours à true si on upload pas à nouveau le fichier
$_SESSION['erreurIext']= false;
$_SESSION['erreurItaille']= false;
$_SESSION['erreurFext']= false;
$_SESSION['erreurFtaille']= false;
    
//Récupération des données dans les variables + sauvegarde des données dans la session
    //Adresse
if(isset($_POST['adresseE'])){ $adresseE = $_POST['adresseE']; $_SESSION['adresseE'] = $_POST['adresseE'] ;}
if(isset($_POST['villeE'])){ $villeE = $_POST['villeE']; $_SESSION['villeE'] = $_POST['villeE'] ;}
if(isset($_POST['cpE'])){ $cpE = $_POST['cpE']; $_SESSION['cpE'] = $_POST['cpE'] ;}
if(isset($_POST['paysE'])){ $paysE = $_POST['paysE']; $_SESSION['paysE'] = $_POST['paysE'] ;}
    //Entreprise
if(isset($_POST['nomE'])){ $nomE = $_POST['nomE']; $_SESSION['nomE'] = $_POST['nomE'] ;} // passera toujours dans la boucle
if(isset($_POST['siteE'])){ $siteE = $_POST['siteE']; $_SESSION['siteE'] = $_POST['siteE'] ;}
if(isset($_POST['descripCE'])){ $descripCE = $_POST['descripCE']; $_SESSION['descripCE'] = $_POST['descripCE'] ;}
if(isset($_POST['descripLE'])){ $descripLE = $_POST['descripLE']; $_SESSION['descripLE'] = $_POST['descripLE'] ;}
if (is_uploaded_file($_FILES['logoE']['tmp_name'])) { //Pour un fichier
   $logoE= transfertImage('logoE'); 
} 
    //Contact
if(isset($_POST['nomC'])){ $nomC = $_POST['nomC']; $_SESSION['nomC'] = $_POST['nomC'] ;}
if(isset($_POST['prenomC'])){ $prenomC = $_POST['prenomC']; $_SESSION['prenomC'] = $_POST['prenomC'] ;}
if(isset($_POST['mailC'])){ $mailC = $_POST['mailC']; $_SESSION['mailC'] = $_POST['mailC'] ;}
if(isset($_POST['telC'])){ $telC = $_POST['telC']; $_SESSION['telC'] = $_POST['telC'] ;}
    //Offre
if(isset($_POST['nomO'])){ $nomO = $_POST['nomO']; $_SESSION['nomO'] = $_POST['nomO'] ;}
if(isset($_POST['mdpO'])){ $mdpO = $_POST['mdpO']; } // on ne sauvegarde pas le mdp
if(isset($_POST['profilO'])){ $profilO = $_POST['profilO']; $_SESSION['profilO'] = $_POST['profilO'] ;}
if(isset($_POST['dateDO'])){ $dateDO = $_POST['dateDO']; $_SESSION['dateDO'] = $_POST['dateDO'] ;}
if(isset($_POST['dureeO'])){ $dureeO = $_POST['dureeO']; $_SESSION['dureeO'] = $_POST['dureeO'] ;}
if(isset($_POST['descripCO'])){ $descripCO = $_POST['descripCO']; $_SESSION['descripCO'] = $_POST['descripCO'] ;}
if(isset($_POST['descripLO'])){ $descripLO = $_POST['descripLO']; $_SESSION['descripLO'] = $_POST['descripLO'] ;}
if (is_uploaded_file($_FILES['fichierO']['tmp_name'])) {
   $fichierO= transfertFichier('fichierO'); 
} 
if(isset($_POST['remunO1'])){ 
    $remunO = $_POST['remunO1']." ".$_POST['remunO2'] ;
    $_SESSION['remunO1'] = $_POST['remunO1'] ;
    $_SESSION['remunO2'] = $_POST['remunO2'] ;
} 


//Vérification des données
    //Adresse
//aucune restriction
    //Entreprise
if (($_SESSION['erreurIext'] == true) || ($_SESSION['erreurItaille'] == true)) 
{ $_SESSION['erreurImage']=true ;}
else {$_SESSION['erreurImage']=false ;}

if (($_SESSION['erreurFext'] == true) || ($_SESSION['erreurFtaille'] == true)) 
{ $_SESSION['erreurFichier']=true ;}
else {$_SESSION['erreurFichier']=false ;}
    //Contact
//aucune resctriction
    //Offre
if (strlen ($mdpO) < 4) // mdp de caractères minimum 
{ $_SESSION['erreurmdpO'] = true ;}
else {$_SESSION['erreurmdpO'] = false ;}

if ((strlen ($dateDO) != 10)&&(strlen ($dateDO) != 0))
{ $_SESSION['erreurdateDO']=true;}
else { $_SESSION['erreurdateDO']=false;}


//Vérification que les données n'existent pas dans la BDD + Ajout des données dans la BDD si aucune erreur  
if (($_SESSION['erreurdateDO']==false) && ($_SESSION['erreurmdpO'] == false) && ($_SESSION['erreurImage'] ==false) && ($_SESSION['erreurFichier']==false)) { // dans le if mettre des && == false pour toutes les variables
    
    //On crypte le mdp entrée
    $mdpO = password_hash($mdpO, PASSWORD_DEFAULT);
    
    //
    //Adresse
    //
    $Requete= $BDD -> prepare("SELECT * FROM ADRESSE WHERE adresse_voie= ?");
    $Requete -> execute (array ($_POST['adresseE']));
    $compteur =0;
    //Si la requete retourne un resultat, on regarde si la ligne existe déjà
    if ($Requete -> rowcount()!=0) 
    {    
        while ($ligne = $Requete -> fetch()){
        if ( $ligne['adresse_ville']== $villeE) 
        {
           if ( $ligne['adresse_cp']== $cpE)   
               {
                    if ( $ligne['adresse_pays']== $paysE){
                    $compteur=1; //Si la ligne existe déjà, on passe le compteur à 1
                    }
               } 
        }
        }
    }
    if ( ($adresseE == "") && ($villeE == "") && ($cpE == "")&& ($paysE == "")) // Si toutes les cases sont nulles
    {
        $compteur =2; // Toutes les données sont vides
        $compteurAdresse = "AUCUNE";
    }    
    // On rajoute la ligne si elle n'existe pas
    if ($compteur==0)
    {
        $requete = $BDD -> prepare ("INSERT INTO ADRESSE (adresse_voie, adresse_ville, adresse_cp, adresse_pays)
                                VALUES ( :adresseE, :villeE, :cpE, :paysE)");

        $requete -> bindValue('adresseE',$adresseE , PDO::PARAM_STR);
        $requete -> bindValue('villeE',$villeE , PDO::PARAM_STR);
        $requete -> bindValue('cpE',$cpE , PDO::PARAM_STR);
        $requete -> bindValue('paysE',$paysE , PDO::PARAM_STR);
        $requete -> execute();
    }
    else if ($compteur==1) {
        $info = "Adresse déjà dans la bdd </br>";  
    }
    else if ($compteur==2) { 
        $info = "Adresse vide, on ajoute rien </br>";
    }

    //
    // Entreprise
    //
    $Requete= $BDD -> prepare("SELECT * FROM ENTREPRISE WHERE entreprise_nom= ?");
    $Requete -> execute (array ($_POST['nomE']));
    $compteur =0;
    //Si la requete retourne un resultat, on regarde si la ligne existe déjà
    if ($Requete -> rowcount()!=0)
    {
        while ($ligne = $Requete -> fetch()){
            if ( $ligne['entreprise_siteInternet']== $siteE) 
            {
                    $compteur=1; //Si la ligne existe déjà, on passe le compteur à 1   
            }
        }
    }
    // On rajoute la ligne si elle n'existe pas
    if ($compteur==0){

        $requete = $BDD -> prepare ("INSERT INTO ENTREPRISE (entreprise_nom, entreprise_siteInternet, entreprise_descrCourte, entreprise_descrLong, entreprise_logo)
                                VALUES ( :nomE, :siteE, :descripCE, :descripLE, :logoE)");

        $requete -> bindValue('nomE',$nomE , PDO::PARAM_STR);
        $requete -> bindValue('siteE',$siteE , PDO::PARAM_STR);
        $requete -> bindValue('descripCE',$descripCE , PDO::PARAM_STR);
        $requete -> bindValue('descripLE',$descripLE , PDO::PARAM_STR);
        $requete -> bindValue('logoE',$logoE , PDO::PARAM_STR);
        $requete -> execute();

    }
    else if ($compteur==1) {
        $info = "Entreprise déjà dans la bdd </br>"; }

    
    //
    // Contact
    //
    $Requete= $BDD -> prepare("SELECT * FROM CONTACT WHERE contact_nom= ?");
    $Requete -> execute (array ($_POST['nomC']));
    $compteur =0;
    //Si la requete retourne un resultat, on regarde si la ligne existe déjà
    if ( $Requete -> rowcount()!=0) 
    {
        while ($ligne = $Requete -> fetch()){
            if ( $ligne['contact_mail']== $mailC) 
            {
                    $compteur=1; //Si la ligne existe déjà, on passe le compteur à 1   
            }
        }
    }
    // On rajoute la ligne si elle n'existe pas
    if ($compteur==0){

        //Clé étrangère entreprise, toujours existante 
        $entreprise = "SELECT entreprise_id FROM ENTREPRISE WHERE entreprise_nom='".$nomE."' AND entreprise_siteInternet='".$siteE."'"; 
        $resultat = $BDD -> query ($entreprise);
        $ligne = $resultat -> fetch();
        $entreprise_id= $ligne['entreprise_id'];

        $requete = $BDD -> prepare ("INSERT INTO CONTACT (contact_nom, contact_prenom, contact_tel, contact_mail, entreprise_id)
                                    VALUES ( :nomC, :prenomC, :telC, :mailC, $entreprise_id )");

        $requete -> bindValue('nomC',$nomC , PDO::PARAM_STR);
        $requete -> bindValue('prenomC',$prenomC , PDO::PARAM_STR);
        $requete -> bindValue('mailC',$mailC , PDO::PARAM_STR);
        $requete -> bindValue('telC',$telC , PDO::PARAM_STR); 
        

        $requete -> execute();
    }
    else if ($compteur==1) {
        $info = "Contact déjà dans la bdd </br>";}

    //
    //Liaison Entreprise/Adresse
    //
    // S'il y a pas de clé étrangère pour l'adresse, on n'ajoute rien à cette BDD
    if ($compteurAdresse != "AUCUNE")
    {
        $entreprise = "SELECT entreprise_id FROM ENTREPRISE WHERE entreprise_nom='".$nomE."' AND entreprise_siteInternet='".$siteE."'"; //Suffit à l'unicité ?
        $resultat = $BDD -> query ($entreprise);
        $ligneE = $resultat -> fetch();
        $entreprise_id= $ligneE['entreprise_id'];

        $adresse = "SELECT adresse_id FROM ADRESSE WHERE adresse_voie='".$adresseE."' AND adresse_ville='".$villeE."' AND adresse_cp='".$cpE."' AND adresse_pays='".$paysE."'"; 
        $requete = $BDD -> query ($adresse);
        $ligneA = $requete -> fetch();
        $adresse_id= $ligneA['adresse_id'];

        //On vérifie que la ligne n'existe pas déjà dans la bdd 
        $Requete= $BDD -> prepare("SELECT * FROM LIAISON_entrepriseAdresse WHERE entreprise_id= ?");
        $Requete -> execute (array ($entreprise_id));
        $compteur =0;
        if ($Requete -> rowcount()!=0) //Si la requete retourne un resultat, on regarde si la ligne existe déjà
        {
            while ($ligne = $Requete -> fetch()){
                if ( $ligne['adresse_id']== $adresse_id) 
                {
                        $compteur=1; //Si la ligne existe déjà, on passe le compteur à 1   
                }
            }
        }
        // On rajoute la ligne si elle n'existe pas
        if ($compteur==0){
            $requete = $BDD -> prepare ("INSERT INTO LIAISON_entrepriseAdresse (entreprise_id, adresse_id)
                                    VALUES ($entreprise_id, $adresse_id)");
            $requete -> execute();
        }
        else if ($compteur==1) {
            $info = "liaison déjà dans la bdd </br>";}
    }
    else { $info  = "pas de liaison ajouté </br>";}
    
    
    //
    //Offre
    //
    //Clé étrangère
    $contact = "SELECT contact_id FROM CONTACT WHERE contact_nom='".$nomC."' AND contact_mail='".$mailC."'";
    $reqC = $BDD -> query ($contact);
    $ligneC = $reqC-> fetch();
    $contact_id= $ligneC['contact_id'];

    $entreprise = "SELECT entreprise_id FROM ENTREPRISE WHERE entreprise_nom='".$nomE."' AND entreprise_siteInternet='".$siteE."'";
    $reqE = $BDD -> query ($entreprise);
    $ligneE = $reqE-> fetch();
    $entreprise_id= $ligneE['entreprise_id'];

    if ($compteurAdresse == "AUCUNE") {$adresse_id=null;}
    else {
         $adresse = "SELECT adresse_id FROM ADRESSE WHERE adresse_voie='".$adresseE."' AND adresse_ville='".$villeE."' AND adresse_cp='".$cpE."' AND adresse_pays='".$paysE."'"; 
        $requete = $BDD -> query ($adresse);
        $ligneA = $requete -> fetch();
        $adresse_id= $ligneA['adresse_id'];
    }
    
    if (isset ($_SESSION['statut']) && $_SESSION['statut']=='admin') {
        $requete = $BDD -> prepare ("INSERT INTO OFFRE (offre_nom, offre_datePoste, offre_mdp, offre_profil, offre_dateDeb, offre_duree, offre_descrCourte, offre_descrLongue, offre_fichier, offre_valide, offre_signalee, offre_renum, contact_id, entreprise_id, adresse_id)
                                VALUES (:nomO,NOW(),:mdpO,:profilO,:dateDO,:dureeO,:descripCO,:descripLO,:fichierO,1,0,:remunO,$contact_id,$entreprise_id,:adresse_idU)");
    
    }
    else {
        $requete = $BDD -> prepare ("INSERT INTO OFFRE (offre_nom, offre_datePoste, offre_mdp, offre_profil, offre_dateDeb, offre_duree, offre_descrCourte, offre_descrLongue, offre_fichier, offre_valide, offre_signalee, offre_renum, contact_id, entreprise_id, adresse_id)
                                VALUES (:nomO,NOW(),:mdpO,:profilO,:dateDO,:dureeO,:descripCO,:descripLO,:fichierO,0,0,:remunO,$contact_id,$entreprise_id,:adresse_idU)");
    }
    $requete -> bindValue('nomO',$nomO , PDO::PARAM_STR);
    $requete -> bindValue('mdpO',$mdpO , PDO::PARAM_STR);
    $requete -> bindValue('profilO',$profilO , PDO::PARAM_STR);
    $requete -> bindValue('dateDO',$dateDO , PDO::PARAM_STR);
    $requete -> bindValue('dureeO',$dureeO , PDO::PARAM_STR);
    $requete -> bindValue('descripCO',$descripCO , PDO::PARAM_STR);
    $requete -> bindvalue('descripLO', $descripLO, PDO::PARAM_STR);
    $requete -> bindvalue('fichierO', $fichierO, PDO::PARAM_STR); //nom du fichier
    $requete -> bindvalue('remunO', $remunO, PDO::PARAM_STR);
    $requete -> bindvalue('adresse_idU', $adresse_id, PDO::PARAM_INT);
    
    $requete -> execute();  

    $_SESSION['OffreEnvoyee']=true; ///L'offre vient d'être envoyé
    
    //Retourner l'id de l'offre ajoutée (comparaison avec description longue et nom de l'offre)
    $offre = $BDD->prepare("SELECT offre_id FROM offre WHERE offre_nom=? AND offre_descrLongue=?");
    $offre->execute(array($nomO,$descripLO));
    $ligne = $offre-> fetch();
    $offre_id= $ligne['offre_id'];

    //Changement de page
    header("Location: index.php?mdp=".$_POST['mdpO']."&numoffre=".$offre_id);

} //Fin du if s'il y a aucune erreur
// S'il y a une erreur, on reste sur la page du formulaire
else {
    header("Location: DeposerOffre.php");
// Si il y a une erreur qui s'affiche, on affiche le fait qu'il faut remettre les images si elles étaient uploadées
    //Logo
    if ($logoE != "") {$_SESSION['erreurlogoE']=true;}
    else {$_SESSION['erreurlogoE']=false;}
    //Fichier
    if ($fichierO != "") {$_SESSION['erreurfichierO']=true;}
    else {$_SESSION['erreurfichierO']=false;}

} 


?>