<!DOCTYPE html>
<html lang="en">
<?php require "config/init.conf.php"; ?>

<?php include "includes/header.php"; ?>

<?php include "config/check-connexion.conf.php"; ?>

<body>
    <?php include "includes/menu.php";?>

    <?php 
    if(!empty($_POST['bouton'])){
        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($_POST);
        
        $utilisateurs->setMdp(password_hash($utilisateurs->getMdp(), PASSWORD_DEFAULT));
        //Insérer l'article en base de données
        $utilisateursManager = new utilisateursManager($bdd);
        $utilisateursManager->add($utilisateurs);
        

        $messageNotification = $utilisateursManager->get_result() == true ? "Votre utilisateur a été ajouté !" : "Une erreur est survenu lors de l'ajout de votre utilisateur";
        $resultNotification = $utilisateursManager->get_result() == true ? "success" : "danger";

        $_SESSION['notification']['result'] = $resultNotification;
        $_SESSION['notification']['message'] = $messageNotification;

        header("Location: index.php");
        exit();
        
    }
    ?>

    <div class="container">
        <form id="utilisateurForm" method="POST" action="utilisateurs.php" enctype="multipart/form-data">
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                    <label for="nom"> Nom :</label>
                    <input type="text" id="nom" name="nom" />
                </div>
            </div>    
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" />
                </div>
            </div>    
        </div>
        <div class="row">
                <div class="col-8 offset-2">
                <label for="email"> Email :</label>
                <input type="email" id="email" name="email" />
                </div>
            </div>    
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                <label for="mdp"> Mot de Passe :</label>
                <input type="password" id="mdp" name="mdp" />
                </div>
            </div>    
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-8 offset-2">
                <input type="submit" class="btn btn-primary" id="bouton" name="bouton" value="ajouter" /> <br>
                </div>
            </div>    
        </div>
    </div>



        </form>

    <?php include "includes/footer.php"; ?>
</body>

</html>