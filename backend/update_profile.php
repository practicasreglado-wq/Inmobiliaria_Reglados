<?php
require_once "config/session.php";

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once "config/db.php";

if (!isset($_SESSION['user']['id'])) {
  echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
  exit;
}

$user_id = $_SESSION['user']['id'];

if (isset($_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['telefono'], $_POST['nombre_usuario'])) {

    $data = $_POST;

    /* ACTUALIZAR DATOS */
    $stmt = $pdo->prepare("UPDATE usuarios SET 
        nombre = :nombre,
        apellidos = :apellidos,
        email = :email,
        telefono = :telefono,
        nombre_usuario = :nombre_usuario
        WHERE id = :id");

    $stmt->execute([
        ':nombre' => $data['nombre'],
        ':apellidos' => $data['apellidos'],
        ':email' => $data['email'],
        ':telefono' => $data['telefono'],
        ':nombre_usuario' => $data['nombre_usuario'],
        ':id' => $user_id
    ]);

    /* ACTUALIZAR CONTRASEÑA SOLO SI SE CAMBIA */
    if (!empty($data['password'])) {

        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id");

        $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => $user_id
        ]);
    }

    /* SUBIR FOTO */
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['tmp_name']) {

        $image = $_FILES['profile_picture'];

        /* VALIDAR QUE ES IMAGEN REAL */
        $imageInfo = getimagesize($image['tmp_name']);
        if ($imageInfo === false) {
            echo json_encode(["success" => false, "message" => "El archivo no es una imagen válida"]);
            exit;
        }

        /* LIMITE DE TAMAÑO (2MB) */
        if ($image['size'] > 2 * 1024 * 1024) {
            echo json_encode(["success" => false, "message" => "La imagen supera los 2MB"]);
            exit;
        }

        /* DETECTAR TIPO REAL */
        $type = mime_content_type($image['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png'];

        if (!in_array($type, $allowedTypes)) {
            echo json_encode(["success" => false, "message" => "Tipo de archivo no permitido"]);
            exit;
        }

        $uploadDir = 'uploads/profile_pictures/';

        /* BORRAR FOTO ANTERIOR */
        @unlink($uploadDir . $user_id . '.jpg');
        @unlink($uploadDir . $user_id . '.png');

        $extension = $type === 'image/png' ? '.png' : '.jpg';
        $imagePath = $uploadDir . $user_id . $extension;

        if (move_uploaded_file($image['tmp_name'], $imagePath)) {

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

    $stmt = $pdo->prepare("SELECT profile_picture FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $user_id]);
    $result = $stmt->fetch();

    $profilePicture = $result ? $result['profile_picture'] : null;

    echo json_encode([
        "success" => true,
        "profile_picture" => $profilePicture
    ]);

} else {

    echo json_encode(["success" => false, "message" => "Faltan datos en el formulario"]);

}
?>