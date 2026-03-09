<?php

require_once "config/session.php";

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once "config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$nombre = trim($data["nombre"] ?? "");
$apellidos = trim($data["apellido"] ?? "");
$email = trim($data["email"] ?? "");
$telefono = trim($data["telefono"] ?? "");
$username = trim($data["username"] ?? "");
$password = $data["password"] ?? "";
$confirmPassword = $data["confirmPassword"] ?? "";
$fechaNacimiento = $data["fechaNacimiento"] ?? "";

try {

    if(!$nombre || !$apellidos || !$email || !$telefono || !$username || !$password || !$confirmPassword || !$fechaNacimiento){
        echo json_encode([
            "success"=>false,
            "message"=>"Todos los campos son obligatorios"
        ]);
        exit;
    }

    if($password !== $confirmPassword){
        echo json_encode([
            "success"=>false,
            "message"=>"Las contraseñas no coinciden"
        ]);
        exit;
    }

    if(!preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/",$password)){
        echo json_encode([
            "success"=>false,
            "message"=>"La contraseña debe tener mínimo 8 caracteres, una mayúscula y un número"
        ]);
        exit;
    }

    // validar edad
    $fecha = new DateTime($fechaNacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha)->y;

    if($edad < 18){
        echo json_encode([
            "success"=>false,
            "message"=>"Debes ser mayor de 18 años"
        ]);
        exit;
    }

    // comprobar usuario existente
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email OR nombre_usuario = :username");

    $stmt->execute([
        ":email"=>$email,
        ":username"=>$username
    ]);

    if($stmt->fetch()){
        echo json_encode([
            "success"=>false,
            "message"=>"El usuario o correo ya existe"
        ]);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO usuarios
        (nombre, apellidos, email, telefono, nombre_usuario, password, fecha_nacimiento)
        VALUES
        (:nombre, :apellidos, :email, :telefono, :username, :password, :fecha_nacimiento)
    ");

    $stmt->execute([
        ":nombre"=>$nombre,
        ":apellidos"=>$apellidos,
        ":email"=>$email,
        ":telefono"=>$telefono,
        ":username"=>$username,
        ":password"=>$hash,
        ":fecha_nacimiento"=>$fechaNacimiento
    ]);

    $userId = $pdo->lastInsertId();

    $_SESSION["user"] = [
        "id"=>$userId,
        "nombre_usuario"=>$username,
        "email"=>$email
    ];

    echo json_encode([
        "success"=>true,
        "user"=>$_SESSION["user"]
    ]);

} catch(PDOException $e){

    echo json_encode([
        "success"=>false,
        "message"=>"Error en el servidor",
        "error"=>$e->getMessage()
    ]);

}