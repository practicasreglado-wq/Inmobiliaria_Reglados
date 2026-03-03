<?php

session_start();

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "config/db.php";

if (!isset($_SESSION["user"])) {
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$categoria = $data["categoria"] ?? null;
$preferencias = $data["preferencias"] ?? null;

if (!$categoria || !isset($preferencias)) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE usuarios 
        SET categoria_seleccionada = :categoria,
            preferencias = :preferencias
        WHERE id = :id
    ");

    $stmt->execute([
        "categoria" => $categoria,
        "preferencias" => json_encode($preferencias),
        "id" => $_SESSION["user"]["id"]
    ]);

    echo json_encode(["success" => true]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error servidor"]);
}