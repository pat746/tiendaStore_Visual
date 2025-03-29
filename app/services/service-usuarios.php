<?php
require_once "../models/Usuario.php";
$usuario = new Usuario();

$metodo = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Allow: GET, POST");
header("Content-Type: application/json; charset=utf-8");

if ($metodo == 'GET') {
    $registros = [];
    if (isset($_GET['q'])) {
        switch ($_GET['q']) {
            case 'findById':
                if (!isset($_GET['id'])) {
                    echo json_encode(["error" => "Falta el ID"]);
                    exit;
                }
                $registros = $usuario->getById(['id' => $_GET['id']]);
                break;
            case 'showAll':
                $registros = $usuario->getAll();
                break;
        }
    }
    header('HTTP/1.1 200 OK');
    echo json_encode($registros);
} else if ($metodo == 'POST') {
    $inputJson = file_get_contents('php://input');
    $datos = json_decode($inputJson, true);

    file_put_contents("debug_log.txt", print_r($datos, true), FILE_APPEND);

    if (!$datos) {
        echo json_encode(["error" => "Formato JSON inválido"]);
        exit;
    }

    if (isset($_GET['q']) && $_GET['q'] == 'login') {
        if (!isset($datos["NomUsuario"]) || !isset($datos["contrasena"])) {
            echo json_encode(["error" => "Faltan campos en la solicitud"]);
            exit;
        }

        $status = $usuario->login([
            "NomUsuario" => $datos["NomUsuario"],
            "contrasena" => $datos["contrasena"]
        ]);

        if ($status) {
            echo json_encode(['status' => true, 'msg' => 'Login exitoso']);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Credenciales incorrectas']);
        }
    } else {
        if (!isset($datos["NomUsuario"]) || !isset($datos["nombre"]) || !isset($datos["apellidoP"]) || !isset($datos["apellidoM"]) || !isset($datos["email"]) || !isset($datos["contrasena"]) || !isset($datos["telefono"])) {
            echo json_encode(["error" => "Faltan campos para el registro"]);
            exit;
        }

        // Verificar si ya existe un usuario con el mismo nomUsuario, email o teléfono
        $verificarExistente = $usuario->getAll();
        foreach ($verificarExistente as $user) {
            if ($user["NomUsuario"] == $datos["NomUsuario"] || $user["email"] == $datos["email"] || $user["telefono"] == $datos["telefono"]) {
                echo json_encode(["error" => "El nomUsuario, email o teléfono ya está registrado"]);
                exit;
            }
        }

        // Registrar usuario
        $registro = [
            "NomUsuario" => $datos["NomUsuario"],
            "nombre" => $datos["nombre"],
            "apellidoP" => $datos["apellidoP"],
            "apellidoM" => $datos["apellidoM"],
            "email" => $datos["email"],
            "contrasena" => $datos["contrasena"],
            "telefono" => $datos["telefono"]
        ];
        $status = $usuario->add($registro);
        echo json_encode(['status' => $status]);
    }
}
?>   