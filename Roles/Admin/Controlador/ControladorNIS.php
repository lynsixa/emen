<?php
// Incluimos la conexión utilizando una ruta absoluta
require_once $_SERVER['DOCUMENT_ROOT'] . '/Proyecto/Modelo/Conexion.php'; 

class ControladorNIS {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConnection();
    }

    // Obtener todos los menús
    public function obtenerMenus() {
        $sql = "SELECT * FROM Menu";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todos los registros de NIS
    public function obtenerNIS() {
        $sql = "SELECT cn.idCodigoNis, cn.Descripcion AS CodigoNIS, m.NumeroMesa, m.NumeroPiso, me.Descripcion AS MenuDescripcion
                FROM CodigoNis cn
                JOIN Mesa m ON cn.Mesa_idMesa = m.idMesa
                JOIN Menu me ON cn.Menu_idMenu = me.idMenu
                ORDER BY cn.Descripcion ASC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener NIS por ID
    public function obtenerNISPorId($id) {
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
        $sqlMesa = "UPDATE Mesa m JOIN CodigoNis cn ON m.idMesa = cn.Mesa_idMesa 
                    SET m.NumeroMesa = ?, m.NumeroPiso = ? 
                    WHERE cn.idCodigoNis = ?";
        $stmtMesa = $this->conexion->prepare($sqlMesa);
        $stmtMesa->execute([$numeroMesa, $numeroPiso, $idNIS]);

        $sqlNIS = "UPDATE CodigoNis SET Descripcion = ?, Menu_idMenu = ? WHERE idCodigoNis = ?";
        $stmtNIS = $this->conexion->prepare($sqlNIS);
        return $stmtNIS->execute([$descripcion, $menu_id, $idNIS]);
    }

    // Eliminar NIS
    public function eliminarNIS($idNIS) {
        $this->conexion->beginTransaction();

        try {
            $sqlNIS = "DELETE FROM CodigoNis WHERE idCodigoNis = ?";
            $stmtNIS = $this->conexion->prepare($sqlNIS);
            $stmtNIS->execute([$idNIS]);
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}
