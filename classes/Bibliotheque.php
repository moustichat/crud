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

    // Vérifie si un isbn existe déjà
    public function isbnExists($isbn) {
        $sql = "SELECT id_livre FROM livres WHERE isbn = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$isbn]);
        return $stmt->fetchColumn(); // Retourne l'id si l'isbn existe, pour voir si le livre est identique
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

    // READ - Recuperer un auteur par son ID
    public function getAuteur($id) {
        $sql = "SELECT * FROM auteurs WHERE id_auteur = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // DELETE - Supprimer un auteur
    public function delAuteur($id) {
        $sql = "DELETE FROM auteurs WHERE id_auteur = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getAllCategories(){
        $sql = "SELECT * FROM categories ORDER BY nom_categorie DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // READ - Recuperer une catégorie par son ID
    public function getCategorie($id) {
        $sql = "SELECT * FROM categories WHERE id_categorie = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // delCategorie - Supprimer une catégorie
    public function delCategorie($id) {
        $sql = "DELETE FROM categories WHERE id_categorie = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
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

    // READ - Recuperer un emprunt par son ID
    public function getEmprunt($id) {
        $sql = "SELECT * FROM emprunts WHERE id_emprunt = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // DELETE - Supprimer un emprunt
    public function delEmprunt($id) {
        $sql = "DELETE FROM emprunts WHERE id_emprunt = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }



    // READ - Recuperer tous les membres
    public function getAllMembres(){
        $sql = "SELECT * FROM membres ORDER BY nom ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getMembre($id){
        $sql = "SELECT * FROM membres WHERE id_membre = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // DELETE - Supprimer un membre
    public function delMembre($id) {
        $sql = "DELETE FROM membres WHERE id_membre = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Vérifie si un email existe déjà
    public function emailExists($email) {
        $sql = "SELECT id_membre FROM membres WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn();
    }

}

?>