<!DOCTYPE html>
<html lang="en">
    <?php require "config/init.conf.php";?>
    
    <?php include "includes/header.php";?>

    <?php include "config/check-connexion.conf.php"; ?>
    
    <body>
        <!-- Responsible navbar-->
        <?php include "includes/menu.php";?>
        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>A Bootstrap 5 Starter Template</h1>
                <p class="lead">A complete project boilerplate built with Bootstrap</p>
                <p>Bootstrap v5.1.3</p>
            </div>
            <div class="row">
                <div class="col-6">
                    Bonjour.
                </div>
                <div class="col-6">
                    Bonsoir.
                </div>
            </div>
        </div>
        <?php include "includes/footer.php";?>
    </body>
</html>
