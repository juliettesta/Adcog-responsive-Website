<?php session_start(); //Ouverture session pour sauvegarder les donnees dans le formulaire en cas d'erreur ?>
<?php

//Connexion à la BDD
require("db/connect.php");

//Initialisation variable
$nomU="";
$prenomU="";
$dateneeU=null;
$mailU="";
$telU="";
$mdpU="";
$adresseU="";
$villeU="";
$cpU="";
$paysU="";
$compteurAdresse =""; //permet de voir si l'adresse est remplie ou non

//Récupération des données + sauvegarde des données dans les variables de sessions
if(isset($_POST['nomU'])){ $nomU = $_POST['nomU']; $_SESSION['nomU'] = $_POST['nomU'] ;}
if(isset($_POST['prenomU'])){ $prenomU = $_POST['prenomU']; $_SESSION['prenomU'] = $_POST['prenomU'] ;}
if(isset($_POST['dateneeU'])){ $dateneeU = $_POST['dateneeU']; $_SESSION['dateneeU'] = $_POST['dateneeU'] ;}
if(isset($_POST['mailU'])){ $mailU = $_POST['mailU']; $_SESSION['mailU'] = $_POST['mailU'] ;}
if(isset($_POST['telU'])){ $telU = $_POST['telU']; $_SESSION['telU'] = $_POST['telU'] ;}
if(isset($_POST['mdpU'])){ $mdpU = $_POST['mdpU'];} //pas de conservation du mdp
if(isset($_POST['adresseU'])){ $adresseU = $_POST['adresseU']; $_SESSION['adresseU'] = $_POST['adresseU'] ;}
if(isset($_POST['villeU'])){ $villeU = $_POST['villeU']; $_SESSION['villeU'] = $_POST['villeU'] ;}
if(isset($_POST['cpU'])){ $cpU = $_POST['cpU']; $_SESSION['cpU'] = $_POST['cpU'] ;}
if(isset($_POST['paysU'])){ $paysU = $_POST['paysU']; $_SESSION['paysU'] = $_POST['paysU'] ;}


// Traitement des erreurs
    //Date
if ((strlen ($dateneeU) != 10)&&(strlen ($dateneeU) != 0))
{ $_SESSION['erreurdateneeU']=true;}
else { $_SESSION['erreurdateneeU']=false;}
    //Mdp
if ((strlen ($mdpU) < 4)&&(strlen ($mdpU) != 0)) // mdp de caractères minimum 
{ $_SESSION['erreurmdpU'] = true ;}
else {$_SESSION['erreurmdpU'] = false ;}


