<?php
include("conexion.php");

$mensaje = "";
$tipo_alerta = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $nivel = $_POST["nivel"];
    $rol = "usuario";

    if ($password != $password2) {
        $mensaje = "Las contraseñas no coinciden.";
        $tipo_alerta = "danger";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Seguridad: Consulta preparada
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, nivel, rol) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $email, $password_hash, $nivel, $rol);

        if ($stmt->execute()) {
            $mensaje = "¡Usuario registrado correctamente!";
            $tipo_alerta = "success";
        } else {
            $mensaje = ($conn->errno == 1062) ? "El correo ya está registrado." : "Error al registrar.";
            $tipo_alerta = "danger";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - RunClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh; display: flex; align-items: center; padding: 20px 0; }
        .card-register { border-radius: 15px; border: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">🏃‍♂️ RunClub</h2>
                <p class="text-muted">Únete a nuestra comunidad</p>
            </div>

            <div class="card shadow card-register">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4 fw-bold text-center">Registro</h4>

                    <?php if ($mensaje != ""): ?>
                        <div class="alert alert-<?php echo $tipo_alerta; ?> py-2 small" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Tu nombre" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold">Repetir contraseña</label>
                            <input type="password" name="password2" id="password2" class="form-control" required>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="verPass" onclick="mostrarPasswords()">
                            <label class="form-check-label small text-muted" for="verPass">
                                Mostrar contraseñas
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Nivel</label>
                            <select name="nivel" class="form-select" required>
                                <option value="principiante">Principiante</option>
                                <option value="intermedio">Intermedio</option>
                                <option value="avanzado">Avanzado</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">Registrarse</button>
                    </form>

                    <div class="text-center">
                        <p class="small text-muted mb-0">¿Ya tienes cuenta? <a href="login.php" class="text-decoration-none fw-bold">Inicia sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarPasswords() {
    var pass1 = document.getElementById("password");
    var pass2 = document.getElementById("password2");
    
    // Cambia ambos campos a la vez
    if (pass1.type === "password") {
        pass1.type = "text";
        pass2.type = "text";
    } else {
        pass1.type = "password";
        pass2.type = "password";
    }
}
</script>

</body>
</html>