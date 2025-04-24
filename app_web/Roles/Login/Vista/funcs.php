<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Asegúrate de que el autoload de Composer esté incluido
require 'vendor/autoload.php';

require_once 'Conexion.php';  // Incluye el archivo de conexión

function isNull($nombre, $user, $pass, $pass_con, $email){
    if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1) {
        return true;
    } else {
        return false;
    }       
}

function isEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function validaPassword($var1, $var2) {
    if (strcmp($var1, $var2) !== 0) {
        return false;
    } else {
        return true;
    }
}

function minMax($min, $max, $valor) {
    if(strlen(trim($valor)) < $min) {
        return true;
    } else if(strlen(trim($valor)) > $max) {
        return true;
    } else {
        return false;
    }
}

function usuarioExiste($usuario) {
    global $mysqli;
    
    // Asegúrate de que el nombre de la tabla y los campos coincidan con la estructura de tu BD
    $stmt = $mysqli->prepare("SELECT idUsuario FROM Usuario WHERE Documento = ? LIMIT 1");
    $stmt->bind_param("s", $usuario);  // 's' para cadena
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();
    
    if ($num > 0) {
        return true;
    } else {
        return false;
    }
}
function emailExiste($email)
{
    global $mysqli;  // Cambiar $conn por $mysqli
    
    // Preparar la consulta
    $stmt = $mysqli->prepare("SELECT idUsuario FROM usuario WHERE correo = ? LIMIT 1");
    
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    $num = $stmt->num_rows;
    $stmt->close();
    
    if ($num > 0) {
        return true;
    } else {
        return false;
    }
}

function generateToken() {
    $gen = md5(uniqid(mt_rand(), false));    
    return $gen;
}

function hashPassword($password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    return $hash;
}

function resultBlock($errors) {
    if(count($errors) > 0) {
        echo "<div id='error' class='alert alert-danger' role='alert'>
        <a href='#' onclick=\"showHide('error');\">[X]</a>
        <ul>";
        foreach($errors as $error) {
            echo "<li>".$error."</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}

function registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario) {
    global $mysqli;
    
    // Reemplaza el nombre de la tabla y los campos de acuerdo con la estructura de tu tabla 'Usuario'
    $stmt = $mysqli->prepare("INSERT INTO Usuario (Documento, Contraseña, Nombres, Correo, token, Roles_idRoles) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param('sssssi', $usuario, $pass_hash, $nombre, $email, $token, $tipo_usuario);
    
    if ($stmt->execute()) {
        return $mysqli->insert_id;
    } else {
        return 0;    
    }       
}
function enviarEmail($email, $nombre, $asunto, $cuerpo) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'emends1030@gmail.com';
        $mail->Password   = 'frfz euzy bpwn ffwx';  // ¡Nunca expongas esta contraseña en producción!
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitente y destinatario
        $mail->setFrom('emends1030@gmail.com', 'disructiveclub');
        $mail->addAddress($email, $nombre);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;

        // Intentar enviar el correo
        if ($mail->send()) {
            return true;  // Éxito, devuelve true
        } else {
            error_log("Error al enviar el correo: " . $mail->ErrorInfo);
            return false; // Fallo, devuelve false
        }
    } catch (Exception $e) {
        error_log("Error al enviar el correo: {$mail->ErrorInfo}");
        return false; // Fallo, devuelve false
    }
}


function validaIdToken($id, $token) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("SELECT activacion FROM Usuario WHERE idUsuario = ? AND token = ? LIMIT 1");
    $stmt->bind_param("is", $id, $token);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    
    if($rows > 0) {
        $stmt->bind_result($activacion);
        $stmt->fetch();
        
        if($activacion == 1) {
            $msg = "La cuenta ya se activo anteriormente.";
        } else {
            if(activarUsuario($id)) {
                $msg = 'Cuenta activada.';
            } else {
                $msg = 'Error al Activar Cuenta';
            }
        }
    } else {
        $msg = 'No existe el registro para activar.';
    }
    return $msg;
}

function activarUsuario($id) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("UPDATE Usuario SET activacion=1 WHERE idUsuario = ?");
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

