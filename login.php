<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexion.php");
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // 1. Sentencia preparada para evitar Inyección SQL
    $stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        // 2. Verificación segura de la contraseña
        if (password_verify($password, $usuario["password"])) {
            $_SESSION["id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "La contraseña introducida no es correcta.";
        }
    } else {
        $error = "No existe ninguna cuenta asociada a este correo.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Andalusian Run Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .card-login {
            border-radius: 15px;
            border: none;
        }
        .arc-logo {
        height: 75px; /* Ajusta este valor para que el logo se vea bien con el texto */
        width: auto;
        object-fit: contain;
    }
        .arc-title {
        color: #174d19; /* Un verde oscuro intenso para el nombre de la marca */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .btn-entrar {
        background-color: #8dd392 !important; 
    }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="text-center mb-4">
                <img src="Logo_Andalusian_Run_Club.png" alt="Logo ARC" class="me-2 arc-logo">
                <h2 class="arc-title">Andalusian Run Club</h2>
                <p class="text-muted">Inicia sesión para entrenar</p>
            </div>

            <div class="card shadow card-login">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4 fw-bold">Iniciar sesión</h4>

                    <?php if ($error != ""): ?>
                        <div class="alert alert-danger py-2 small" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" placeholder="nombre@ejemplo.com" required>
                        </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="verPass" onclick="mostrarPassword()">
                            <label class="form-check-label small text-muted" for="verPass">
                                Mostrar contraseña
                            </label>
                        </div>
                    </div>

                        <button type="submit" class="btn btn-entrar w-100 fw-bold py-2 mb-3">
                            Entrar
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="small text-muted mb-0">¿No tienes cuenta? 
                            <a href="register.php" class="text-decoration-none fw-bold">Regístrate aquí</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function mostrarPassword() {
    var pass = document.getElementById("password");
    if (pass.type === "password") {
        pass.type = "text";
    } else {
        pass.type = "password";
    }
}
</script>

</body>
</html>