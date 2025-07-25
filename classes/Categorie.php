<?php

class Categorie {
    // Proprietes
    private $pdo;
    private $nom_categorie;
    private $description;

    // Constructeur
    public function __construct($pdo, $nom_categorie, $description)
    {
        $this->pdo = $pdo;
        $this->nom_categorie = $nom_categorie;
        $this->description = $description;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter une catégorie
     public function create() {
        $sql = "INSERT INTO `categories` (`id_categorie`, `nom_categorie`, `description`) VALUES (null,?,?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->nom_categorie, $this->description]);
     }


    // UPDATE - Modifier une catégorie
    public function update($id) {
        $sql = "UPDATE categories SET 
                nom_categorie = ?, 
                `description` = ? 
                WHERE id_categorie = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->nom_categorie, $this->description, $id]);
    }
}

?>