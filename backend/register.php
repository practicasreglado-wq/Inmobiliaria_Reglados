<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$nombre = trim($data["nombre"] ?? "");
$apellido = trim($data["apellidos"] ?? "");
$telefono = trim($data["telefono"] ?? "");
$username = trim($data["nombre_usuario"] ?? "");
$email = trim($data["email"] ?? "");
$password = trim($data["password"] ?? "");


if (!$nombre || !$email || !$password) {
    echo json_encode(["success" => false, "message" => "Campos obligatorios"]);
    exit;
}

try {

    // Verificar si ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute(["email" => $email]);

    if ($stmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Email ya registrado"]);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO usuarios (nombre,apellidos,telefono,nombre_usuario,email, password)
        VALUES (:nombre, :apellidos, :telefono, :nombre_usuario, :email, :password)
    ");

    $stmt->execute([
        "nombre" => $nombre,
        "apellidos" => $apellido,
        "telefono" => $telefono,
        "nombre_usuario" => $username,
        "email" => $email,
        "password" => $passwordHash
    ]);

    echo json_encode(["success" => true, "message" => "Usuario registrado"]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error servidor"]);
}
