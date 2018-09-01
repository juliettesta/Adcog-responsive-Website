<?php
    require("../db/connect.php");
    if (isset ($_POST["utilisateur"]))
    { 
        $requete=$BDD->prepare('SELECT * FROM `liaison_panier` WHERE `liaisonPanier_postule` = 1 AND `utilisateur_id`=?;');
        $requete->execute(array($_POST['utilisateur']));
        if ($requete->rowcount()==0) echo "true";
        else echo "false";
    }
?>