// S'il y a aucune erreur, on rentre tout dans la BDD
if (($_SESSION['erreurdateneeU']==false) && ($_SESSION['erreurmdpU']==false))
{
    
//
//ADRESSE
//
    //Ajout nouvelle adresse si elle n'existe pas dans la BDD
    $Requete= $BDD -> prepare("SELECT * FROM ADRESSE WHERE adresse_voie= ?");
    $Requete -> execute (array ($_POST['adresseU']));
    $compteur =0;
    //Si la requete retourne un resultat, on regarde si la ligne existe déjà
    if ($Requete -> rowcount()!=0) 
    {    
        while ($ligne = $Requete -> fetch()){
        if ( $ligne['adresse_ville']== $villeU) 
        {
           if ( $ligne['adresse_cp']== $cpU)   
               {
                    if ( $ligne['adresse_pays']== $paysU){
                    $compteur=1; //Si la ligne existe déjà, on passe le compteur à 1
                    }
               } 
        }
        }
    }
    if ( ($adresseU == "") && ($villeU == "") && ($cpU == "")&& ($paysU == "")) // Si toutes les cases sont nulles
    {
        $compteur =2; // Toutes les données sont vides
        $compteurAdresse = "AUCUNE";
        
    }    
    // On rajoute la ligne si elle n'existe pas
    if ($compteur==0)
    {
        $requete = $BDD -> prepare ("INSERT INTO ADRESSE (adresse_voie, adresse_ville, adresse_cp, adresse_pays)
                                VALUES ( :adresseU, :villeU, :cpU, :paysU)");

        $requete -> bindValue('adresseU',$adresseU , PDO::PARAM_STR);
        $requete -> bindValue('villeU',$villeU , PDO::PARAM_STR);
        $requete -> bindValue('cpU',$cpU , PDO::PARAM_STR);
        $requete -> bindValue('paysU',$paysU , PDO::PARAM_STR);
        $requete -> execute();
    }
    else if ($compteur==1) {
        $info = "Adresse déjà dans la bdd </br>";  
    }
    else if ($compteur==2) { 
        $info = "Adresse vide, on ajoute rien </br>";
    }
    
    
    //
    //Utilisateur
    //
        //Clé étrangère : Si l'adresse existe on la récupère
    if ($compteurAdresse == "AUCUNE") {$adresse_id=null;}
    else {
    $adresse = "SELECT adresse_id FROM ADRESSE WHERE adresse_voie='".$adresseU."' AND adresse_ville='".$villeU."' AND adresse_cp='".$cpU."' AND adresse_pays='".$paysU."'";
    $reqA = $BDD -> query ($adresse);
    $ligneA = $reqA -> fetch();
    $adresse_id= $ligneA['adresse_id'];}
    if ($mdpU == "") { // Pas de nouveau mdp
        
        $requete  = $BDD -> prepare ("UPDATE UTILISATEUR
                                  SET utilisateur_nom= :nomU, utilisateur_prenom= :prenomU, utilisateur_dateNaissance= :dateneeU, utilisateur_mail= :mailU, utilisateur_tel= :telU, adresse_id= :adresse_idU
                                  WHERE utilisateur_id=".$_SESSION['id']);
    
    $requete -> bindValue('nomU',$nomU,PDO::PARAM_STR);
    $requete -> bindValue('prenomU',$prenomU , PDO::PARAM_STR);
    $requete -> bindValue('dateneeU',$dateneeU , PDO::PARAM_STR);
    $requete -> bindValue('mailU',$mailU , PDO::PARAM_STR);
    $requete -> bindValue('telU',$telU , PDO::PARAM_STR);
    $requete -> bindvalue('adresse_idU', $adresse_id, PDO::PARAM_INT); 
    
     $requete -> execute();
    }
    else{ //Un nouveau mdp a été inséré
         //Cryptage du nouveau mdp
         $mdpU=password_hash($mdpU,PASSWORD_DEFAULT);
        $requete  = $BDD -> prepare ("UPDATE UTILISATEUR
                                  SET utilisateur_nom= :nomU, utilisateur_prenom= :prenomU, utilisateur_dateNaissance= :dateneeU, utilisateur_mail= :mailU, utilisateur_tel= :telU, utilisateur_mdp=  :mdpU, adresse_id= :adresse_idU
                                  WHERE utilisateur_id=".$_SESSION['id']);
        
    $requete -> bindValue('nomU',$nomU,PDO::PARAM_STR);
    $requete -> bindValue('prenomU',$prenomU , PDO::PARAM_STR);
    $requete -> bindValue('dateneeU',$dateneeU , PDO::PARAM_STR);
    $requete -> bindValue('mailU',$mailU , PDO::PARAM_STR);
    $requete -> bindValue('telU',$telU , PDO::PARAM_STR);
    $requete -> bindvalue('mdpU', $mdpU, PDO::PARAM_STR); 
    $requete -> bindvalue('adresse_idU', $adresse_id, PDO::PARAM_INT); 
    
     $requete -> execute();
    }
    

    $_SESSION['ProfilModifie']=true; // Le profil a été modifié
    
    //Changement de page
    header("Location: Profil.php");
    
} //Fin du if si aucune erreur
else {
    header("Location: ModifierProfil.php");
}    

?>


