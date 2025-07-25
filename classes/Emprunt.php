<?php

class Emprunt {
    // Proprietes
    private $pdo;
    private $id_membre;
    private $date_emprunt;
    private $date_retour_prevue;
    private $date_retour_effectif;
    private $statut;

    // Constructeur
    public function __construct($pdo, $id_livre, $id_membre, $date_emprunt, $date_retour_prevue, $statut)
    {
        $this->pdo = $pdo;
        $this->id_livre = $id_livre;
        $this->id_membre = $id_membre;
        $this->date_emprunt = $date_emprunt;
        $this->date_retour_prevue = $date_retour_prevue;
        $this->statut = $statut;
        
        $this->date_retour_effectif = null;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter un emprunt
     public function create() {
        $sql = "INSERT INTO emprunts (id_emprunt, id_livre, id_membre, date_emprunt, date_retour_prevue, date_retour_effectif, statut) VALUES (null,?,?,?,?,null,?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->id_livre, $this->id_membre, $this->date_emprunt, $this->date_retour_prevue, $this->statut]);
     }


    // UPDATE - Modifier un emprunt
    public function update($id) {
        $sql = "UPDATE emprunts SET 
                id_livre = ?, 
                id_membre = ?, 
                date_emprunt = ?, 
                date_retour_prevue = ?, 
                date_retour_effectif = ?, 
                statut = ? 
                WHERE id_emprunt = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->id_livre, $this->id_membre, $this->date_emprunt, $this->date_retour_prevue, $this->date_retour_effectif, $this->statut, $id]);
    }

    public function rendre_livre($date) {
        $this->date_retour_effectif = $date;
        $this->statut = 'rendu';
    }
}

?>
