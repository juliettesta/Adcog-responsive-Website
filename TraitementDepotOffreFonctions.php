<?php

//Transfert d'image
function transfertImage($l)
{
$dossier = 'logos/'; // Dossier de stockage
$fichier = basename($_FILES[$l]['name']); //Enregistrement du nom de l'image
$taille_maxi = 100000;
$taille = filesize($_FILES[$l]['tmp_name']); // Enregistrement de la taille de l'image
$extensions = array('.png', '.gif', '.jpg', '.jpeg'); // Extension autorisée
$extension = strrchr($_FILES[$l]['name'], '.');  // Enregistrement de l'extension

//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $info = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg...';
     $_SESSION['erreurIext'] = true;
}
if($taille>$taille_maxi) // Si l'image dépasse la taille maximal
{
     $info = 'L\'image dépasse la taille max';
     $_SESSION['erreurItaille'] = true;
}
if(!isset($info)) //S'il n'y a pas d'erreur, on upload
{
    $fichier = "image_du_".date("YmdHis")."".$extension; // renomme le fichier pour que le nom soit unique
     if(move_uploaded_file($_FILES[$l]['tmp_name'], $dossier . $fichier)) 
     {
          $info= 'Upload effectué avec succès !';
          $_SESSION['erreurIext'] = false;
          $_SESSION['erreurItaille'] = false;
          return $fichier; // On retourne le nouveau nom du fichier
     }
     else 
     {
          $info= 'Echec de l\'upload !';
     }
}

}

// Transfert de fichier
function transfertFichier($l)
{
$dossier = 'fichiers/'; // Dossier de reception des fichiers
$fichier = basename($_FILES[$l]['name']); 
$taille_maxi = 100000;
$taille = filesize($_FILES[$l]['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.txt', '.pdf','.docx','.pptx','.xlsx','.odt'); //Extensions possibles pour le fichier
$extension = strrchr($_FILES[$l]['name'], '.'); 

//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $info = 'Vous devez uploader un fichier de type pdf, txt, docx, pptx, xlsx, odt,  png, gif, jpg, ou jpeg.';
     $_SESSION['erreurFext'] = true;
     
}
if($taille>$taille_maxi) //Si le fichier dépasse la taille maximal
{
     $info = 'Le fichier dépasse la taille max';
     $_SESSION['erreurFtaille'] = true;
}
if(!isset($info)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
    $fichier = "fichier_du_".date("YmdHis")."".$extension; // renomme le fichier pour que le nom soit unique
     if(move_uploaded_file($_FILES[$l]['tmp_name'], $dossier . $fichier))
     {
          $info= 'Upload effectué avec succès !';
          $_SESSION['erreurFext'] = false;
          $_SESSION['erreurFtaille'] = false;
          return $fichier;
     }
     else
     {
          $info= 'Echec de l\'upload !';
     }
}

}

?>

