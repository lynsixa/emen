<?php
// Iniciar la sesión si aún no se ha iniciado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexion.php';

$mensaje = ''; // Mensaje para feedback

// Si ya existe una sesión con código NIS, redirigir directamente
if (isset($_SESSION['codigo'])) {
    header("Location: /proyecto/app_web/Roles/Usuarioconcrud/index.php");
    exit();
}

// Verificar si el formulario fue enviado por método POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['codigo'])) {
    $codigo = trim($_POST['codigo']); // Sanitizar entrada

    try {
        $conexion = new Conexion();
        $conn = $conexion->getConnection();

        // Buscar el código NIS con datos de la mesa asociada
        $stmt = $conn->prepare("
            SELECT 
                cn.idCodigoNis,
                cn.Descripcion,
                m.idMesa,
                m.NumeroMesa,
                m.NumeroPiso
            FROM CodigoNis cn
            INNER JOIN Mesa m ON cn.Mesa_idMesa = m.idMesa
            WHERE cn.Descripcion = :codigo
        ");
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $info = $stmt->fetch(PDO::FETCH_ASSOC);

            // Guardar en sesión
            $_SESSION['codigo'] = $info['Descripcion'];
            $_SESSION['idCodigoNis'] = $info['idCodigoNis'];
            $_SESSION['idMesa'] = $info['idMesa'];
            $_SESSION['numeroMesa'] = $info['NumeroMesa'];
            $_SESSION['numeroPiso'] = $info['NumeroPiso'];
            $_SESSION['codigo_inicio'] = time(); // Marca inicial
            $_SESSION['codigo_validado_hora'] = time(); // Marca de control

            // Redirigir
            header("Location: /proyecto/app_web/Roles/Usuarioconcrud/index.php");
            exit();
        } else {
            $mensaje = "⚠️ Código no encontrado. Intenta nuevamente.";
        }

    } catch (PDOException $e) {
        $mensaje = "❌ Error en la base de datos: " . $e->getMessage();
    }
}
?>
