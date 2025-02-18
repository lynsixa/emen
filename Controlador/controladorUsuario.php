<?php
require_once "../Modelo/Conexion.php";
require_once "../Modelo/Cliente.php";

// Crear una instancia de la conexión
$database = new Conexion();
$conexion = $database->getConnection();

// Crear una instancia de la clase Cliente
$cliente = new Cliente($conexion);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'registrar') {
            // Capturar los datos enviados por el formulario
            $nombre = $_POST['nombre'];
            $documento = $_POST['documento'];
            $correo = $_POST['correo'];
            $fechadenacimiento = $_POST['fechadenacimiento'];
            $password = $_POST['userPassword'];
            $rolId = 4; // Rol de cliente

            // Verificar si el usuario ya existe
            $usuarioExistente = $cliente->verificarUsuarioExistente($correo);
            if ($usuarioExistente) {
                header('Location: ..\Principal\Login\registro.html ' . urlencode('El usuario ya existe.'));
                exit();
            }

            // Registrar el cliente
            $registrado = $cliente->registrarCliente($nombre, $correo, $documento, $fechadenacimiento, $password, $rolId);

            // Redirigir en función de si se registró correctamente o no
            if ($registrado === true) {
                // Aquí puedes enviar el correo, si deseas hacerlo
                header('Location:..\Login/login.html?registro=exito');
                exit();
            } else {
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
