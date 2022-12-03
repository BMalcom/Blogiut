<!DOCTYPE html>
<html lang="en">
<?php require './config/init.conf.php';
require_once './vendor/autoload.php';
require_once 'config/check-connexion.conf.php';

/*Permet de charger le template de Twig */
$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, ['debug'=>true]);


include './includes/header.php'; 

/* Affiche la page Twig de la connexion */
echo $twig->render(
    'connexion.html.twig',
[
  'session'=> $_SESSION,
]
);

unset($_SESSION['notification']);
?>
<body>

    <?php 
    if(isset($_POST['bouton'])){

    //Création de l'utilisateur
    $utilisateursFormulaire = new utilisateurs();
    $utilisateursFormulaire->hydrate($_POST);
    print_r2($utilisateursFormulaire);


    $utilisateursManager = new utilisateursManager($bdd);
    $utilisateursEnBdd = $utilisateursManager->getByEmail($utilisateursFormulaire->getEmail());


    $isConnect = password_verify($utilisateursFormulaire->getMdp(), $utilisateursEnBdd->getMdp());



    if ($isConnect == true) {
        $sid = md5($utilisateursEnBdd->getEmail() . time());

        //Création du cookie
        setcookie('sid', $sid, time() + 86400);
        //Mise en bdd du sid
        $utilisateursEnBdd->setSid($sid);

        $utilisateursManager->updateByEmail($utilisateursEnBdd);

    }

    if ($isConnect == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Vous êtes connecté !';
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Vérifiez votre login / mot de passe !';
        header("Location: connexion.php");
        exit();
    }
}
    ?>

    <?php include "includes/footer.php"; ?>
</body>

</html>