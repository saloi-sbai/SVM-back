<?php
require_once('../../config/Database.php');
require_once('../../models/Users.php');

//CORS ==> https://stackoverflow.com/questions/18382740/cors-not-working-php

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header("Content-Type: application/json; charset=UTF-8");
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new Database();
    $db = $pdo->getConnexion();
    $user = new User($db);
    $salt = "monsalt2022";

    // on récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));

    $password = hash('md5', $salt . htmlentities($donnees->password));
    $username = htmlentities($donnees->username);

    $user->nom = $username;
    $user->password = $password;

    $resultats = $user->getUser();

    if ($resultats->rowCount() > 0) {
        $data = [];
        $data = $resultats->fetchAll();
        echo json_encode($data);
    } else {
        http_response_code(401); // non-autorisé
        echo json_encode(["message" => "le username ou le mot de passe est incorrect", "code" => 401], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405); // methode non-autorisé
    echo json_encode(["message" => "methode non authaurisée", "code" => 405], JSON_UNESCAPED_UNICODE);
}
