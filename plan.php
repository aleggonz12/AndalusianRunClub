<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["carrera_id"])) {
    header("Location: carreras.php");
    exit();
}

$carrera_id = $_GET["carrera_id"];
$usuario_id = $_SESSION["id"];

// Comprobar si ya existe el plan guardado
$sql_comprobar = "SELECT * FROM planes_entrenamiento 
                  WHERE usuario_id = '$usuario_id' 
                  AND carrera_id = '$carrera_id'";

$resultado_comprobar = $conn->query($sql_comprobar);

$plan_guardado = false;

if ($resultado_comprobar->num_rows > 0) {
    $plan_guardado = true;
}

if (isset($_POST["guardar_plan"])) {

    $sql_insertar = "INSERT INTO planes_entrenamiento (usuario_id, carrera_id)
                     VALUES ('$usuario_id', '$carrera_id')";

    if ($conn->query($sql_insertar) === TRUE) {
        $plan_guardado = true;
    }
}

if (isset($_POST["cancelar_plan"])) {

    $sql_eliminar = "DELETE FROM planes_entrenamiento 
                     WHERE usuario_id = '$usuario_id' 
                     AND carrera_id = '$carrera_id'";

    if ($conn->query($sql_eliminar) === TRUE) {
        $plan_guardado = false;
    }
}

// Obtener datos de la carrera
$sql_carrera = "SELECT * FROM carreras WHERE id = '$carrera_id'";
$resultado_carrera = $conn->query($sql_carrera);
$carrera = $resultado_carrera->fetch_assoc();

// Formatear fecha
$fecha_formateada = date("d/m/Y", strtotime($carrera["fecha"]));

// Obtener nivel del usuario
$sql_usuario = "SELECT nivel FROM usuarios WHERE id = '$usuario_id'";
$resultado_usuario = $conn->query($sql_usuario);
$usuario = $resultado_usuario->fetch_assoc();

// Definir el color del badge según el nivel
$color_nivel = "bg-secondary"; 
if ($usuario["nivel"] == "principiante") {
    $color_nivel = "bg-success"; 
} elseif ($usuario["nivel"] == "intermedio") {
    $color_nivel = "bg-warning text-dark"; 
} elseif ($usuario["nivel"] == "avanzado") {
    $color_nivel = "bg-danger"; 
}

// Calcular semanas hasta la carrera
$fecha_carrera = new DateTime($carrera["fecha"]);
$hoy = new DateTime();
$diferencia = $hoy->diff($fecha_carrera);
$semanas = floor($diferencia->days / 7);

// Limitar a máximo 12 semanas
if ($semanas > 12) {
    $semanas = 12;
}

// Determinar tipo según distancia
$distancia = $carrera["distancia"];

if ($distancia <= 8) {
    $tipo = "corta";
} elseif ($distancia <= 15) {
    $tipo = "media";
} elseif ($distancia <= 25) {
    $tipo = "media_maraton";
} elseif ($distancia <= 45) {
    $tipo = "maraton";
} else {
    $tipo = "ultra";
}

