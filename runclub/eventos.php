<?php
session_start();
include("conexion.php");

if (isset($_POST["apuntarse"])) {

    $usuario_id = $_SESSION["id"];
    $evento_id = $_POST["evento_id"];

    // Comprobar si ya está inscrito
    $comprobar = "SELECT * FROM inscripciones 
                  WHERE usuario_id = '$usuario_id' 
                  AND evento_id = '$evento_id'";

    $resultado_comprobar = $conn->query($comprobar);

    if ($resultado_comprobar->num_rows > 0) {

        echo "Ya estás inscrito en este evento.";

    } else {

        // Comprobar plazas disponibles
        $consulta_plazas = "SELECT plazas FROM eventos WHERE id = '$evento_id'";
        $resultado_plazas = $conn->query($consulta_plazas);
        $evento = $resultado_plazas->fetch_assoc();

        if ($evento["plazas"] > 0) {

            // Insertar inscripción
            $sql = "INSERT INTO inscripciones (usuario_id, evento_id) 
                    VALUES ('$usuario_id', '$evento_id')";

            if ($conn->query($sql) === TRUE) {

                // Restar una plaza
                $actualizar = "UPDATE eventos 
                               SET plazas = plazas - 1 
                               WHERE id = '$evento_id'";

                $conn->query($actualizar);

            } else {
                echo "Error al inscribirse.";
            }

        } else {

            echo "No quedan plazas disponibles.";

        }
    }
}

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM eventos 
        WHERE fecha >= CURDATE()
        ORDER BY fecha ASC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eventos - RunClub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Eventos disponibles</h2>

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

    echo "<h5 class='card-title'>" . $evento["nombre"] . "</h5>";

    echo "<p class='card-text'>";
    echo "<strong>Descripción:</strong> " . $evento["descripcion"] . "<br>";
    echo "<strong>Fecha:</strong> " . $fecha_formateada . "<br>";
    echo "<strong>Lugar:</strong> " . $evento["lugar"] . "<br>";
    echo "<strong>Plazas disponibles:</strong> " . $evento["plazas"];
    echo "</p>";

    $usuario_id = $_SESSION["id"];
    $evento_id = $evento["id"];

// Comprobar si ya está inscrito
$consulta_inscrito = "SELECT * FROM inscripciones 
                      WHERE usuario_id = '$usuario_id' 
                      AND evento_id = '$evento_id'";

$resultado_inscrito = $conn->query($consulta_inscrito);

if ($resultado_inscrito->num_rows > 0) {

    echo "<p class='text-primary'><strong>Ya estás inscrito.</strong></p>";

} elseif ($evento["plazas"] <= 0) {

    echo "<p class='text-danger'><strong>Evento completo.</strong></p>";

} else {

    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='evento_id' value='" . $evento["id"] . "'>";
    echo "<button class='btn btn-success' type='submit' name='apuntarse'>Apuntarse</button>";
    echo "</form>";
}


    echo "<hr>";
    echo "</div>"; // card-body
    echo "</div>"; // card
    echo "</div>"; // col
}

    echo "</div>"; // row

} else {
    echo "No hay eventos disponibles.";
}
?>

</div>
</body>
</html>
