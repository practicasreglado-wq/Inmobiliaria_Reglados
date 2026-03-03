<?php

session_start();

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "config/db.php";

if (!isset($_SESSION["user"])) {
    echo json_encode(["loggedIn" => false]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, nombre, email, nombre_usuario,
           categoria_seleccionada, preferencias
    FROM usuarios
    WHERE id = :id
");

$stmt->execute(["id" => $_SESSION["user"]["id"]]);
$usuario = $stmt->fetch();

echo json_encode([
    "loggedIn" => true,
    "user" => [
        "id" => $usuario["id"],
        "nombre" => $usuario["nombre"],
        "email" => $usuario["email"],
        "nombre_usuario" => $usuario["nombre_usuario"],
        "categoria" => $usuario["categoria_seleccionada"],
        "preferencias" => $usuario["preferencias"]
            ? json_decode($usuario["preferencias"], true)
            : null
    ]
]);