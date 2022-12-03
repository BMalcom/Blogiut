<!-- Responsive navbar-->
<?php include "config/check-connexion.conf.php"; ?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Bonjour</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if($isConnect == true){ ?>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="articles.php">Ajouter un article</a></li>
                        <li class="nav-item"><a class="nav-link" href="utilisateurs.php">Ajouter un utilisateur</a></li>
                        <li class="nav-item"><a class="nav-link" href="recherche.php">Rechercher un article</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profil</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if($isConnect == false){?>
                        <li class="nav-item"><a class="nav-link" href="index.php">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="recherche.php">Rechercher un article</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>