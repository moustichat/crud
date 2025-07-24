<?php

class Membre {
    // Proprietes
    private $pdo;

    // Constructeur
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter un membre
     public function create($nom, $prenom, $email, $telephone, $adresse) {
        $sql = "INSERT INTO membres (nom, prenom, email, telephone, adresse, date_inscription, actif) VALUES (?,?,?,?,?,CURRENT_DATE,1)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $prenom, $email, $telephone, $adresse]);
     }



    // READ - Recuperer un membre par son ID
    public function getById($id) {
        $sql = "SELECT * FROM membres WHERE id_membre = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // UPDATE - Modifier un membre
    public function update($id, $nom, $prenom, $email, $telephone, $adresse, $actif) {
        $sql = "UPDATE membres SET 
                nom = ?, 
                prenom = ?, 
                email = ?, 
                telephone = ?, 
                adresse = ?, 
                actif = ? 
                WHERE id_membre = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $prenom, $email, $telephone, $adresse, $actif, $id]);
    }

    // DELETE - Supprimer un membre
    public function delMembre($id) {
        $sql = "DELETE FROM membres WHERE id_membre = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
