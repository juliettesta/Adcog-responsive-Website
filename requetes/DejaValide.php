<?php
    require("../db/connect.php");
    if (isset ($_POST["offre"]))
    {
        $requete=$BDD->prepare('UPDATE `offre` SET `offre_valide` = "0" AND `offre_signalee` = "0" WHERE `offre_id` = ?;');
        $requete->execute(array(($_POST["offre"])));
        $offre=$requete->fetch();
    }
?>