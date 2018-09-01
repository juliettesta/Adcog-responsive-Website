<?php
    require("../db/connect.php");
    if (isset ($_POST["id"]))
    {
        $requete=$BDD->prepare('UPDATE `liaison_panier` SET `liaisonPanier_postule` = 1 WHERE `liaisonPanier_id` = ?');
        $requete->execute(array($_POST["id"]));
    }
?>