<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$password = trim($data["password"] ?? "");

if (!$email || !$password) {
    echo json_encode(["success" => false, "message" => "Campos obligatorios"]);
    exit;
}

try {

    $stmt = $pdo->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = :email");
    $stmt->execute(["email" => $email]);

    $usuario = $stmt->fetch();

    if (!$usuario) {
        echo json_encode(["success" => false, "message" => "Usuario no existe"]);
        exit;
    }

    if (!password_verify($password, $usuario["password"])) {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $usuario["id"],
            "nombre" => $usuario["nombre"],
            "email" => $usuario["email"]
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error servidor"]);
}