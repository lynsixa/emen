<?php
require_once 'Conexion.php';

class ControladorNIS {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConnection();
    }

    // Obtener todos los menús
    public function obtenerMenus() {
        try {
            $sql = "SELECT * FROM Menu";
            $result = $this->conexion->query($sql);  // Usamos query() para consultas simples

            $menus = [];
            while ($row = $result->fetch_assoc()) {
                $menus[] = $row;
            }
            return $menus;

        } catch (Exception $e) {
            error_log("Error al obtener menús: " . $e->getMessage());
            return [];
        }
    }

    // Crear una nueva mesa
    public function crearMesa($numeroMesa, $numeroPiso) {
        try {
            $sql = "INSERT INTO Mesa (NumeroMesa, NumeroPiso) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $numeroMesa, $numeroPiso);
            $stmt->execute();

            return $this->conexion->insert_id;  // Devuelve el id generado automáticamente
        } catch (Exception $e) {
            error_log("Error al crear mesa: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo NIS
    public function crearNIS($descripcion, $mesa_id, $menu_id) {
        try {
            $sql = "INSERT INTO CodigoNis (Descripcion, Mesa_idMesa, Menu_idMenu) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sii", $descripcion, $mesa_id, $menu_id);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            error_log("Error al crear NIS: " . $e->getMessage());
            return false;
        }
    }

    // Obtener todos los registros de NIS
    public function obtenerNIS() {
        try {
            $sql = "SELECT cn.idCodigoNis, cn.Descripcion AS CodigoNIS, m.NumeroMesa, m.NumeroPiso, me.Descripcion AS MenuDescripcion
                    FROM CodigoNis cn
                    JOIN Mesa m ON cn.Mesa_idMesa = m.idMesa
                    JOIN Menu me ON cn.Menu_idMenu = me.idMenu
                    ORDER BY cn.Descripcion ASC";
            $result = $this->conexion->query($sql);

            $nis = [];
            while ($row = $result->fetch_assoc()) {
                $nis[] = $row;
            }
            return $nis;
        } catch (Exception $e) {
            error_log("Error al obtener NIS: " . $e->getMessage());
            return [];
        }
    }
    
    // Obtener NIS por ID
    public function obtenerNISPorId($id) {
        try {
            $sql = "SELECT cn.idCodigoNis, cn.Descripcion AS CodigoNIS, m.NumeroMesa, m.NumeroPiso, cn.Menu_idMenu
                    FROM CodigoNis cn
                    JOIN Mesa m ON cn.Mesa_idMesa = m.idMesa
                    WHERE cn.idCodigoNis = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Error al obtener NIS por ID: " . $e->getMessage());
            return false;
        }
    }

    // Editar NIS y Mesa
    public function editarNISyMesa($idNIS, $descripcion, $numeroMesa, $numeroPiso, $menu_id) {
        try {
            // Iniciar transacción
            $this->conexion->begin_transaction();

            // Actualizar mesa
            $sqlMesa = "UPDATE Mesa m JOIN CodigoNis cn ON m.idMesa = cn.Mesa_idMesa 
                        SET m.NumeroMesa = ?, m.NumeroPiso = ? 
                        WHERE cn.idCodigoNis = ?";
            $stmtMesa = $this->conexion->prepare($sqlMesa);
            $stmtMesa->bind_param("iii", $numeroMesa, $numeroPiso, $idNIS);
            $stmtMesa->execute();

            // Actualizar NIS
            $sqlNIS = "UPDATE CodigoNis SET Descripcion = ?, Menu_idMenu = ? WHERE idCodigoNis = ?";
            $stmtNIS = $this->conexion->prepare($sqlNIS);
            $stmtNIS->bind_param("sii", $descripcion, $menu_id, $idNIS);
            $stmtNIS->execute();

            // Confirmar transacción
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->conexion->rollback();
            error_log("Error al editar NIS y Mesa: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar NIS
    public function eliminarNIS($idNIS) {
        try {
            // Iniciar transacción
            $this->conexion->begin_transaction();

            // Eliminar el NIS
            $sqlNIS = "DELETE FROM CodigoNis WHERE idCodigoNis = ?";
            $stmtNIS = $this->conexion->prepare($sqlNIS);
            $stmtNIS->bind_param("i", $idNIS);
            $stmtNIS->execute();

            // Confirmar transacción
            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $this->conexion->rollback();
            error_log("Error al eliminar NIS: " . $e->getMessage());
            return false;
        }
    }
}
?>
