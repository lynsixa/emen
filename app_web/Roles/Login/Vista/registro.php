<?php
// Incluir la clase de conexión
require_once '../Modelo/Conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    
    <link rel="stylesheet" href="../CSS/login-registro.css">
    <link rel="icon" href="img/log.png" type="image/png">
    <style>
        .btn-volver {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
        }
    </style>

    <script>
        // Impide que el usuario navegue hacia atrás
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
        setTimeout("noBack()", 0);
        window.onload = noBack;
        window.onpageshow = function(evt) { if (evt.persisted) noBack() };
        window.onunload = function() { void(0) };
    </script>
</head>
<body>

<a href="../../../index.php" class="btn btn-dark btn-volver">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="form-container">
                    <center><img class="imagen" src="../Imagenes/log.png" width="80" height="70" alt="Logo"></center>
                    <h1>Registrarme</h1>

                    <!-- Contenedor para mensajes de error -->
                    <div id="mensajeError" style="color: red; text-align: center;">
                        <?php
                        if (isset($_GET['mensaje'])) {
                            echo htmlspecialchars($_GET['mensaje']);
                        }
                        ?>
                    </div>

                    <!-- Formulario para registrar usuario -->
                    <form method="post" action="../Controlador/controladorUsuario.php" id="registroForm">
                        <input type="hidden" name="accion" value="registrar">

                        <div class="form-group">
                            <label for="nombre">Ingrese su Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su Nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Ingrese su Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese su Apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="documento">Número de Documento:</label>
                            <input type="text" class="form-control" id="documento" name="documento" placeholder="Número de Documento" required>
                        </div>            
                        <div class="form-group">
                            <label for="correo">Ingrese su Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo" required>
                        </div>         
                        <div class="form-group">
                            <label for="fechadenacimiento">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" id="fechadenacimiento" name="fechadenacimiento" required>
                        </div>
                        <div class="form-group">
                            <label for="userPassword">Contraseña:</label>
                            <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Ingrese su contraseña" required>
                        </div> 

                        <!-- Selección del tipo de documento -->
                        <div class="form-group">
                            <label for="tipoDocumento">Tipo de Documento:</label>
                            <select class="form-control" id="tipoDocumento" name="tipoDocumento" required>
                                <?php
                                // Conectar a la base de datos y obtener los tipos de documentos
                                $db = new Conexion();
                                $conexion = $db->getConnection();
                                $query = "SELECT * FROM `Tipo de documento`";
                                $stmt = $conexion->prepare($query);
                                $stmt->execute();
                                
                                // Mostrar los tipos de documento disponibles
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['idTipodedocumento'] . "'>" . $row['Descripcion'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Checkbox de términos y condiciones -->
                        <input name="acepto" type="checkbox" class="checkbox-terminos" required> 
                        <a href="http://localhost/EmenDSRTV/Pdf/terminosYcondiciones.pdf" target="_blank" class="terminos">Términos y Condiciones</a>

                        <button type="submit" class="submit-button">
                            Registrarme
                        </button>
                        <a href="../Vista/login.php">¿Ya tienes cuenta?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
