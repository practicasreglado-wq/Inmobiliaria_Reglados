<?php
require_once "config/session.php";
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once "config/db.php";

// Verificar si la sesión tiene el ID de usuario
if (!isset($_SESSION['user']['id'])) {
  echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
  exit;
}

$user_id = $_SESSION['user']['id'];

// Verificar si los datos se han enviado correctamente
if (isset($_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['telefono'], $_POST['nombre_usuario'], $_POST['password'])) {
    
    // Recoger los datos del formulario
    $data = $_POST;

    // Actualizamos los datos del usuario
    $stmt = $pdo->prepare("UPDATE usuarios SET 
        nombre = :nombre, 
        apellidos = :apellidos, 
        email = :email, 
        telefono = :telefono, 
        nombre_usuario = :nombre_usuario, 
        password = :password 
        WHERE id = :id");

    $stmt->execute([
        ':nombre' => $data['nombre'],
        ':apellidos' => $data['apellidos'],
        ':email' => $data['email'],
        ':telefono' => $data['telefono'],
        ':nombre_usuario' => $data['nombre_usuario'],
        ':password' => password_hash($data['password'], PASSWORD_BCRYPT),
        ':id' => $user_id
    ]);

    // Subir imagen si se proporciona
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['tmp_name']) {
        $image = $_FILES['profile_picture'];

        // Verificar que el archivo sea una imagen
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($image['type'], $allowedTypes)) {
            echo json_encode(["success" => false, "message" => "Tipo de archivo no permitido"]);
            exit;
        }

        // Establecer la carpeta de subida
        $uploadDir = 'uploads/profile_pictures/';
        $imagePath = $uploadDir . $user_id . '.jpg';

        // Mover el archivo al directorio de imágenes
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Actualizar la base de datos con la nueva imagen
            $stmt = $pdo->prepare("UPDATE usuarios SET profile_picture = :profile_picture WHERE id = :id");
            $stmt->execute([
                ':profile_picture' => $imagePath,
                ':id' => $user_id
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al subir la imagen"]);
            exit;
        }
    }

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Faltan datos en el formulario"]);
}
?>