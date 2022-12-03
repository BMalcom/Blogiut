<?php 
require_once 'config/init.conf.php';

/* Supprime le cookie donc déconnecte l'utilisateur */
setcookie('sid');
header("Location: index.php");
?>