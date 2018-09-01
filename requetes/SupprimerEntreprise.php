<?php
    require("../db/connect.php");
    if (isset ($_POST["entreprise"]))
    {
        /*supprimer une entreprise
            Supprimer : 
                Supprimer contact en premier
                Suppression liaison entreprise/adresse
                Suppressions des offres liées
        */
        $requete=$BDD->prepare('DELETE FROM liaison_panier WHERE offre_id='
                            . '(SELECT offre_id FROM offre WHERE entreprise_id=?);'
                . 'DELETE FROM offre WHERE entreprise_id=?;'
                . 'DELETE FROM liaison_entrepriseadresse WHERE entreprise_id=?;'
                . 'DELETE FROM contact WHERE entreprise_id=?;'
                . 'DELETE FROM entreprise WHERE entreprise_id=?');
        $requete->execute(array($_POST["entreprise"],$_POST["entreprise"],$_POST["entreprise"],$_POST["entreprise"],$_POST["entreprise"]));
    }
?>