<?php 

class Commandes {
    private $table = 'cmmandes';
    private $connexion = null;

    public $id;
    public $user_id;
    public $product_id;
    public $date_commande;


    public function __construct($db)
    {
        if ($this->connexion == null) {
            $this->connexion = $db;
        }
    }


    public function commandeParUser() {
        $requete = "SELECT * FROM $this->table WHERE id = :id";
        $sql = $this->connexion->prepare($requete);
        $resultat = $sql->execute([
            ":id" => $this->id
        ]);
    }

    public function addToCart() {
        $requete = "INSERT INTO $this->table(user_id, product_id, date_commande) VALUES (:user_id, :product_id, :date_commande)";
        $sql = $this->connexion->prepare($requete);
        $resultat = $sql->execute([
            ":user_id" => $this->user_id,
            ":product_id" => $this->product_id,
            ":date_commande" => $this->date_commande
        ]);

        // je recupere le resultat de la requete 
        if ($resultat) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOrder() {
        $requete = "DELETE FROM $this->table WHERE id = :id";
        $sql = $this->connexion->prepare($requete);
        $resultat = $sql->execute([
            ":id" => $this->id
        ]);

        // je recupere le resultat de la requete
        if ($resultat) {
            return true;
        } else {
            return false;
        }
    }


 
}


?>