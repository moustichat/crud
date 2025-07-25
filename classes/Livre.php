<?php

class Livre {
    // Proprietes
    private $pdo;
    private $titre;
    private $isbn;
    private $id_auteur;
    private $id_categorie;
    private $date_publication;
    private $nombre_pages;
    private $nombre_exemplaires;
    private $disponible;
    private $resume;


    // Constructeur
    public function __construct($pdo, $titre, $isbn, $id_auteur, $id_categorie, $date_publication, $nombre_pages, $nombre_exemplaires, $disponible, $resume)
    {
        $this->pdo = $pdo;
        $this->titre = $titre;
        $this->isbn = $isbn;
        $this->id_auteur = $id_auteur;
        $this->id_categorie = $id_categorie;
        $this->date_publication = $date_publication;
        $this->nombre_pages = $nombre_pages;
        $this->nombre_exemplaires = $nombre_exemplaires;
        $this->disponible = $disponible;
        $this->resume = $resume;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter un livre
    public function create() {
        $sql = "INSERT INTO `livres`(`id_livre`, `titre`, `isbn`, `id_auteur`, `id_categorie`, `date_publication`, `nombre_pages`, `nombre_exemplaires`, 
        `disponible`, `resume`, `date_ajout`) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->titre, $this->isbn, $this->id_auteur, $this->id_categorie, $this->date_publication, $this->nombre_pages, $this->nombre_exemplaires, $this->disponible, $this->resume]);
    }


    // UPDATE - Modifier un livre
    public function update($id) {
        $sql = "UPDATE livres SET 
                titre = ?, 
                isbn = ?,
                `id_auteur` = ?,
                `id_categorie` = ?,
                date_publication = ?, 
                nombre_pages = ?, 
                nombre_exemplaires = ?, 
                disponible = ?, 
                resume = ? 
                WHERE id_livre = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->titre, $this->isbn, $this->id_auteur, $this->id_categorie, $this->date_publication, $this->nombre_pages, $this->nombre_exemplaires, $this->disponible, $this->resume, $id]);
    }

    
}

?>