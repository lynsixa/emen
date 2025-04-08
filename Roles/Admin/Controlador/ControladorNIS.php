<?php
require_once '../Modelo/Conexion.php';

class ControladorNIS {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConnection();
    }

    // Obtener todos los menús
    public function obtenerMenus() {
        $sql = "SELECT * FROM Menu";  // Usamos 'Menu' como la tabla que contiene los menús.
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva mesa
    public function crearMesa($numeroMesa, $numeroPiso) {
        // Ahora no es necesario especificar CantidadPuestos
        $sql = "INSERT INTO Mesa (NumeroMesa, NumeroPiso) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$numeroMesa, $numeroPiso]);
        
        // Devuelve el id generado automáticamente para la nueva mesa
        return $this->conexion->lastInsertId();
    }

    // Crear un nuevo NIS
    public function crearNIS($descripcion, $mesa_id, $menu_id) {
        // Insertar en la tabla CodigoNis sin especificar idCodigoNis (AUTO_INCREMENT)
        $sql = "INSERT INTO CodigoNis (Descripcion, Mesa_idMesa, Menu_idMenu, Producto_idProducto) VALUES (?, ?, ?, NULL)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$descripcion, $mesa_id, $menu_id]);
    }

    // Obtener todos los registros de NIS
    public function obtenerNIS() {
        // Consultamos los registros de NIS sin la columna CantidadPuestos
        $sql = "SELECT cn.Descripcion AS CodigoNIS, m.NumeroMesa, m.NumeroPiso, me.Descripcion AS MenuDescripcion
                FROM CodigoNis cn
                JOIN Mesa m ON cn.Mesa_idMesa = m.idMesa
                JOIN Menu me ON cn.Menu_idMenu = me.idMenu
                ORDER BY cn.Descripcion ASC";  // Ordenar por la columna Descripcion
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Obtener NIS por ID
    public function obtenerNISPorId($id) {
        // Eliminada la columna CantidadPuestos
        $sql = "SELECT cn.idCodigoNis, cn.Descripcion AS CodigoNIS, m.NumeroMesa, m.NumeroPiso, cn.Menu_idMenu
                FROM CodigoNis cn
                JOIN Mesa m ON cn.Mesa_idMesa = m.idMesa
                WHERE cn.idCodigoNis = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Editar NIS y Mesa
    public function editarNISyMesa($idNIS, $descripcion, $numeroMesa, $numeroPiso, $menu_id) {
        // Actualizar mesa, eliminada la columna CantidadPuestos
        $sqlMesa = "UPDATE Mesa m JOIN CodigoNis cn ON m.idMesa = cn.Mesa_idMesa 
                    SET m.NumeroMesa = ?, m.NumeroPiso = ? 
                    WHERE cn.idCodigoNis = ?";
        $stmtMesa = $this->conexion->prepare($sqlMesa);
        $stmtMesa->execute([$numeroMesa, $numeroPiso, $idNIS]);

        // Actualizar NIS
        $sqlNIS = "UPDATE CodigoNis SET Descripcion = ?, Menu_idMenu = ? WHERE idCodigoNis = ?";
        $stmtNIS = $this->conexion->prepare($sqlNIS);
        return $stmtNIS->execute([$descripcion, $menu_id, $idNIS]);
    }

    // Eliminar NIS
    public function eliminarNIS($idNIS) {
        // Iniciar transacción
        $this->conexion->beginTransaction();

        try {
            // Eliminar el NIS
            $sqlNIS = "DELETE FROM CodigoNis WHERE idCodigoNis = ?";
            $stmtNIS = $this->conexion->prepare($sqlNIS);
            $stmtNIS->execute([$idNIS]);

            // Confirmar transacción
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            // Revertir transacción si hay un error
            $this->conexion->rollBack();
            error_log($e->getMessage()); // Log de errores
            return false;
        }
    }
}
?>
