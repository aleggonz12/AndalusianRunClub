<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];


    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario["password"])) {

            $_SESSION["id"] = $usuario["id"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];

            header("Location: dashboard.php");
            exit();

        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - RunClub</title>
</head>
<body>

<h2>Iniciar sesión</h2>

<form method="POST" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Entrar</button>
</form>

</body>
</html>
