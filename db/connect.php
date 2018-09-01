<?php
try {
$BDD = new PDO("mysql:host=localhost;dbname=projetweb;charset=utf8","projetweb_user","secret",array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
} catch (Exception $ex) {
    die('Echec lors de la connexion a la base de données :' .$e->getMessage());
}
?>