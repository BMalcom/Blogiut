<!DOCTYPE html>
<html lang="en">
<?php require './config/init.conf.php';
require_once './vendor/autoload.php';
require_once 'config/check-connexion.conf.php';
include './includes/header.php'; 

?>


<body>
    <!-- Responsible navbar-->
    <?php include "includes/menu.php";?>
    <?php   

    /*S'il y a une valeur dans idArticles, on change la valeur du bouton en "Modifier"
    et on rempli les input avec les valeurs de l'article
    sinon la valeur du bouton est "Ajouter" */
    if(!empty($_GET['idArticles'])){
        $idArticles = $_GET['idArticles'];
        $articles = new articlesManager($bdd);
        $articlesId = $articles->get($idArticles);
        $valueTitre = $articlesId->titre;
        $valueTexte = $articlesId->texte;
        $valueButton = "Modifier";
        $valueIdArticles = $_GET['idArticles'];
    }
    else{
        $valueTitre = "";
        $valueTexte = "";
        $valueButton = "Ajouter";
    }

    /*Si la valeur du bouton est "Modifier" alors on modifie l'article */
    if(!empty($_POST['Modifier'])){
        $articles = new articles();
        $articles->hydrate($_POST);
        $articles->setId($_POST['idArticles']);
        $articles->setDate(date('Y-m-d'));
        $articlesManager = new articlesManager($bdd);
        /*Modifier l'article dans la base de donnée */
        $articlesManager->update($articles);

    if($articlesManager->get_result() == true){
        if($_FILES['image']['error'] == 0){
            $nomImage = $articlesManager->get_getLastInsertId();
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ ."/img/".$nomImage.".jpg");
        }
    }

        $messageNotification = $articlesManager->get_result() == true ? "Votre artcile a été ajouté/modifié !" : "Une erreur est survenu lors de l'ajout de votre article";
        $resultNotification = $articlesManager->get_result() == true ? "success" : "danger";

        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;

        header("Location: index.php");
        exit();
    }

    /*Si la valeur du bouton est "Ajouter" alors on rajoute un article dans la base de donnée */
    if(!empty($_POST['Ajouter'])){
        $articles = new articles();
        $articles->hydrate($_POST);
        $articles->setDate(date('Y-m-d'));

        /*Insérer l'article en base de données*/
        $articlesManager = new articlesManager($bdd);
        $articlesManager->add($articles);


        /*Si l'article est inséré, on traite l'image*/
        if($articlesManager->get_result() == true){
            if($_FILES['image']['error'] == 0){
                $nomImage = $articlesManager->get_getLastInsertId();
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ ."/img/".$nomImage.".jpg");
            }
        }
        $messageNotification = $articlesManager->get_result() == true ? "Votre artcile a été ajouté !" : "Une erreur est survenu lors de l'ajout de votre article";
        $resultNotification = $articlesManager->get_result() == true ? "success" : "danger";

        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;

        print_r2($_FILES);
        header("Location: index.php");
        exit();
    }
    ?>
    <!-- Page content-->

        <form id="articleForm" method="POST" action="articles.php" enctype="multipart/form-data">
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                    <label for="titre"> Titre de l'article</label>
                    <input type="text" id="titre" name="titre" placeholder="Choisissez un titre" value="<?= $valueTitre ?>" />
                </div>
            </div>    
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                <label for="texte">Texte de l'article</label>
                <input type="textarea" class="form-control" rows="3" id="texte" name="texte" value="<?= $valueTexte ?>" />
                </div>
            </div>    
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                <img src="img/<?= $articlesId->getId(); ?>.jpg" style="max-width: 100px;" alt="<?= $articlesId->getTitre(); ?>"></br>
                <label for="image"> Choisir une image</label>
                <input type="file" id="image" name="image" />
                </div>
            </div>    
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                <label for="publie" >Publié ?</label>
                <input type="checkbox" id="publie" name="publie" />
                </div>
            </div>    
        </div>
        <input type="hidden" id="idArticles" name="idArticles" value="<?= $valueIdArticles ?>" />
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                <input type="submit" class="btn btn-primary" id="bouton" name="<?= $valueButton ?>" value="<?= $valueButton ?>"/> <br>
                </div>
            </div>    
        </div>
    </div>
</form>

    <?php include "includes/footer.php"; ?>
</body>

</html>