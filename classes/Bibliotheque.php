<?php

class Bibliotheque {
    // Proprietes
    private $pdo;

    // Constructeur
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Methodes CRUD


    // READ - Recuperer tous les livres
    public function getAllLivres(){
        $sql = "SELECT * FROM livres ORDER BY date_publication DESC";

        $stmt = $this->pdo->query($sql);
        
        return $stmt->fetchAll();
    }

    public function getLivre($id){
        $sql = "SELECT * FROM livres WHERE id_livre = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // DELETE - Supprimer un livre
    public function delLivre($id) {
        $sql = "DELETE FROM livres WHERE id_livre= ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }



    

    // READ - Recuperer tous les auteurs
    public function getAllAuteurs(){
        $sql = "SELECT * FROM auteurs ORDER BY nom DESC";

        $stmt = $this->pdo->query($sql);
        
        return $stmt->fetchAll();
    }

    public function getAllCategories(){
        $sql = "SELECT * FROM categories ORDER BY nom_categorie DESC";

        $stmt = $this->pdo->query($sql);
        
        return $stmt->fetchAll();
    }

    // READ - Recuperer tous les emprunts
    public function getAllEmprunts(){
        $sql = "SELECT e.*, l.titre, CONCAT(m.prenom, ' ', m.nom) as membre_nom 
                FROM emprunts e 
                JOIN livres l ON e.id_livre = l.id_livre 
                JOIN membres m ON e.id_membre = m.id_membre 
                ORDER BY e.date_emprunt DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // READ - Recuperer tous les membres
    public function getAllMembres(){
        $sql = "SELECT * FROM membres ORDER BY nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

}

?>