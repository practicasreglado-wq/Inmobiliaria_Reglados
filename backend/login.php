<?php

session_start();

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
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

$stmt = $pdo->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = :email");
$stmt->execute(["email" => $email]);

$usuario = $stmt->fetch();

if (!$usuario || !password_verify($password, $usuario["password"])) {
    echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
    exit;
}

/*  CREAR SESIÓN */
$_SESSION["user"] = [
    "id" => $usuario["id"],
    "nombre" => $usuario["nombre"],
    "email" => $usuario["email"]
];

echo json_encode([
    "success" => true,
    "user" => $_SESSION["user"]
]);