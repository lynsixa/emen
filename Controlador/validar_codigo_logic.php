<?php
// Iniciar la sesión si aún no se ha iniciado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexion.php';

$mensaje = ''; // Variable global para mostrar mensajes de error

// Si ya existe una sesión con el código, redirigir directamente
if (isset($_SESSION['codigo'])) {
    header("Location: /proyecto/Roles/Usuarioconcrud/index.php");
    exit();
}

// Verificar si el formulario fue enviado por método POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['codigo'])) {
    $codigo = trim($_POST['codigo']); // Limpiar entrada

    try {
        $conexion = new Conexion();
        $conn = $conexion->getConnection();

        // Consulta SQL para buscar el código NIS y obtener datos de la mesa
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
            // Código válido, guardar datos en sesión
            $info = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['codigo'] = $info['Descripcion'];
            $_SESSION['idCodigoNis'] = $info['idCodigoNis'];
            $_SESSION['idMesa'] = $info['idMesa'];
            $_SESSION['numeroMesa'] = $info['NumeroMesa'];
            $_SESSION['numeroPiso'] = $info['NumeroPiso'];
            $_SESSION['codigo_inicio'] = time(); // Marca de tiempo

            // Redirigir al index del sistema
            header("Location: /proyecto/Roles/Usuarioconcrud/index.php");
            exit(); // Salida inmediata para evitar ejecución adicional
        } else {
            $mensaje = "⚠️ Código no encontrado. Intenta nuevamente.";
        }

    } catch (PDOException $e) {
        $mensaje = "❌ Error en la base de datos: " . $e->getMessage();
    }
}
