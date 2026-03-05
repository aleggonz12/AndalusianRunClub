<?php
session_start();
include("conexion.php");

if (isset($_POST["cancelar"])) {

    $usuario_id = $_SESSION["id"];
    $evento_id = $_POST["evento_id"];

    // Eliminar inscripción
    $sql = "DELETE FROM inscripciones 
            WHERE usuario_id = '$usuario_id' 
            AND evento_id = '$evento_id'";

    if ($conn->query($sql) === TRUE) {

        // Sumar una plaza al evento
        $actualizar = "UPDATE eventos 
                    SET plazas = plazas + 1 
                    WHERE id = '$evento_id'";

        $conn->query($actualizar);
    }

    // Redirigir para evitar reenvío del formulario
    header("Location: mis_eventos.php");
    exit();

}

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];

// Consulta con JOIN para obtener datos del evento
$sql = "SELECT eventos.* 
        FROM eventos
        INNER JOIN inscripciones 
        ON eventos.id = inscripciones.evento_id
        WHERE inscripciones.usuario_id = '$usuario_id'
        AND eventos.fecha >= CURDATE()
        ORDER BY eventos.fecha ASC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis eventos - RunClub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Mis eventos</h2>

<a href="dashboard.php" class="btn btn-secondary mb-4">Volver al menú</a>

<hr>

<?php
if ($resultado->num_rows > 0) {

        echo "<div class='row'>";

    while ($evento = $resultado->fetch_assoc()) {

        $fecha_formateada = date("d/m/Y", strtotime($evento["fecha"]));

        echo "<div class='col-md-6'>";

        echo "<div class='card mb-4 shadow-sm'>";
        echo "<div class='card-body'>";

        echo "<h3 class='card-title'>" . $evento["nombre"] . "</h3>";

        echo "<p class='card-text'>";
        echo "<p><strong>Descripción:</strong> " . $evento["descripcion"] . "</p>";
        echo "<p><strong>Fecha:</strong> " . $fecha_formateada . "</p>";
        echo "<p><strong>Lugar:</strong> " . $evento["lugar"] . "</p>";

        echo "<form method='POST' action=''>";
        echo "<input type='hidden' name='evento_id' value='" . $evento["id"] . "'>";
        echo "<button class='btn btn-outline-danger btn-sm' type='submit' name='cancelar' onclick=\"return confirm('¿Estás seguro de que quieres cancelar este evento?');\">Cancelar inscripción</button>";
        echo "</form>";

        echo "<hr>";
        echo "</div>"; // card-body
        echo "</div>"; // card
        echo "</div>"; // col
    }

        echo "</div>"; // row

} else {

        echo "No estás inscrito en ningún evento.";
}
?>

</body>
</html>
