<?php
require_once '../Modelo/Conexion.php'; // Archivo de conexión
require_once '../Modelo/Cliente.php'; // Clase Cliente

// Establecer la conexión a la base de datos
$conexionObj = new Conexion();
$conexion = $conexionObj->getConnection(); // Utilizamos PDO en la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $userEmail = $_POST['userEmail'];
    $userPassword = $_POST['userPassword'];

    // Crear una instancia de la clase Cliente
    $cliente = new Cliente($conexion);

    // Intentar autenticar al cliente
    $idCliente = $cliente->autenticarCliente($userEmail, $userPassword);

    if ($idCliente) {
        // Obtener los datos completos del cliente, incluyendo el rol
        $sql = "SELECT * FROM cliente WHERE idClientes = :idCliente";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stmt->execute();

        $clienteLogueado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($clienteLogueado) {
            // Redireccionar según el rol del cliente
            switch ($clienteLogueado['Roles_idRoles']) {
                case 1: // Admin
                    header("Location: ../Vista/indexAdmin.html");
                    break;
                case 2: // Gerente
                    header("Location: ../indexGerente.html");
                    break;
                case 3: // Bartender
                    header("Location: ../indexBartender.html");
                    break;
                case 4: // Cliente
                    header("Location: ..\Principal\roles/Admin/indexAdmin.html");
                    break;
                default:
                    echo "Error: Rol no reconocido.";
            }
            exit(); // Asegúrate de que el código no siga ejecutándose después de la redirección
        }
    } else {
        // Credenciales incorrectas
        header("Location: ../Vista/login.html?error=" . urlencode("Credenciales incorrectas."));
        exit(); // Asegúrate de que el código no siga ejecutándose después de la redirección
    }
} else {
    echo "Error: Solicitud inválida.";
}
?>
