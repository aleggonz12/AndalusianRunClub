<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["carrera_id"])) {
    header("Location: mis_planes.php");
    exit();
}

$usuario_id = $_SESSION["id"];
$carrera_id = $_GET["carrera_id"];

// Eliminar solo si pertenece al usuario
$sql = "DELETE FROM planes_entrenamiento 
        WHERE usuario_id = '$usuario_id' 
        AND carrera_id = '$carrera_id'";

$conn->query($sql);

header("Location: mis_planes.php");
exit();
?>
