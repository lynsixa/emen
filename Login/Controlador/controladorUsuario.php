<?php
require_once "../Modelo/Conexion.php";
require_once "../Modelo/Cliente.php";

// Crear una instancia de la conexión
$database = new Conexion();
$conexion = $database->getConnection();

<<<<<<< HEAD
// Crear una instancia de la clase Usuario
$usuario = new Usuario($conexion);
=======
// Crear una instancia de la clase Cliente
$cliente = new Cliente($conexion);
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'registrar') {
            // Capturar los datos enviados por el formulario
<<<<<<< HEAD
            $nombres = $_POST['nombre'];
            $apellidos = $_POST['apellido']; 
=======
            $nombre = $_POST['nombre'];
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
            $documento = $_POST['documento'];
            $correo = $_POST['correo'];
            $fechadenacimiento = $_POST['fechadenacimiento'];
            $password = $_POST['userPassword'];
<<<<<<< HEAD
            $rolId = 4; // Rol de usuario
            $tipoDocumentoId = $_POST['tipoDocumento']; // Obtener el tipo de documento desde el formulario

            // Verificar si el usuario ya existe
            $usuarioExistente = $usuario->verificarUsuarioExistente($correo);
=======
            $rolId = 4; // Rol de cliente

            // Verificar si el usuario ya existe
            $usuarioExistente = $cliente->verificarUsuarioExistente($correo);
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
            if ($usuarioExistente) {
                header('Location: ../Vista/registro.html?mensaje=' . urlencode('El usuario ya existe.'));
                exit();
            }

<<<<<<< HEAD
            // Registrar el usuario
            $registrado = $usuario->registrarUsuario($nombres, $apellidos, $correo, $documento, $fechadenacimiento, $password, $rolId, $tipoDocumentoId);

            // Redirigir en función de si se registró correctamente o no
            if ($registrado === true) {
                header('Location: ../Vista/login.html?registro=exito');
                exit();
            } else {
                // En caso de error en el registro, redirigir con el mensaje de error
=======
            // Registrar el cliente
            $registrado = $cliente->registrarCliente($nombre, $correo, $documento, $fechadenacimiento, $password, $rolId);

            // Redirigir en función de si se registró correctamente o no
            if ($registrado === true) {
                // Aquí puedes enviar el correo, si deseas hacerlo
                header('Location: ../Vista/login.html?registro=exito');
                exit();
            } else {
>>>>>>> 42cdf60072e4d0e7a8fcbf3a0b8009b206b74467
                header('Location: ../Vista/registro.html?mensaje=' . urlencode($registrado));
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
