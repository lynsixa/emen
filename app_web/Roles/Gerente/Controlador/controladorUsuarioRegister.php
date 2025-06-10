<?php
// controladorUsuario.php
include_once '../Modelo/UsuarioRegister.php'; // Asegúrate de incluir el archivo de la clase

$usuarioRegister = new UsuarioRegister();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Acciones'])) {
        switch ($_POST['Acciones']) {
            case 'Crear Usuario':
                // Obtiene los datos del formulario
                $nombre = $_POST['Nombre'];
                $documento = $_POST['Documento'];
                $correo = $_POST['Correo'];
                $fechaNacimiento = $_POST['Fechadenacimiento'];

                // Llama al método para agregar el usuario
                $usuarioRegister->agregarUsuario($nombre, $documento, $correo, $fechaNacimiento);
                break;

            case 'Actualizar Usuario':
                // Obtiene los datos del formulario
                $id = $_POST['idUsuario'];
                $nombre = $_POST['Nombre'];
                $documento = $_POST['Documento'];
                $correo = $_POST['Correo'];
                $fechaNacimiento = $_POST['Fechadenacimiento'];

                // Llama al método para actualizar el usuario
                $usuarioRegister->actualizarUsuario($id, $nombre, $documento, $correo, $fechaNacimiento);
                break;

            case 'Eliminar Usuario':
                // Obtiene el ID del usuario a eliminar
                $id = $_POST['idUsuario'];

                // Llama al método para eliminar el usuario
                $usuarioRegister->eliminarUsuario($id);
                break;

            default:
                // Maneja el caso en que no se proporciona una acción válida
                die("No se ha especificado una acción válida.");
        }
    } else {
        die("No se ha especificado una acción válida.");
    }
}

// Redirecciona a la vista de usuarios
header('Location: ../Vista/crudUsuarios.php');
exit();
