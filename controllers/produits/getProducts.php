<?php
//entetes requises
//qui peut interroger notre API ==> securité
header("Access-Control-Allow-Origin: *");
//quelle methode on authorise ==> securité
header("Access-Control-Allow-Methods: GET");

//quel format de contenu on envoie
header("Content-Type: application/json; charset=UTF-8");

require_once('../../config/Database.php');
require_once('../../models/Produits.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pdo = new Database();
    $db = $pdo->getConnexion();

    // on instancie l'object produits
    $produits = new Produits($db);
    $resultats = $produits->getProducts();

    if ($resultats->rowCount() > 0) {
        $data = [];
        $data = $resultats->fetchAll();
        echo json_encode($data);
    } else {
        http_response_code(404); // TODO: revoir les codes erreurs
        echo json_encode(["message" =>
        "Aucune données", "code" => 404], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405); // TODO: revoir les codes erreurs
    echo json_encode(["message" =>
    "methode not ALLowed", "code" => 405], JSON_UNESCAPED_UNICODE);
}
