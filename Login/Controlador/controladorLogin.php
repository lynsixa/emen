<?php
session_start();
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';

// Establecer conexión a la base de datos
$conexionObj = new Conexion();
$conexion = $conexionObj->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    $usuario = new Usuario($conexion);
    $idUsuario = $usuario->autenticarUsuario($userEmail, $userPassword);

    if ($idUsuario) {
        // Obtener información del usuario
        $sql = "SELECT idUsuario, Roles_idRoles FROM usuario WHERE idUsuario = :idUsuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        $usuarioLogueado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($usuarioLogueado['Roles_idRoles'])) {
            // Guardar datos en la sesión
            $_SESSION['idUsuario'] = $usuarioLogueado['idUsuario'];
            $_SESSION['rol'] = $usuarioLogueado['Roles_idRoles'];

            // Guardar sesión en una cookie (30 días)
            setcookie("user_session", $idUsuario, time() + (30 * 24 * 60 * 60), "/"); 

            // Redireccionar según el rol
            switch ($_SESSION['rol']) {
                case 1:
                    header("Location: /Principal/Roles/Admin/indexAdmin.html");
                    break;
                case 2:
                    header("Location: ../indexGerente.html");
                    break;
                case 3:
                    header("Location: ../indexBartender.html");
                    break;
                case 4:
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
        header("Location: ../Vista/login.html?error=" . urlencode("Credenciales incorrectas."));
        exit();
    }
} else {
    echo "Error: Solicitud inválida.";
}
?>
