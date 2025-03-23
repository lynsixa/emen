<?php
require_once '../Modelo/Conexion.php'; // Archivo de conexión
require_once '../Modelo/Cliente.php'; // Cambiar a Usuario en lugar de Cliente

// Establecer la conexión a la base de datos
$conexionObj = new Conexion();
$conexion = $conexionObj->getConnection(); // Utilizamos PDO en la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    // Crear una instancia de la clase Usuario
    $usuario = new Usuario($conexion);

    // Intentar autenticar al usuario
    $idUsuario = $usuario->autenticarUsuario($userEmail, $userPassword);

    if ($idUsuario) {
        // Modificación: Especificamos solo las columnas necesarias
        $sql = "SELECT idUsuario, Roles_idRoles FROM usuario WHERE idUsuario = :idUsuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        $usuarioLogueado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si la clave 'Roles_idRoles' existe
        if (isset($usuarioLogueado['Roles_idRoles'])) {
            // Redireccionar según el rol del usuario
            switch ($usuarioLogueado['Roles_idRoles']) {
                case 1: // Admin
                    header("Location: /Principal/Roles/Admin/indexAdmin.html");
                    break;
                case 2: // Gerente
                    header("Location: ../indexGerente.html");
                    break;
                case 3: // Bartender
                    header("Location: ../indexBartender.html");
                    break;
                case 4: // Cliente
                    header("Location: /proyecto/Roles/Usuariosincrud/indexscannis.php");
                    break;
                default:
                    echo "Error: Rol no reconocido.";
            }
            exit();
        } else {
            echo "Error: El usuario no tiene un rol asignado.";
        }
    } else {
        // Credenciales incorrectas
        header("Location: ../Vista/login.html?error=" . urlencode("Credenciales incorrectas."));
        exit();
    }
} else {
    echo "Error: Solicitud inválida.";
}
?>
