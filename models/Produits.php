<?php

class Produits
{
    private $table = 'produits';
    private $connexion = null;

    public $id;
    public $nom;
    public $prix;
    public $description;
    public $img;
    public $categorie;

    public function __construct($db)
    {
        if ($this->connexion == null) {
            $this->connexion = $db;
        }
    }

    public function getProducts()
    {
        $requete = "SELECT * FROM $this->table";
        return $this->connexion->query($requete);
    }

    public function addProducts()
    {
        $requete = "INSERT INTO $this->table(`nom`, `prix`, `description`, `img`, `categorie`) VALUES (:nom,:prix,:description,:img,:categorie)";
        $sql = $this->connexion->prepare($requete);
        $resultat = $sql->execute([
            ":nom" => $this->nom,
            ":prix" => $this->prix,
            ":description" => $this->description,
            ":img" => $this->img,
            ":categorie" => $this->categorie
        ]);

        // on recuperd le resultat de la requete
        if ($resultat) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProducts()
    {
        $requete = "DELETE FROM $this->table WHERE id = :id";
        $sql = $this->connexion->prepare($requete);
        $resultat = $sql->execute([
            ":id" => $this->id
        ]);

        // on recupere le resultat de la requete

        if ($resultat) {
            return true;
        } else {
            return false;
        }
    }
}
