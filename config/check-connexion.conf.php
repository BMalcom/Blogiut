<?php


$isConnect = false;

if(isset($_COOKIE['sid'])){
    $isConnect = true;
    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getBySid($_COOKIE['sid']);
}

?>