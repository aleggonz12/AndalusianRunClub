<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST["carrera_id"])) {
    header("Location: carreras.php");
    exit();
}

$usuario_id = $_SESSION["id"];
$carrera_id = $_POST["carrera_id"];

// Comprobar que no exista ya el plan
$sql_check = "SELECT * FROM planes_entrenamiento 
              WHERE usuario_id = '$usuario_id' 
              AND carrera_id = '$carrera_id'";

$resultado = $conn->query($sql_check);

if ($resultado->num_rows == 0) {

    $sql_insert = "INSERT INTO planes_entrenamiento (usuario_id, carrera_id)
                   VALUES ('$usuario_id', '$carrera_id')";

    $conn->query($sql_insert);
}

header("Location: mis_planes.php");
exit();
?>
