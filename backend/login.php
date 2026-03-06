<?php
require_once "config/session.php";

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$identifier = trim($data["identifier"] ?? "");
$password = trim($data["password"] ?? "");

if (!$identifier || !$password) {
    echo json_encode(["success" => false, "message" => "Campos obligatorios"]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, nombre, email, nombre_usuario, password,
       profile_picture,
       categoria_seleccionada, preferencias
    FROM usuarios
    WHERE email = :identifier OR nombre_usuario = :identifier
    LIMIT 1
");

$stmt->execute(["identifier" => $identifier]);

$usuario = $stmt->fetch();

if (!$usuario || !password_verify($password, $usuario["password"])) {
    echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
    exit;
}

$_SESSION["user"] = [
    "id" => $usuario["id"],
    "nombre" => $usuario["nombre"],
    "email" => $usuario["email"],
    "nombre_usuario" => $usuario["nombre_usuario"],
    "profile_picture" => $usuario["profile_picture"]
];

echo json_encode([
    "success" => true,
    "user" => [
    "id" => $usuario["id"],
    "nombre" => $usuario["nombre"],
    "email" => $usuario["email"],
    "nombre_usuario" => $usuario["nombre_usuario"],
    "profile_picture" => $usuario["profile_picture"],
    ]
]);