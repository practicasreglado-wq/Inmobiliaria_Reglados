<?php
require_once "config/session.php";

header("Access-Control-Allow-Origin: http://localhost:5173"); // Permite peticiones desde el frontend
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once "config/db.php";

// Verificar si la sesión tiene el ID de usuario
if (!isset($_SESSION['user']['id'])) {
  echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
  exit;
}

$user_id = $_SESSION['user']['id'];

// Obtener los datos del usuario desde la base de datos
$stmt = $pdo->prepare("SELECT id, nombre, apellidos, email, telefono, nombre_usuario, profile_picture FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $user_id]);

$user = $stmt->fetch();

if ($user) {
  echo json_encode([
    "success" => true,
    "user" => $user
  ]);
} else {
  echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
}
?>