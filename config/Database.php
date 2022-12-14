<?php

class Database
{
    // proprietes de la connexion a la BDD
    private $host = 'localhost';
    private $dbname = 'saveurs_du_maroc';
    private $username = 'root';
    private $password = '';


    // connexion a la BDD
    public function getConnexion()
    {
        $con = null;
        try {
            $con = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8",
                $this->username,
                $this->password,
                [
                    
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // atribut errmode c'est pour gérer les erreures
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // le resulta de fetch va etre un tableau associatif clé valeur les clés represente les noms de colonnes 
                ]
            );
        } catch (PDOException $e) {
            echo "erreur de connexion : " . $e->getMessage();
        }
        return $con;
    }
}
// sources:
//https://youtu.be/aIEBmjtJEu0
