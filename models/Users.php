<?php
class User {
    private $table = 'users';
    private $connexion = null;

    public $id;
    public $nom;
    public $password;

    public function __construct($db)
    {
        if($this->connexion == null) {
            $this->connexion = $db;
        }
    }

    public function addUser() {
        $requete = "INSERT INTO $this->table(`nom`, `password`) VALUES (:username, :password)";
        $sql = $this->connexion->prepare($requete);

        // protection contre les injections sql
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));

        $resultat = $sql->execute([
        "username" => $this->username,
        "password" => $this->password
        ]);

        if ($resultat){
            return true;
        } else {
            return false;
        }
    }

}

?>