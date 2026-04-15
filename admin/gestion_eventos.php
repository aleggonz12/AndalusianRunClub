<?php
include("seguridad_admin.php");
include("../conexion.php");

$mensaje = "";

// 1. LÓGICA PARA AÑADIR EVENTO (CREATE) - Versión Blindada
if (isset($_POST["guardar_evento"])) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    $lugar = $_POST["lugar"];
    $plazas = $_POST["plazas"];

    // Usamos sentencia preparada para insertar con seguridad
    $stmt = $conn->prepare("INSERT INTO eventos (nombre, descripcion, fecha, lugar, plazas) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nombre, $descripcion, $fecha, $lugar, $plazas);
    
    if ($stmt->execute()) {
        $mensaje = "<div class='alert alert-success shadow-sm'>Evento creado con éxito e incorporado al sistema.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger shadow-sm'>Error al crear evento: " . $conn->error . "</div>";
    }
    $stmt->close();
}

// 2. LÓGICA PARA ELIMINAR EVENTO (DELETE) - Versión Blindada
if (isset($_GET["eliminar"])) {
    $id_evento = $_GET["eliminar"];
    
    $stmt_del = $conn->prepare("DELETE FROM eventos WHERE id = ?");
    $stmt_del->bind_param("i", $id_evento);
    
    if ($stmt_del->execute()) {
        $mensaje = "<div class='alert alert-warning shadow-sm'>Evento eliminado correctamente.</div>";
    }
    $stmt_del->close();
}

// Consultar eventos existentes (Lectura segura)
$resultado_eventos = $conn->query("SELECT * FROM eventos ORDER BY fecha ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos - Admin RunClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include("navbar_admin.php"); ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col">
                <h1 class="fw-bold">Gestión de Entrenamientos y Eventos</h1>
                <p class="text-muted">Administra los eventos exclusivos para los socios del club.</p>
            </div>
        </div>

        <?php echo $mensaje; ?>

        <div class="card mb-5 shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold py-3">
                Crear Nuevo Evento / Entrenamiento
            </div>
            <div class="card-body p-4">
                <form action="" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre del Evento</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Entrenamiento de Series en Pista" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Fecha</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Plazas Totales</label>
                        <input type="number" name="plazas" class="form-control" placeholder="Ej: 20" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Lugar</label>
                        <input type="text" name="lugar" class="form-control" placeholder="Ej: Instalaciones Deportivas La Cartuja" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Descripción del Evento</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Explica brevemente en qué consiste el evento..." required></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="guardar_evento" class="btn btn-primary fw-bold px-4">Publicar Evento</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Fecha</th>
                            <th>Evento</th>
                            <th>Lugar</th>
                            <th class="text-center">Plazas</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($ev = $resultado_eventos->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?php echo date("d/m/Y", strtotime($ev["fecha"])); ?></td>
                            <td>
                                <div class="fw-bold"><?php echo $ev["nombre"]; ?></div>
                                <small class="text-muted"><?php echo substr($ev["descripcion"], 0, 50) . "..."; ?></small>
                            </td>
                            <td><?php echo $ev["lugar"]; ?></td>
                            <td class="text-center">
    <?php 
        // Lógica de colores para las plazas del evento
        if ($ev["plazas"] <= 0) {
            $clase_plazas = "bg-danger"; // Rojo: Completo
            $texto_plazas = "Completo";
        } elseif ($ev["plazas"] < 10) {
            $clase_plazas = "bg-warning text-dark"; // Naranja: Últimas plazas
            $texto_plazas = $ev["plazas"] . " últimas plazas";
        } else {
            $clase_plazas = "bg-success"; // Verde: Disponible
            $texto_plazas = $ev["plazas"] . " plazas libres";
        }
    ?>
    <span class="badge rounded-pill <?php echo $clase_plazas; ?> px-3">
        <?php echo $texto_plazas; ?>
    </span>
</td>
                            <td class="text-center pe-4">
                                <a href="?eliminar=<?php echo $ev['id']; ?>" 
                                   class="btn btn-outline-danger btn-sm" 
                                   onclick="return confirm('¿Estás seguro de que quieres eliminar este entrenamiento permanentemente?')">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>