// Volumen base según tipo y nivel
if ($tipo == "corta") {

    if ($usuario["nivel"] == "principiante") $km_base = 18;
    elseif ($usuario["nivel"] == "intermedio") $km_base = 25;
    else $km_base = 32;

} elseif ($tipo == "media") {

    if ($usuario["nivel"] == "principiante") $km_base = 25;
    elseif ($usuario["nivel"] == "intermedio") $km_base = 35;
    else $km_base = 45;

} elseif ($tipo == "media_maraton") {

    if ($usuario["nivel"] == "principiante") $km_base = 35;
    elseif ($usuario["nivel"] == "intermedio") $km_base = 45;
    else $km_base = 60;

} else { // maraton

    if ($usuario["nivel"] == "principiante") $km_base = 45;
    elseif ($usuario["nivel"] == "intermedio") $km_base = 60;
    else $km_base = 75;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Plan de entrenamiento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("navbar.php"); ?>

<div class="container mt-4">

    <h2 class="fw-bold mb-4">Plan de entrenamiento para <?php echo $carrera["nombre"]; ?></h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="text-secondary small fw-bold uppercase mb-3">DETALLES DE LA CARRERA</h5>
                    <p class="mb-1"><strong>Distancia:</strong> <?php echo $carrera["distancia"]; ?> km</p>
                    <p class="mb-1"><strong>Fecha:</strong> <?php echo $fecha_formateada; ?></p>
                    <p class="mb-1"><strong>Tu nivel:</strong> <span class="badge <?php echo $color_nivel; ?>"> <?php echo $usuario["nivel"]; ?></span></p>
                    <p class="mb-0"><strong>Semanas:</strong> <?php echo $semanas; ?></p>
                </div>
            </div>
        </div>
    </div>

    <hr class="mb-4">

<?php
if ($semanas <= 0) {

    echo "La carrera ya ha pasado o es esta semana.";

} else {

    for ($i = 1; $i <= $semanas; $i++) {

        // Progresión 5% por semana
        $km_semana = $km_base * (1 + ($i - 1) * 0.05);

        // Última semana descarga
        if ($i == $semanas) {
            $km_semana *= 0.7;
        }

        $km_semana = round($km_semana);

        echo "<div class='card mb-3'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Semana $i</h5>";


        if ($tipo == "corta") {

            echo "<ul class='list-group list-group-flush'>";

            echo "<li class='list-group-item'>Martes: " . round($km_semana * 0.3) . " km suave</li>";
            echo "<li class='list-group-item'>Jueves: Series 6x400m</li>";
            echo "<li class='list-group-item'>Domingo: " . round($km_semana * 0.4) . " km tirada larga</li>";

            echo "</ul>";

        } elseif ($tipo == "media") {

            echo "<ul class='list-group list-group-flush'>";

            echo "<li class='list-group-item'>Martes: " . round($km_semana * 0.25) . " km suave</li>";
            echo "<li class='list-group-item'>Jueves: Series 8x400m</li>";
            echo "<li class='list-group-item'>Sábado: " . round($km_semana * 0.2) . " km ritmo medio</li>";
            echo "<li class='list-group-item'>Domingo: " . round($km_semana * 0.35) . " km tirada larga</li>";

            echo "</ul>";

        } elseif ($tipo == "media_maraton") {

            echo "<ul class='list-group list-group-flush'>";

            echo "<li class='list-group-item'>Lunes: " . round($km_semana * 0.2) . " km suave</li>";
            echo "<li class='list-group-item'>Miércoles: Series 6x800m</li>";
            echo "<li class='list-group-item'>Viernes: " . round($km_semana * 0.2) . " km ritmo controlado</li>";
            echo "<li class='list-group-item'>Domingo: " . round($km_semana * 0.4) . " km tirada larga</li>";

            echo "</ul>";

        } else { // maraton

            echo "<ul class='list-group list-group-flush'>";

            echo "<li class='list-group-item'>Lunes: " . round($km_semana * 0.15) . " km suave</li>";
            echo "<li class='list-group-item'>Martes: Series 8x800m</li>";
            echo "<li class='list-group-item'>Jueves: " . round($km_semana * 0.2) . " km ritmo controlado</li>";
            echo "<li class='list-group-item'>Sábado: " . round($km_semana * 0.15) . " km suave</li>";
            echo "<li class='list-group-item'>Domingo: " . round($km_semana * 0.35) . " km tirada larga</li>";

            echo "</ul>";
            
        }

        echo "</div>";
        echo "</div>";
    }

}
?>

<div class="mt-4">

<?php if (!$plan_guardado): ?>

    <form method="POST" action="">
        <input type="hidden" name="guardar_plan" value="1">
        <button class="btn btn-outline-success me-2 mb-3" type="submit">
            Guardar plan
        </button>
    </form>

<?php else: ?>

    <div class="d-flex align-items-center gap-2 mt-3">

    <span class="badge bg-success text-white px-3 py-2 mb-3">
        Guardado
    </span>

    <form method="POST" action="" class="mb-0"
          onsubmit="return confirm('¿Seguro que quieres cancelar este plan?');">

        <input type="hidden" name="cancelar_plan" value="1">

        <button class="btn btn-danger btn-sm mb-3">
            Cancelar plan
        </button>

    </form>

</div>

<?php endif; ?>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
