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

}
