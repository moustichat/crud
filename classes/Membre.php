<?php

class Membre {
    // Proprietes
    private $pdo;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $adresse;
    private $actif;
    

    // Constructeur
    public function __construct($pdo, $nom, $prenom, $email, $telephone, $adresse, $actif = TRUE)
    {
        $this->pdo = $pdo;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->actif = $actif;
        }

    // Methodes CRUD


    
    // CREATE - Ajouter un membre
     public function create() {
        $sql = "INSERT INTO membres (nom, prenom, email, telephone, adresse, date_inscription, actif) VALUES (?,?,?,?,?,CURRENT_DATE,1)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->telephone, $this->adresse]);
     }


    // UPDATE - Modifier un membre
    public function update($id) {
        $sql = "UPDATE membres SET 
                nom = ?, 
                prenom = ?, 
                email = ?, 
                telephone = ?, 
                adresse = ?, 
                actif = ? 
                WHERE id_membre = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->telephone, $this->adresse, $this->actif, $id]);
    }

    
}

?>
