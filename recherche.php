<!DOCTYPE html>
<html lang="en">
<?php require "config/init.conf.php"; ?>

<?php include "includes/header.php"; ?>

<?php include "config/check-connexion.conf.php"; ?>


<body>
    <!-- Responsible navbar-->
    <?php include "includes/menu.php"; ?>
    <!-- Page content-->
        <?php     
        
        /** On recherche dans la base de donnée s'il y a un article qui contient le mot entré dans le texte */
        if(!empty($_GET['search'])){
            $articlesManager = new articlesManager($bdd);
    
            $listeArticles = $articlesManager->getListArticlesFromRecherche($_GET['search']);

        }
        else{
            $listeArticles = [];
        }

        ?>


        </div>
    </div>
    <div class="row mb-5">
        <form id="" method="GET" action="recherche.php">
            <div class="col-6">
                <input type="text" class="form-control" name="search" value="" placeholder="Mot clé....">
            </div>
            <div class="col-6">
                <button type="submit" id="submit" value="recherche" class="btn btn-primary">Rechercher</button>
            </div>
        </form>
    </div> 
        <div class="row">
            <?php
            /* Pour afficher les articles recherché */
            foreach ($listeArticles as $articles) {
            ?>
                <div class="col-6 mb-4">
                    <div class="card">
                        <img src="img/<?= $articles->getId(); ?>.jpg" style="max-width: 200px;" class="card-img-top" alt="<?= $articles->getTitre() ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $articles->getTitre() ?></h5>
                            <p class="card-text"><?= $articles->getTexte() ?></p>
                            <a href="articles.php?idArticles=<?php echo $articles->getId() ?>" class="btn btn-primary">Modifier</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div> 
    </div>
    <?php include "includes/footer.php"; ?>
</body>

</html>