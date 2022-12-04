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
    $username = $donnees->username;

    $user->username = $username;
    $user->password = $password;

    // on vérifie que l'utilisateur n'existe pas déja
    $present = $user->getUser()->fetchAll();

    if (count($present)>0){
        http_response_code(503);
        echo json_encode(["message" =>"Cet utilisateur existe déja dans la base", "code" =>503], JSON_UNESCAPED_UNICODE);
        die();
    }

    if ($user->addUser()) {
        http_response_code(201);
        echo json_encode(["message" =>
        "L'ajout a été effectué", "code" => 201], JSON_UNESCAPED_UNICODE);
    } else {
        // ici la création n'a pas fonctionné
        // on envoie un code 503
        http_response_code(503); // service non disponible
        echo json_encode(["message" =>
        "L'ajout n'a pas été effectué", "code" => 503], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405); // methode non-autorisé
    echo json_encode(["message" =>
    "methode non authaurisée", "code" => 405], JSON_UNESCAPED_UNICODE);
}
