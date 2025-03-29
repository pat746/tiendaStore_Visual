<?php
require_once 'Conexion.php';

class Usuario extends Conexion {
    private $conexion;

    public function __construct() {
        $this->conexion = parent::getConexion();
    }

    // Agregar un usuario (registro)
    public function add($params = []): bool {
        try {
            $sql = "INSERT INTO usuarios (NomUsuario, nombre, apellidoP, apellidoM, email, contrasena, telefono) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $consulta = $this->conexion->prepare($sql);
            $saveStatus = $consulta->execute([
                $params['NomUsuario'],
                $params['nombre'],
                $params['apellidoP'],
                $params['apellidoM'],
                $params['email'],
                $params['contrasena'], // 🔴 Ya no se encripta la contraseña
                $params['telefono']
            ]);

            if (!$saveStatus) {
                error_log("❌ Error en la inserción: " . json_encode($consulta->errorInfo()));
            }

            return $saveStatus;
        } catch (Exception $e) {
            error_log("❌ Excepción en la inserción: " . $e->getMessage());
            return false;
        }
    }

    // Obtener todos los usuarios
    public function getAll(): array {
        try {
            $sql = "SELECT id, NomUsuario, nombre, apellidoP, apellidoM, email, telefono, fecha_registro FROM usuarios";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("❌ Error al obtener usuarios: " . $e->getMessage());
            return [];
        }
    }

    // Obtener usuario por ID
    public function getById($param = []) {
        try {
            $sql = "SELECT id, NomUsuario, nombre, apellidoP, apellidoM, email, telefono FROM usuarios WHERE id = ?";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute([$param["id"]]);
            return $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("❌ Error al obtener usuario por ID: " . $e->getMessage());
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
    }

    // Validar login con NomUsuario y contraseña en texto plano
    public function login($params = []): bool {
        try {
            $sql = "SELECT * FROM usuarios WHERE NomUsuario = ? AND contrasena = ?"; // 🔴 Comparación directa
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute([$params['NomUsuario'], $params['contrasena']]);
            $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

            return $usuario !== false;
        } catch (PDOException $e) {
            error_log("❌ Error en login: " . $e->getMessage());
            return false;
        }
    }
}
?>
