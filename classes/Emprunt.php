<?php

class Emprunt {
    // Proprietes
    private $pdo;

    // Constructeur
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Methodes CRUD
    
    // CREATE - Ajouter un emprunt
     public function create($id_livre, $id_membre, $date_emprunt, $date_retour_prevue, $statut) {
        $sql = "INSERT INTO emprunts (id_livre, id_membre, date_emprunt, date_retour_prevue, date_retour_effectif, statut) VALUES (?,?,?,?,null,?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_livre, $id_membre, $date_emprunt, $date_retour_prevue, $statut]);
     }



    // READ - Recuperer un emprunt par son ID
    public function getById($id) {
        $sql = "SELECT * FROM emprunts WHERE id_emprunt = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // UPDATE - Modifier un emprunt
    public function update($id, $id_livre, $id_membre, $date_emprunt, $date_retour_prevue, $date_retour_effectif, $statut) {
        $sql = "UPDATE emprunts SET 
                id_livre = ?, 
                id_membre = ?, 
                date_emprunt = ?, 
                date_retour_prevue = ?, 
                date_retour_effectif = ?, 
                statut = ? 
                WHERE id_emprunt = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_livre, $id_membre, $date_emprunt, $date_retour_prevue, $date_retour_effectif, $statut, $id]);
    }

    // DELETE - Supprimer un emprunt
    public function delEmprunt($id) {
        $sql = "DELETE FROM emprunts WHERE id_emprunt = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }


}

?>
