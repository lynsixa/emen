<?php
session_start();
require_once '../Modelo/Conexion.php';
require_once '../Modelo/Usuario.php';

// Establecer conexión a la base de datos
$conexionObj = new Conexion();
$conexion = $conexionObj->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las credenciales del usuario desde el formulario
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    // Instanciar la clase Usuario para autenticar al usuario
    $usuario = new Usuario($conexion);
    $idUsuario = $usuario->autenticarUsuario($userEmail, $userPassword);

    if ($idUsuario) {
        // Obtener información del usuario, incluyendo su nombre y apellidos
        $sql = "SELECT idUsuario, Nombres, Apellidos, Roles_idRoles FROM Usuario WHERE idUsuario = :idUsuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        $usuarioLogueado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($usuarioLogueado['Roles_idRoles'])) {
            // Guardar datos del usuario en la sesión
            $_SESSION['idUsuario'] = $usuarioLogueado['idUsuario'];
            $_SESSION['nombreUsuario'] = $usuarioLogueado['Nombres'] . ' ' . $usuarioLogueado['Apellidos']; // Guardamos el nombre completo
            $_SESSION['rol'] = $usuarioLogueado['Roles_idRoles'];

            // Guardar sesión en una cookie (30 días)
            setcookie("user_session", $idUsuario, time() + (30 * 24 * 60 * 60), "/"); 

            // Redireccionar según el rol
            switch ($_SESSION['rol']) {
                case 1:
                    header("Location: /proyecto/app_web/roles/Admin/indexAdmin.php");
                    break;
                case 2:
                    header("Location: /proyecto/app_web/Roles/Gerente/indexGerente.php");
                    break;
                case 3:
                    header("Location: /proyecto/app_web/roles/mesero/indexmesero.php");
                    break;
                case 4:
                    header("Location: /proyecto/app_web/roles/Usuariosincrud/indexscannis.php");
                    break;
                    case 5:
                        header("Location: /proyecto/app_web/roles/Bartender/indexBartender.php");
                        break;    
                default:
                    echo "Error: Rol no reconocido.";
            }
            exit();
        } else {
            echo "Error: El usuario no tiene un rol asignado.";
        }
    } else {
        header("Location: ../Vista/login.php?error=" . urlencode("Credenciales incorrectas."));
        exit();
    }
} else {
    echo "Error: Solicitud inválida.";
}
?>