function isNullLogin($usuario, $password) {
    if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1) {
        return true;
    } else {
        return false;
    }       
}

function login($usuario, $password) {
    global $mysqli;
    
    // Asegúrate de que el nombre de la tabla y los campos coincidan con la estructura de tu BD
    $stmt = $mysqli->prepare("SELECT idUsuario, Roles_idRoles, Contraseña FROM Usuario WHERE Documento = ? OR Correo = ? LIMIT 1");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    
    if($rows > 0) {
        if(isActivo($usuario)) {
            $stmt->bind_result($id, $id_tipo, $passwd);
            $stmt->fetch();
            
            $validaPassw = password_verify($password, $passwd);
            
            if($validaPassw) {
                lastSession($id);
                $_SESSION['id_usuario'] = $id;
                $_SESSION['tipo_usuario'] = $id_tipo;
                
                header("location: welcome.php");
            } else {
                $errors = "La contraseña es incorrecta";
            }
        } else {
            $errors = 'El usuario no está activo';
        }
    } else {
        $errors = "El nombre de usuario o correo electrónico no existe";
    }
    return $errors;
}

function lastSession($id) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("UPDATE Usuario SET last_session=NOW(), token_password='', password_request=0 WHERE idUsuario = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

function isActivo($usuario) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("SELECT activacion FROM Usuario WHERE Documento = ? OR Correo = ? LIMIT 1");
    $stmt->bind_param('ss', $usuario, $usuario);
    $stmt->execute();
    $stmt->bind_result($activacion);
    $stmt->fetch();
    
    if ($activacion == 1) {
        return true;
    } else {
        return false;    
    }
}
function generaTokenPass($user_id) {
    global $mysqli;

    // Generación de un token aleatorio
    $token = md5(uniqid(mt_rand(), false));

    // Preparar la consulta para actualizar el token y marcar la solicitud de cambio de contraseña
    $stmt = $mysqli->prepare("UPDATE Usuario SET token_password = ?, password_request = 1 WHERE idUsuario = ?");
    if (!$stmt) {
        // Si la consulta falla, mostramos un error en el log
        die("❌ Error SQL: " . $mysqli->error);
    }

    // Vincular parámetros
    $stmt->bind_param('si', $token, $user_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si la actualización es exitosa, devolver el token generado
        return $token;
    } else {
        // Si algo falla en la actualización, devolver false
        return false;
    }
}


function getValor($campo, $campoWhere, $valor) {
    global $mysqli;
    
    // Cambié 'nombre' por 'nombres' en la consulta
    $stmt = $mysqli->prepare("SELECT $campo FROM Usuario WHERE $campoWhere = ? LIMIT 1");
    
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $mysqli->error);
    }

    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    
    if ($num > 0) {
        $stmt->bind_result($_campo);
        $stmt->fetch();
        return $_campo;
    } else {
        return null;    
    }
}


function getPasswordRequest($id) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("SELECT password_request FROM Usuario WHERE idUsuario = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($_id);
    $stmt->fetch();
    
    if ($_id == 1) {
        return true;
    } else {
        return null;    
    }

}
function verificaTokenPass($user_id, $token) {
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT idUsuario, token_password, password_request FROM Usuario WHERE idUsuario = ? LIMIT 1");

    if (!$stmt) {
        die("Error en la consulta SQL: " . $mysqli->error);
    }

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;

    if ($num > 0) {
        $stmt->bind_result($db_user_id, $db_token_password, $db_password_request);
        $stmt->fetch();

        // Validar el token sin imprimir en pantalla
        if ($db_password_request == 1 && trim($db_token_password) === trim($token)) {
            return true;
        }
    }

    return false; // Token inválido o no encontrado
}


function cambiaPassword($password, $user_id, $token) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("UPDATE Usuario SET Contraseña = ?, token_password='', password_request=0 WHERE idUsuario = ? AND token_password = ?");
    $stmt->bind_param('sis', $password, $user_id, $token);
    
    if($stmt->execute()) {
        return true;
    } else {
        return false;        
    }
}
?>
