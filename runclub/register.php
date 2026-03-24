<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $nivel = $_POST["nivel"];
    $rol = "usuario";

    // Comprobar que las contraseñas coinciden
    if ($password != $password2) {

        echo "Las contraseñas no coinciden";

    } else {

        // Encriptar contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, email, password, nivel, rol) 
                VALUES ('$nombre', '$email', '$password_hash', '$nivel', '$rol')";

        if ($conn->query($sql) === TRUE) {
            echo "Usuario registrado correctamente";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro - RunClub</title>
</head>
<body>

<h2>Registro de Usuario</h2>

<form method="POST" action="">

    <label>Nombre:</label><br>
    <input type="text" name="nombre" required>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required>
    <br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" id="password" required>
    <br><br>

    <label>Repetir contraseña:</label><br>
    <input type="password" name="password2" id="password2" required>
    <br><br>

    <input type="checkbox" onclick="mostrarPasswords()"> Mostrar contraseñas
    <br><br>

    <label>Nivel:</label><br>
    <select name="nivel" required>
        <option value="principiante">Principiante</option>
        <option value="intermedio">Intermedio</option>
        <option value="avanzado">Avanzado</option>
    </select>
    <br><br>

    <button type="submit">Registrarse</button>

</form>

<script>
function mostrarPasswords() {

    var pass1 = document.getElementById("password");
    var pass2 = document.getElementById("password2");

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
