<?php
    require("../db/connect.php");
    if (isset ($_POST["id"]))
    {
        $requete=$BDD->prepare('UPDATE `utilisateur` SET `utilisateur_valide` = "1"  WHERE `utilisateur_id` = ?;');
        $requete->execute(array($_POST["id"]));
        $user=$requete->fetch();
    }
?>