<?php
require './config/init.conf.php';
require_once './vendor/autoload.php';
require_once 'config/check-connexion.conf.php';

/* Permet de charer le template de Twig*/
$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, ['debug'=>true]);


include './includes/header.php'; 


include "includes/menu.php"; 

        /* Pour la pagination */
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        
        $articlesManager = new articlesManager($bdd);
        $nbArticlesTotalAPublie = $articlesManager->countArticles();
    
        $nbPages = ceil($nbArticlesTotalAPublie / nb_articles_par_page);
    
        $indexDepart = ($page - 1) * nb_articles_par_page;
    
        $listeArticles = $articlesManager->getListArticlesAAfficher($indexDepart, nb_articles_par_page);

        /*Permet d'afficher la page Twig de l'index*/
        echo $twig->render(
            'index.html.twig',
        [
          'session'=> $_SESSION,
          'listeArticles' => $listeArticles,
          'nbPages' => $nbPages
        ]
        );

        unset($_SESSION['notification']);
        
include "includes/footer.php"; ?>