<?php session_start(); ?>
<?php

//Connexion à la BDD
require("db/connect.php");
include ('includes/fonctions.php');

//Initialisation variable
$numO=null; // numero id
$mdpO="";

//Récupération des données
if(isset($_POST['numO'])){ $numO = $_POST['numO']; $_SESSION['numO'] = $_POST['numO'] ;}
if(isset($_POST['mdpO'])){ $mdpO = $_POST['mdpO']; }

// Traitement des erreurs

//numero offre non existant
    $Requete= $BDD -> prepare("SELECT * FROM OFFRE WHERE offre_id= ?");
    $Requete -> execute (array ($_POST['numO']));
    if ($Requete -> rowcount()==0) 
    {    
           $_SESSION['erreurnumOffre']=true;
    }
    else
    {
        $_SESSION['erreurnumOffre']=false;
    }
    $ligne = $Requete -> fetch();
    $testmdp = password_verify($mdpO, $ligne['offre_mdp']);
    if ($testmdp) { $_SESSION['erreurmdp']=false;}
    else {$_SESSION['erreurmdp']=true;}
   print $testmdp;
    
//Si aucune erreur accès à la page de modification de l'offre avec transmission de l'id de l'offre
if (($_SESSION['erreurnumOffre']==false)&&($_SESSION['erreurmdp']==false))
{
   header('Location: ModifierOffre.php');  //aller à la page de modification
}
            
else { // S'il y a une erreur, on reste sur la même page avec le num de l'offre
    header("Location: ModifierSupprimerOffre.php");
}   
?>
