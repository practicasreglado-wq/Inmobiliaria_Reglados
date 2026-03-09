<?php
require_once "config/session.php";

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once "config/db.php";

if (!isset($_SESSION['user']['id'])) {
  echo json_encode([
    "success" => false,
    "message" => "Usuario no autenticado"
  ]);
  exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("
  SELECT 
    id,
    nombre,
    apellidos,
    email,
    telefono,
    nombre_usuario,
    profile_picture,
    fecha_nacimiento,
    categoria_seleccionada,
    preferencias
  FROM usuarios 
  WHERE id = :id
");

$stmt->execute([':id' => $user_id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {

  $user["categoria"] = $user["categoria_seleccionada"];
  unset($user["categoria_seleccionada"]);

  if ($user["preferencias"]) {
    $user["preferencias"] = json_decode($user["preferencias"], true);
  }

  echo json_encode([
    "success" => true,
    "user" => $user
  ]);

} else {

  echo json_encode([
    "success" => false,
    "message" => "Usuario no encontrado"
  ]);

}
?>