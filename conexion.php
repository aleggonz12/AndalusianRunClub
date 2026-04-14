<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$bd = "runclub";

$conn = new mysqli($servidor, $usuario, $password, $bd, 3307);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
