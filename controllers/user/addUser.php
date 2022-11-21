<?php
// entetes requises
// qui peut interroger notre API ==> securité
header("access-Control-Allow-Origin: *");
header("access-Control-Allow-Headers: X-Requested-With");
header("access-Control-Allow-Methods: POST");
header("access-Type: application/json; charset=UTF-8");

require_once('../../config/Database.php');
require_once('../../models/Users.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new Database();
    $db = $pdo->getConnexion();
    $user = new User($db);
    $salt = "monsalt2022";

    // on récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));

    $password = hash('md5', $salt . htmlentities($donnees->password));
    $username = $donnees->username;


    $user->username = $username;
    $user->password = $password;

    //salé le password


    if ($user->addUser()) {
        http_response_code(201);
        echo json_encode(["message" => "L'ajout a été effectué"]);
    } else {
        // ici la création n'a pas fonctionné
        // on envoie un code 503
        http_response_code(503);
        echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
    }
} else {
    http_response_code(405); // TODO: revoir les codes erreurs
    echo json_encode(["message" => "methode not Allowed"]);
}
