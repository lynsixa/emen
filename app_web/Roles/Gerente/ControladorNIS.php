<?php
require_once 'Conexion.php';

class ControladorNIS {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConnection();
    }

    // Obtener todas las mesas
    public function obtenerMesas() {
        try {
            $sql = "SELECT * FROM Mesa";
            $result = $this->conexion->query($sql);

            $mesas = [];
            while ($row = $result->fetch_assoc()) {
                $mesas[] = $row;
            }
            return $mesas;
        } catch (Exception $e) {
            error_log("Error al obtener mesas: " . $e->getMessage());
            return [];
        }
    }

    // Obtener todos los menús
    public function obtenerMenus() {
        try {
            $sql = "SELECT * FROM Menu";
            $result = $this->conexion->query($sql);

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

    // Obtener todos los registros de NIS
    public function obtenerNIS() {
        try {
            $sql = "SELECT cn.idCodigoNis, cn.Descripcion AS CodigoNIS, 
                           m.NumeroMesa, m.NumeroPiso, 
                           me.Descripcion AS MenuDescripcion, cn.Disponibilidad,
                           cn.Mesa_idMesa, cn.Menu_idMenu
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

    // Método para crear el NIS
    public function crearNIS($descripcion, $mesa_id, $menu_id) {
        try {
            if (empty($descripcion) || empty($mesa_id) || empty($menu_id)) {
                throw new Exception('Algunos parámetros están vacíos.');
            }

            $sql = "INSERT INTO CodigoNis (Descripcion, Mesa_idMesa, Menu_idMenu) 
                    VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sii", $descripcion, $mesa_id, $menu_id);

            if ($stmt->execute()) {
                return $this->conexion->insert_id;
            } else {
                throw new Exception('Error al ejecutar la consulta de inserción.');
            }
        } catch (Exception $e) {
            error_log("Error al crear NIS: " . $e->getMessage());
            return null;
        }
    }

    // Método para editar un NIS
    public function editarNIS($idNIS, $descripcion, $mesa_id, $menu_id) {
        try {
            if (empty($idNIS) || empty($descripcion) || empty($mesa_id) || empty($menu_id)) {
                throw new Exception('Algunos parámetros están vacíos.');
            }

            $sql = "UPDATE CodigoNis SET Descripcion = ?, Mesa_idMesa = ?, Menu_idMenu = ? WHERE idCodigoNis = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("siii", $descripcion, $mesa_id, $menu_id, $idNIS);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al editar NIS: " . $e->getMessage());
            return false;
        }
    }

    // Método para eliminar un NIS
    public function eliminarNIS($idNIS) {
        try {
            if (empty($idNIS)) {
                throw new Exception('ID de NIS no proporcionado.');
            }

            $sql = "DELETE FROM CodigoNis WHERE idCodigoNis = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $idNIS);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error al eliminar NIS: " . $e->getMessage());
            return false;
        }
    }
}
?>
