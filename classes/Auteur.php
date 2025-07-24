<?php

class Auteur {
    // Proprietes
    private $pdo;

    // Constructeur
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter un auteur
     public function create($nom, $prenom, $date_naissance, $nationalite) {
        $sql = "INSERT INTO auteurs (nom, prenom, date_naissance, nationalite, date_creation) VALUES (?,?,?,?,NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $prenom, $date_naissance, $nationalite]);
     }

    // READ - Recuperer tous les auteurs
    public function getAll(){
        $sql = "SELECT * FROM auteurs ORDER BY nom DESC";

        $stmt = $this->pdo->query($sql);
        
        return $stmt->fetchAll();
    }

    // READ - Recuperer un auteur par son ID
    public function getById($id) {
        $sql = "SELECT * FROM auteurs WHERE id_auteur = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // UPDATE - Modifier un auteur
    public function update($id, $nom, $prenom, $date_naissance, $nationalite) {
        $sql = "UPDATE auteurs SET 
                nom = ?, 
                prenom = ?, 
                date_naissance = ?, 
                nationalite = ? 
                WHERE id_auteur = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $prenom, $date_naissance, $nationalite, $id]);
    }

    // delAuteur - Supprimer un auteur
    public function delAuteur($id) {
        $sql = "DELETE FROM auteurs WHERE id_auteur = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>