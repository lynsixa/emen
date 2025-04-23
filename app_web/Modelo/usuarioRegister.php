<?php
// UsuarioRegister.php
include_once 'conexion.php'; // Asegúrate de incluir el archivo de conexión

class UsuarioRegister {
    private $conexion;

    public function __construct() {
        $this->conexion = Conectarse(); // Establece la conexión a la base de datos
    }

    public function consultarUsuarios() {
        $query = "SELECT * FROM usuario"; // Asegúrate de que 'usuario' sea el nombre correcto de tu tabla
        $resultado = mysqli_query($this->conexion, $query);
        return $resultado;
    }

    public function agregarUsuario($nombre, $documento, $correo, $fechaNacimiento) {
        $query = "INSERT INTO usuario (Nombre, Documento, Correo, Fechadenacimiento) VALUES ('$nombre', '$documento', '$correo', '$fechaNacimiento')";
        return mysqli_query($this->conexion, $query);
    }

    public function actualizarUsuario($id, $nombre, $documento, $correo, $fechaNacimiento) {
        $query = "UPDATE usuario SET Nombre='$nombre', Documento='$documento', Correo='$correo', Fechadenacimiento='$fechaNacimiento' WHERE idUsuario=$id";
        return mysqli_query($this->conexion, $query);
    }

    public function eliminarUsuario($id) {
        $query = "DELETE FROM usuario WHERE idUsuario=$id";
        return mysqli_query($this->conexion, $query);
    }
}
