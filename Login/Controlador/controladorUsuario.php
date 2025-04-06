<?php
require_once "../Modelo/Conexion.php";
require_once "../Modelo/cliente.php";

// Crear una instancia de la conexión
$database = new Conexion();
$conexion = $database->getConnection();

// Crear una instancia de la clase Usuario
$usuario = new Usuario($conexion);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'registrar') {
            // Capturar los datos enviados por el formulario
            $nombres = $_POST['nombre'];
            $apellidos = $_POST['apellido']; 
            $documento = $_POST['documento'];
            $correo = $_POST['correo'];
            $fechadenacimiento = $_POST['fechadenacimiento'];
            $password = $_POST['userPassword'];
            $rolId = 4; // Rol de usuario
            $tipoDocumentoId = $_POST['tipoDocumento']; // Obtener el tipo de documento desde el formulario

            // Verificar si el usuario ya existe
            $usuarioExistente = $usuario->verificarUsuarioExistente($correo);
            if ($usuarioExistente) {
                header('Location: ../Vista/registro.php?mensaje=' . urlencode('El usuario ya existe.'));
                exit();
            }

            // Registrar el usuario
            $registrado = $usuario->registrarUsuario($nombres, $apellidos, $correo, $documento, $fechadenacimiento, $password, $rolId, $tipoDocumentoId);

            // Redirigir en función de si se registró correctamente o no
            if ($registrado === true) {
                header('Location: ../Vista/login.php?registro=exito');
                exit();
            } else {
                // En caso de error en el registro, redirigir con el mensaje de error
                header('Location: ../Vista/registro.php?mensaje=' . urlencode($registrado));
                exit();
            }
        } else {
            echo "Error: Acción no reconocida.";
        }
    } else {
        echo "Error: No se ha especificado una acción válida.";
    }
} else {
    echo "Error: No se recibió una solicitud POST.";
}
?>
