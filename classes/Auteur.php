<?php

class Auteur {
    // Proprietes
    private $pdo;
    private $nom;
    private $prenom;
    private $date_naissance;
    private $nationalite;

    // Constructeur
    public function __construct($pdo, $nom, $prenom, $date_naissance, $nationalite)
    {
        $this->pdo = $pdo;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->nationalite = $nationalite;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter un auteur
     public function create() {
        $sql = "INSERT INTO auteurs (nom, prenom, date_naissance, nationalite, date_creation) VALUES (?,?,?,?,NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->date_naissance, $this->nationalite]);
     }



    // UPDATE - Modifier un auteur
    public function update($id) {
        $sql = "UPDATE auteurs SET 
                nom = ?, 
                prenom = ?, 
                date_naissance = ?, 
                nationalite = ? 
                WHERE id_auteur = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->date_naissance, $this->nationalite, id]);
    }

}

?>