<?php

session_start();

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "No se recibieron datos"
    ]);
    exit;
}

$nombre = trim($data["nombre"] ?? "");
$apellidos = trim($data["apellido"] ?? "");
$email = trim($data["email"] ?? "");
$telefono = trim($data["telefono"] ?? "");
$nombre_usuario = trim($data["username"] ?? "");
$password = trim($data["password"] ?? "");

if (!$nombre || !$apellidos || !$email || !$telefono || !$nombre_usuario || !$password) {
    echo json_encode([
        "success" => false,
        "message" => "Campos obligatorios"
    ]);
    exit;
}

try {

    // Verificar email duplicado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute(["email" => $email]);

    if ($stmt->fetch()) {
        echo json_encode([
            "success" => false,
            "message" => "Email ya registrado"
        ]);
        exit;
    }

    // Verificar username duplicado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nombre_usuario = :username");
    $stmt->execute(["username" => $nombre_usuario]);

    if ($stmt->fetch()) {
        echo json_encode([
            "success" => false,
            "message" => "Nombre de usuario ya existe"
        ]);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO usuarios 
        (nombre, apellidos, email, telefono, nombre_usuario, password)
        VALUES 
        (:nombre, :apellidos, :email, :telefono, :username, :password)
    ");

    $stmt->execute([
        "nombre" => $nombre,
        "apellidos" => $apellidos,
        "email" => $email,
        "telefono" => $telefono,
        "username" => $nombre_usuario,
        "password" => $passwordHash
    ]);

    // 🔥 CREAR SESIÓN AUTOMÁTICA
    $_SESSION["user"] = [
        "id" => $pdo->lastInsertId(),
        "nombre" => $nombre,
        "email" => $email,
        "nombre_usuario" => $nombre_usuario
    ];

    echo json_encode([
        "success" => true,
        "user" => $_SESSION["user"]
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error servidor"
    ]);
}