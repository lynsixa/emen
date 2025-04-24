<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> d7ad886f3380c3d4559d10dc883980110ce673e6
<?php
require 'conexion.php';  // Asegúrate de que este archivo establece $mysqli
require 'funcs.php';     // Asegúrate de que verificaTokenPass está bien definido

$user_id = $_GET['idUsuario'] ?? null;
$token = $_GET['token'] ?? null;

if ($user_id && $token) {
    if (!verificaTokenPass($user_id, $token)) {
        echo "⚠️ Token inválido o expirado.<br>";
        echo "User ID recibido: " . htmlspecialchars($user_id) . "<br>";
        echo "Token recibido: " . htmlspecialchars($token) . "<br>";
        exit;
    }
} else {
    echo "⚠️ Falta el ID de usuario o el token.<br>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $token = $_POST['token'] ?? null;
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['con_password'] ?? '';

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Verificar si el usuario y el token existen antes de actualizar
        $stmt = $mysqli->prepare("SELECT idUsuario FROM Usuario WHERE idUsuario = ? AND token_password = ? LIMIT 1");
        $stmt->bind_param("is", $user_id, $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Si existe, actualizamos la contraseña y limpiamos el token
            $update = $mysqli->prepare("UPDATE Usuario SET Contraseña = ?, token_password = NULL, password_request = 0 WHERE idUsuario = ?");
            $update->bind_param("si", $hashed_password, $user_id);

            if ($update->execute()) {
                // Alerta de éxito y redirección inmediata
                echo "<script>
                        alert('✅ Contraseña actualizada con éxito.');
                        window.location.href = 'login.php'; // Redirige a login.php inmediatamente
                      </script>";
                exit;
            } else {
                echo "❌ Error al actualizar la contraseña: " . $mysqli->error . "<br>";
            }
        } else {
            echo "❌ Usuario o token no encontrado en la base de datos.<br>";
        }
    } else {
        echo "⚠️ Las contraseñas no coinciden.<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cambiar Contraseña</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    body {
      background: linear-gradient(135deg, #fff176, #000000);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 2.5rem;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(255, 235, 59, 0.5);
      max-width: 450px;
      width: 100%;
      color: #fff;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 1.8rem;
      color: #ffeb3b;
    }

    .form-label {
      color: #ffeb3b;
    }

    .form-control {
      border-radius: 12px;
    }

    .btn-warning {
      width: 100%;
      border-radius: 12px;
    }

    .input-group-text {
      background-color: #ffc107;
      color: #000;
      border: none;
      border-radius: 12px 0 0 12px;
    }

    .input-group .form-control {
      border-radius: 0 12px 12px 0;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2><i class="bi bi-shield-lock-fill"></i> Cambiar Contraseña</h2>
    <form method="POST">
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

      <div class="mb-3">
        <label for="password" class="form-label">Nueva Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password" class="form-control" name="password" required placeholder="Nueva contraseña">
        </div>
      </div>

      <div class="mb-3">
        <label for="con_password" class="form-label">Confirmar Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control" name="con_password" required placeholder="Confirmar contraseña">
        </div>
      </div>

      <button type="submit" class="btn btn-warning mt-3"><i class="bi bi-check-circle-fill"></i> Actualizar Contraseña</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<<<<<<< HEAD
=======
=======
<?php
require 'conexion.php';  // Asegúrate de que este archivo establece $mysqli
require 'funcs.php';     // Asegúrate de que verificaTokenPass está bien definido

$user_id = $_GET['idUsuario'] ?? null;
$token = $_GET['token'] ?? null;

if ($user_id && $token) {
    if (!verificaTokenPass($user_id, $token)) {
        echo "⚠️ Token inválido o expirado.<br>";
        echo "User ID recibido: " . htmlspecialchars($user_id) . "<br>";
        echo "Token recibido: " . htmlspecialchars($token) . "<br>";
        exit;
    }
} else {
    echo "⚠️ Falta el ID de usuario o el token.<br>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $token = $_POST['token'] ?? null;
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['con_password'] ?? '';

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Verificar si el usuario y el token existen antes de actualizar
        $stmt = $mysqli->prepare("SELECT idUsuario FROM Usuario WHERE idUsuario = ? AND token_password = ? LIMIT 1");
        $stmt->bind_param("is", $user_id, $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Si existe, actualizamos la contraseña y limpiamos el token
            $update = $mysqli->prepare("UPDATE Usuario SET Contraseña = ?, token_password = NULL, password_request = 0 WHERE idUsuario = ?");
            $update->bind_param("si", $hashed_password, $user_id);

            if ($update->execute()) {
                // Alerta de éxito y redirección inmediata
                echo "<script>
                        alert('✅ Contraseña actualizada con éxito.');
                        window.location.href = 'login.php'; // Redirige a login.php inmediatamente
                      </script>";
                exit;
            } else {
                echo "❌ Error al actualizar la contraseña: " . $mysqli->error . "<br>";
            }
        } else {
            echo "❌ Usuario o token no encontrado en la base de datos.<br>";
        }
    } else {
        echo "⚠️ Las contraseñas no coinciden.<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cambiar Contraseña</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    body {
      background: linear-gradient(135deg, #fff176, #000000);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      background-color: rgba(0, 0, 0, 0.85);
      padding: 2.5rem;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(255, 235, 59, 0.5);
      max-width: 450px;
      width: 100%;
      color: #fff;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 1.8rem;
      color: #ffeb3b;
    }

    .form-label {
      color: #ffeb3b;
    }

    .form-control {
      border-radius: 12px;
    }

    .btn-warning {
      width: 100%;
      border-radius: 12px;
    }

    .input-group-text {
      background-color: #ffc107;
      color: #000;
      border: none;
      border-radius: 12px 0 0 12px;
    }

    .input-group .form-control {
      border-radius: 0 12px 12px 0;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2><i class="bi bi-shield-lock-fill"></i> Cambiar Contraseña</h2>
    <form method="POST">
      <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

      <div class="mb-3">
        <label for="password" class="form-label">Nueva Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password" class="form-control" name="password" required placeholder="Nueva contraseña">
        </div>
      </div>

      <div class="mb-3">
        <label for="con_password" class="form-label">Confirmar Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control" name="con_password" required placeholder="Confirmar contraseña">
        </div>
      </div>

      <button type="submit" class="btn btn-warning mt-3"><i class="bi bi-check-circle-fill"></i> Actualizar Contraseña</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> 136355b760de46e652a24337cf6709bd9bf81e70
>>>>>>> d7ad886f3380c3d4559d10dc883980110ce673e6
