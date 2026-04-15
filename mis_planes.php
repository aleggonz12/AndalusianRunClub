<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];

$sql = "SELECT carreras.* 
        FROM planes_entrenamiento
        INNER JOIN carreras 
        ON planes_entrenamiento.carrera_id = carreras.id
        WHERE planes_entrenamiento.usuario_id = '$usuario_id'
        AND carreras.fecha >= CURDATE()
        ORDER BY carreras.fecha ASC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis planes de entrenamiento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("navbar.php"); ?>

<div class="container mt-4">

<h2 class="fw-bold mb-4">Mis planes de entrenamiento</h2>

<?php
if ($resultado->num_rows > 0) {

        echo "<div class='row'>";

    while ($carrera = $resultado->fetch_assoc()) {

        echo "<div class='col-md-6'>";

        echo "<div class='card mb-4 shadow-sm'>";
        echo "<div class='card-body'>";

        echo "<h5 class='card-title'>" . $carrera["nombre"] . "</h5>";

        echo "<p class='card-text'>";

        echo "<p>Fecha: " . date("d/m/Y", strtotime($carrera["fecha"])) . "</p>";
        echo "<p>Distancia: " . $carrera["distancia"] . " km</p>";

        echo "<a href='plan.php?carrera_id=" . $carrera["id"] . "'
        class='btn btn-primary btn-sm me-2'>
        Ver plan
        </a>";

        echo "<a href='eliminar_plan.php?carrera_id=" . $carrera["id"] . "'
        class='btn btn-outline-danger btn-sm' 
        onclick=\"return confirm('¿Estás seguro de que quieres cancelar este plan?');\">
        Cancelar plan
        </a>";

        echo "<hr>";
        echo "</div>"; // card-body
        echo "</div>"; // card
        echo "</div>"; // col
    }

        echo "</div>"; // row

} else {
    echo "Todavía no has guardado ningún plan.";
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
