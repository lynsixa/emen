<?php
require_once 'conexion.php';

class ControladorNIS {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConnection();
    }

    public function obtenerMenus() {
        $sql = "SELECT * FROM menu";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearMesa($numeroMesa, $cantidadPuestos, $numeroPiso) {
        // Ahora no es necesario especificar idMesa ya que es AUTO_INCREMENT
        $sql = "INSERT INTO mesa (NumeroMesa, CantidadPuestos, Numeropiso) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$numeroMesa, $cantidadPuestos, $numeroPiso]);
        
        // Devuelve el id generado automáticamente para la nueva mesa
        return $this->conexion->lastInsertId();
    }

    // Método actualizado para permitir pasar un valor opcional para Producto_idProducto
    public function crearNIS($descripcion, $mesa_id, $menu_id, $producto_id = null) {
        // Insertar en la tabla codigonis sin especificar idCodigoNIS (AUTO_INCREMENT)
        $sql = "INSERT INTO codigonis (Descripcion, Mesa_idMesa, Menu_idMenu, Producto_idProducto) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        // Ejecutar la consulta con el valor de producto_id si se proporciona, o NULL si no
        return $stmt->execute([$descripcion, $mesa_id, $menu_id, $producto_id]);
    }

    public function obtenerNIS() {
        $sql = "SELECT cn.idCodigoNIS, cn.Descripcion AS CodigoNIS, m.NumeroMesa, m.CantidadPuestos, m.Numeropiso, me.Descripcion AS MenuDescripcion
                FROM codigonis cn
                JOIN mesa m ON cn.Mesa_idMesa = m.idMesa
                JOIN menu me ON cn.Menu_idMenu = me.idMenu
                ORDER BY cn.idCodigoNIS ASC"; 
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerNISPorId($id) {
        $sql = "SELECT cn.idCodigoNIS, cn.Descripcion AS CodigoNIS, m.NumeroMesa, m.CantidadPuestos, m.Numeropiso, cn.Menu_idMenu
                FROM codigonis cn
                JOIN mesa m ON cn.Mesa_idMesa = m.idMesa
                WHERE cn.idCodigoNIS = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarNISyMesa($idNIS, $descripcion, $numeroMesa, $cantidadPuestos, $numeroPiso, $menu_id) {
        // Actualizar mesa
        $sqlMesa = "UPDATE mesa m JOIN codigonis cn ON m.idMesa = cn.Mesa_idMesa 
                    SET m.NumeroMesa = ?, m.CantidadPuestos = ?, m.Numeropiso = ? 
                    WHERE cn.idCodigoNIS = ?";
        $stmtMesa = $this->conexion->prepare($sqlMesa);
        $stmtMesa->execute([$numeroMesa, $cantidadPuestos, $numeroPiso, $idNIS]);

        // Actualizar NIS
        $sqlNIS = "UPDATE codigonis SET Descripcion = ?, Menu_idMenu = ? WHERE idCodigoNIS = ?";
        $stmtNIS = $this->conexion->prepare($sqlNIS);
        return $stmtNIS->execute([$descripcion, $menu_id, $idNIS]);
    }

    public function eliminarNIS($idNIS) {
        // Iniciar transacción
        $this->conexion->beginTransaction();

        try {
            // Eliminar el NIS
            $sqlNIS = "DELETE FROM codigonis WHERE idCodigoNIS = ?";
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
