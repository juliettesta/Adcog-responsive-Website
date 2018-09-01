<?php
    require("../db/connect.php");
    if (isset ($_POST["id"]))
    {
        $requete=$BDD->prepare('UPDATE `liaison_panier` SET `liaisonPanier_postule` = "0" WHERE `liaisonPanier_id` = ?;');
        $requete->execute(array($_POST["id"]));
        $offre=$requete->fetch();
    }
?>