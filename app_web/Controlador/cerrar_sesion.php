<?php
session_start();

// Eliminar sesión
session_unset();
session_destroy();

// Eliminar cookie
setcookie("user_session", "", time() - 3600, "/");

// Redirigir a la página de inicio
header("Location: ../index.php");
exit();
?>
