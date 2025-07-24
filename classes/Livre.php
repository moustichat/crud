<?php

class Livre {
    // Proprietes
    private $pdo;

    // Constructeur
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter un livre
     public function create($titre, $isbn, $date_publication, $nb_pages, $nb_exemplaires, $disponible, $resume) {
        $sql = "INSERT INTO `livres`(`id_livre`, `titre`, `isbn`, `id_auteur`, `id_categorie`, `date_publication`, `nombre_pages`, `nombre_exemplaires`, 
        `disponible`, `resume`, `date_ajout`) VALUES (null, ?,?, null, null , ?,?,?,?,?,NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titre, $isbn, $date_publication, $nb_pages, $nb_exemplaires, $disponible, $resume]);
     }

    // READ - Recuperer tous les livres
    public function getAll(){
        $sql = "SELECT * FROM livres ORDER BY date_publication DESC";

        $stmt = $this->pdo->query($sql);
        
        return $stmt->fetchAll();
    }

    // READ - Recuperer un livre par son ID
    public function getById($id) {
        $sql = "SELECT * FROM livres WHERE id_livre = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // UPDATE - Modifier un livre
    public function update($id, $titre, $isbn, $date_publication, $nb_pages, $nb_exemplaires, $disponible, $resume) {
        $sql = "UPDATE livres SET 
                titre = ?, 
                isbn = ?, 
                date_publication = ?, 
                nombre_pages = ?, 
                nombre_exemplaires = ?, 
                disponible = ?, 
                resume = ? 
                WHERE id_livre = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titre, $isbn, $date_publication, $nb_pages, $nb_exemplaires, $disponible, $resume, $id]);
    }

    // DELETE - Supprimer un livre
    public function delLivre($id) {
        $sql = "DELETE FROM livres WHERE id_livre= ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>