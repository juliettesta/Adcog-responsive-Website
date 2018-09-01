<?php session_start(); ?>
<?php
      include("includes/esTuAdmin.php");

//Connexion à la BDD
require("db/connect.php");
include ('includes/fonctions.php');

//Initialisation variable
$nomU="";
$prenomU="";
$dateneeU=null;
$statutU="";
$mailU="";
$telU="";
$loginU="";
$mdpU="";
$adresseU="";
$villeU="";
$cpU="";
$paysU="";
$compteurAdresse =""; //permet de voir si l'adresse est remplie ou non


//Récupération des données du formulaire + sauvegarde dans les balises sessions
if(isset($_POST['nomU'])){ $nomU = $_POST['nomU']; $_SESSION['nomU'] = $_POST['nomU'] ;}
if(isset($_POST['prenomU'])){ $prenomU = $_POST['prenomU']; $_SESSION['prenomU'] = $_POST['prenomU'] ;}
if(isset($_POST['dateneeU'])){ $dateneeU = $_POST['dateneeU']; $_SESSION['dateneeU'] = $_POST['dateneeU'] ;}
if(isset($_POST['statutU'])){ $statutU = $_POST['statutU']; $_SESSION['statutU'] = $_POST['statutU'] ;}
if(isset($_POST['mailU'])){ $mailU = $_POST['mailU']; $_SESSION['mailU'] = $_POST['mailU'] ;}
if(isset($_POST['telU'])){ $telU = $_POST['telU']; $_SESSION['telU'] = $_POST['telU'] ;}
if(isset($_POST['loginU'])){ $loginU = $_POST['loginU']; $_SESSION['loginU'] = $_POST['loginU'] ;}
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
    //mdp
if (strlen ($mdpU) < 4) //le mdp doit contenir caractère minimum 
{ $_SESSION['erreurmdpU'] = true ;}
else {$_SESSION['erreurmdpU'] = false ;}
    //Login
$requete = "SELECT utilisateur_login FROM UTILISATEUR";
$resultat = $BDD -> query($requete);
$LoginUtilise=0;
while ($ligne = $resultat -> fetch())
{
    if ($ligne['utilisateur_login'] == $loginU)
    {
        $LoginUtilise=1;
    }
}

if ($LoginUtilise==1)
{$_SESSION['erreurloginU']=true;} //Le login rentré existe déjà
else {$_SESSION['erreurloginU']=false;} //Le loginrentré est valide

// Si aucune erreur, on ajout dans la BDD
if (($_SESSION['erreurmdpU']==false)&&($_SESSION['erreurloginU']==false)&&($_SESSION['erreurdateneeU']==false))
{
    //Cryptage mdp
    $mdpU = password_hash($mdpU,PASSWORD_DEFAULT);
//
//ADRESSE
//
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

    // On rajoute la ligne si elle n'existe pas et n'est pas vide
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
        //Clé étrangère
    //On récupère l'id de l'adresse si elle existe
    if ($compteurAdresse == "AUCUNE") {$adresse_id=null;}
    else {
    $adresse = "SELECT adresse_id FROM ADRESSE WHERE adresse_voie='".$adresseU."' AND adresse_ville='".$villeU."' AND adresse_cp='".$cpU."' AND adresse_pays='".$paysU."'";
    $reqA = $BDD -> query ($adresse);
    $ligneA = $reqA -> fetch();
    $adresse_id= $ligneA['adresse_id'];}
       
    $requete = $BDD -> prepare ("INSERT INTO UTILISATEUR(utilisateur_nom, utilisateur_prenom, utilisateur_dateNaissance, utilisateur_dateInscription, utilisateur_statut,  utilisateur_mail, utilisateur_tel, utilisateur_mdp, utilisateur_login, adresse_id, utilisateur_valide)
                                    VALUES (:nomU, :prenomU, :dateneeU, NOW(), :statutU, :mailU, :telU, :mdpU, :loginU, :adresse_idU, 1)");
    
    $requete -> bindValue('nomU',$nomU,PDO::PARAM_STR);
    $requete -> bindValue('prenomU',$prenomU , PDO::PARAM_STR);
    $requete -> bindValue('dateneeU',$dateneeU , PDO::PARAM_STR);
    $requete -> bindValue('statutU',$statutU , PDO::PARAM_STR);
    $requete -> bindValue('mailU',$mailU , PDO::PARAM_STR);
    $requete -> bindValue('telU',$telU , PDO::PARAM_STR);
    $requete -> bindvalue('loginU', $loginU, PDO::PARAM_STR);
    $requete -> bindvalue('mdpU', $mdpU, PDO::PARAM_STR); 
    $requete -> bindvalue('adresse_idU', $adresse_id, PDO::PARAM_INT); 
    
     $requete -> execute();
        
    $_SESSION['IAUtilisateurAjoute']=true; // l'utilisateur a été ajouté
    
   
    //Changement de page
    header("Location: IAusers.php");
    
} //Fin du if si aucune erreur
else {
    header("Location: IAAjoutUsers.php"); // On reste sur la même page s'il y a une erreur
}    
?>
