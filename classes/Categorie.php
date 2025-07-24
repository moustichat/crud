<?php

class Categorie {
    // Proprietes
    private $pdo;

    // Constructeur
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter une catégorie
     public function create($nom_categorie, $description) {
        $sql = "INSERT INTO `categories` (`id_categorie`, `nom_categorie`, `description`) VALUES (null,?,?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom_categorie, $description]);
     }

    // READ - Recuperer toutes les catégories
    public function getAll(){
        $sql = "SELECT * FROM categories ORDER BY id_categorie asc";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // READ - Recuperer une catégorie par son ID
    public function getById($id) {
        $sql = "SELECT * FROM categories WHERE id_categorie = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // UPDATE - Modifier une catégorie
    public function update($id, $nom_categorie, $description) {
        $sql = "UPDATE categories SET 
                nom_categorie = ?, 
                description = ? 
                WHERE id_categorie = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom_categorie, $description, $id]);
    }

    // delCategorie - Supprimer une catégorie
    public function delCategorie($id) {
        $sql = "DELETE FROM categories WHERE id_categorie = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>