<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$tipo_filtro = "";
$provincia_filtro = "";
$mes_filtro = "";

if (isset($_GET["tipo"])) {
    $tipo_filtro = $_GET["tipo"];
}

if (isset($_GET["provincia"])) {
    $provincia_filtro = $_GET["provincia"];
}

if (isset($_GET["mes"])) {
    $mes_filtro = $_GET["mes"];
}

$sql = "SELECT * FROM carreras WHERE fecha >= CURDATE()";

if ($tipo_filtro != "") {
    $sql .= " AND tipo = '$tipo_filtro'";
}

if ($provincia_filtro != "") {
    $sql .= " AND lugar LIKE '%$provincia_filtro%'";
}

if ($mes_filtro != "") {
    $sql .= " AND MONTH(fecha) = '$mes_filtro'";
}

$sql .= " ORDER BY fecha ASC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carreras populares - RunClub</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<h2>Carreras populares en Andalucía</h2>

<a href="dashboard.php" class="btn btn-secondary mb-3 mt-3">Volver al menú</a>

<hr>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">Filtrar carreras</h5>

        <form method="GET" action="carreras.php">
            <div class="row">

                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="popular" <?php if ($tipo_filtro == "popular") echo "selected"; ?>>Popular</option>
                        <option value="media" <?php if ($tipo_filtro == "media") echo "selected"; ?>>Media maratón</option>
                        <option value="maraton" <?php if ($tipo_filtro == "maraton") echo "selected"; ?>>Maratón</option>
                        <option value="trail" <?php if ($tipo_filtro == "trail") echo "selected"; ?>>Trail</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Provincia</label>
                    <select name="provincia" class="form-select">
                        <option value="">Todas</option>
                        <option value="Sevilla" <?php if ($provincia_filtro == "Sevilla") echo "selected"; ?>>Sevilla</option>
                        <option value="Cádiz" <?php if ($provincia_filtro == "Cádiz") echo "selected"; ?>>Cádiz</option>
                        <option value="Málaga" <?php if ($provincia_filtro == "Málaga") echo "selected"; ?>>Málaga</option>
                        <option value="Granada" <?php if ($provincia_filtro == "Granada") echo "selected"; ?>>Granada</option>
                        <option value="Córdoba" <?php if ($provincia_filtro == "Córdoba") echo "selected"; ?>>Córdoba</option>
                        <option value="Jaén" <?php if ($provincia_filtro == "Jaén") echo "selected"; ?>>Jaén</option>
                        <option value="Huelva" <?php if ($provincia_filtro == "Huelva") echo "selected"; ?>>Huelva</option>
                        <option value="Almería" <?php if ($provincia_filtro == "Almería") echo "selected"; ?>>Almería</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Mes</label>
                    <select name="mes" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" <?php if ($mes_filtro == "1") echo "selected"; ?>>Enero</option>
                        <option value="2" <?php if ($mes_filtro == "2") echo "selected"; ?>>Febrero</option>
                        <option value="3" <?php if ($mes_filtro == "3") echo "selected"; ?>>Marzo</option>
                        <option value="4" <?php if ($mes_filtro == "4") echo "selected"; ?>>Abril</option>
                        <option value="5" <?php if ($mes_filtro == "5") echo "selected"; ?>>Mayo</option>
                        <option value="6" <?php if ($mes_filtro == "6") echo "selected"; ?>>Junio</option>
                        <option value="7" <?php if ($mes_filtro == "7") echo "selected"; ?>>Julio</option>
                        <option value="8" <?php if ($mes_filtro == "8") echo "selected"; ?>>Agosto</option>
                        <option value="9" <?php if ($mes_filtro == "9") echo "selected"; ?>>Septiembre</option>
                        <option value="10" <?php if ($mes_filtro == "10") echo "selected"; ?>>Octubre</option>
                        <option value="11" <?php if ($mes_filtro == "11") echo "selected"; ?>>Noviembre</option>
                        <option value="12" <?php if ($mes_filtro == "12") echo "selected"; ?>>Diciembre</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-50">
                        Filtrar
                    </button>

                    <?php if ($tipo_filtro != "" || $provincia_filtro != "" || $mes_filtro != "") { ?>
                        <a href="carreras.php" class="btn btn-secondary w-50">
                            Limpiar
                        </a>
                    <?php } ?>
                </div>

            </div>
        </form>
    </div>
</div>

<?php
if ($resultado->num_rows > 0) {

    echo "<div class='row'>";

    $usuario_id = $_SESSION["id"];

    while ($carrera = $resultado->fetch_assoc()) {

        $carrera_id = $carrera["id"];

        $sql_check = "SELECT * FROM planes_entrenamiento
                    WHERE usuario_id = '$usuario_id' 
                    AND carrera_id = '$carrera_id'";

        $resultado_check = $conn->query($sql_check);

        $plan_guardado = $resultado_check->num_rows > 0;

        $fecha_formateada = date("d/m/Y", strtotime($carrera["fecha"]));
        
        echo "<div class='col-md-6'>";

        echo "<div class='card mb-4 shadow-sm'>";
        echo "<div class='card-body'>";

        echo "<h5 class='card-title'>" . $carrera["nombre"] . "</h5>";

        echo "<p class='card-text'>";
        echo "<strong>Fecha:</strong> " . $fecha_formateada . "<br>";
        echo "<strong>Lugar:</strong> " . $carrera["lugar"] . "<br>";
        echo "<strong>Distancia:</strong> " . $carrera["distancia"] . " km";
        echo "</p>";

        $fecha_carrera = new DateTime($carrera["fecha"]);
        $hoy = new DateTime();
        $diferencia = $hoy->diff($fecha_carrera);
        $semanas = floor($diferencia->days / 7);

    if ($semanas > 0) {

        echo "<div class='d-flex gap-2 mt-2'>";

    // Botón VER PLAN (solo si faltan 12 semanas o menos)
        if ($semanas <= 12) {

        if ($plan_guardado) {

            echo "<a href='plan.php?carrera_id=" . $carrera["id"] . "' 
                class='btn btn-success btn-sm'>
                Plan guardado
                </a>";

        } else {

            echo "<a href='plan.php?carrera_id=" . $carrera["id"] . "' 
                class='btn btn-outline-success btn-sm'>
                Ver plan
                </a>";
    }
}

        // Botón WEB OFICIAL (solo si existe)
        if (!empty($carrera["web_oficial"])) {
            echo "<a href='" . $carrera["web_oficial"] . "' 
                target='_blank' 
                class='btn btn-outline-primary btn-sm'>
                Web oficial
              </a>";
    }

        echo "</div>";

        // Mensaje informativo si faltan más de 12 semanas
        if ($semanas > 12) {
            echo "<p class='text-muted mt-2'>
                <em>El plan estará disponible cuando falten 12 semanas o menos.</em>
              </p>";
        }

    } else {

        echo "<p class='text-danger'>
            <strong>La carrera es esta semana.</strong>
          </p>";
    }

        echo "</div>"; // card-body
        echo "</div>"; // card
        echo "</div>"; // col-md-6
    }

    echo "</div>"; // row

} else {
    echo "No hay carreras disponibles.";
}
?>
