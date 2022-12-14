<?php

class articlesManager {

    // DECLARATIONS ET INSTANCIATIONS
    private PDO $bdd; // Instance de PDO.
    private ?bool $_result;
    private articles $_article; // Instance de article.
    private int $_getLastInsertId;
    
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);
    }

    /**
     * Get the value of bdd
     *
     * @return PDO
     */
    public function getBdd(): PDO
    {
        return $this->bdd;
    }

    /**
     * Set the value of bdd
     *
     * @param PDO $bdd
     *
     * @return self
     */
    public function setBdd(PDO $bdd): self
    {
        $this->bdd = $bdd;

        return $this;
    }

    /**
     * Get the value of _result
     *
     * @return ?bool
     */
    public function get_result(): ?bool
    {
        return $this->_result;
    }

    /**
     * Set the value of _result
     *
     * @param ?bool $_result
     *
     * @return self
     */
    public function set_result(?bool $_result): self
    {
        $this->_result = $_result;

        return $this;
    }

    /**
     * Get the value of _article
     *
     * @return articles
     */
    public function get_article(): articles
    {
        return $this->_article;
    }

    /**
     * Set the value of _article
     *
     * @param articles $_article
     *
     * @return self
     */
    public function set_article(articles $_article): self
    {
        $this->_article = $_article;

        return $this;
    }

    /**
     * Get the value of _getLastInsertId
     *
     * @return int
     */
    public function get_getLastInsertId(): int
    {
        return $this->_getLastInsertId;
    }

    /**
     * Set the value of _getLastInsertId
     *
     * @param int $_getLastInsertId
     *
     * @return self
     */
    public function set_getLastInsertId(int $_getLastInsertId): self
    {
        $this->_getLastInsertId = $_getLastInsertId;

        return $this;
    }

    /**
     * 
     * @param int $id
     * @return \articles
     */
    public function get(int $id) {
        // Pr??pare une requ??te de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT * FROM articles WHERE id = :id';
        $req = $this->bdd->prepare($sql);
    
        // Ex??cution de la requ??te avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    
        // On stocke les donn??es obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
    
        $articles = new articles();
        $articles->hydrate($donnees);
        //print_r2($articles);
        return $articles;
    }

    /**
     * 
     * @return array
     */
    public function getList(): array {
        $listArticle = [];

        // Pr??pare une requ??te de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM articles';

        $req = $this->bdd->prepare($sql);

        // Ex??cution de la requ??te avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les donn??es obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On cr???? des objets avec les donn??es issues de la table
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        //print_r2($listArticle);
        return $listArticle;
    }

    /**
     * 
     * @param articles $articles
     * @return $this
     */
    public function add(articles $articles) {
        $sql = "INSERT INTO articles "
                . "(titre, texte, publie, date) "
                . "VALUES (:titre, :texte, :publie, :date)";
        $req = $this->bdd->prepare($sql);
        //S??curisation les variables
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_INT);
        $req->bindValue(':date', $articles->getDate(), PDO::PARAM_STR);
        //Ex??cuter la requ??te
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    
    /**
     * 
     * @return int
     */
    public function countArticles(): int {
        $sql = "SELECT COUNT(*) as total FROM articles";
        $req = $this->bdd->prepare($sql);
        $req->execute();
        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];
        return $total;
    }

    /**
     * 
     * @param int $depart
     * @param int $limit
     * @return array
     */
    public function getListArticlesAAfficher(int $depart, int $limit): array {
        $listArticle = [];

        // Pr??pare une requ??te de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM articles '
                . 'LIMIT :depart, :limit';
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':depart', $depart, PDO::PARAM_INT);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);

        // Ex??cution de la requ??te avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les donn??es obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On cr???? des objets avec les donn??es issues de la table
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        //print_r2($listArticle);
        return $listArticle;
    }

    public function update(articles $articles) {
        $sql = "UPDATE articles SET "
                . "titre = :titre, "
                . "texte = :texte, "
                . "publie = :publie "
                . "WHERE id = :id";
        $req = $this->bdd->prepare($sql);
        //S??curisation les variables
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_BOOL);
        $req->bindValue(':id', $articles->getId(), PDO::PARAM_INT);
        //Ex??cuter la requ??te
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
//            $this->_getLastInsertId = $articles->getId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    public function getListArticlesFromRecherche($recherche) {
        $listArticle = [];

        // Pr??pare une requ??te de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM articles '
                . 'WHERE (titre LIKE :recherche '
                . 'OR texte LIKE :recherche)';
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':recherche', "%" . $recherche . "%", PDO::PARAM_STR);

        // Ex??cution de la requ??te avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les donn??es obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On cr???? des objets avec les donn??es issues de la table
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        //print_r2($listArticle);
        return $listArticle;
    }
}


?>