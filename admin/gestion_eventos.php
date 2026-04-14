<?php
include("seguridad_admin.php");
include("../conexion.php");

// 1. LÓGICA PARA AÑADIR EVENTO (CREATE)
if (isset($_POST["guardar_evento"])) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    $lugar = $_POST["lugar"];
    $plazas = $_POST["plazas"];

    $sql_insert = "INSERT INTO eventos (nombre, descripcion, fecha, lugar, plazas) 
                   VALUES ('$nombre', '$descripcion', '$fecha', '$lugar', '$plazas')";
    
    if ($conn->query($sql_insert) === TRUE) {
        $mensaje = "<div class='alert alert-success'>Evento creado con éxito.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// 2. LÓGICA PARA ELIMINAR EVENTO (DELETE)
if (isset($_GET["eliminar"])) {
    $id_evento = $_GET["eliminar"];
    $sql_borrar = "DELETE FROM eventos WHERE id = '$id_evento'";
    
    if ($conn->query($sql_borrar) === TRUE) {
        $mensaje = "<div class='alert alert-warning'>Evento eliminado correctamente.</div>";
    }
}

// Consultar eventos existentes
$resultado_eventos = $conn->query("SELECT * FROM eventos ORDER BY fecha ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h1>Gestión de Eventos Grupales</h1>
            <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
        </div>

        <?php if(isset($mensaje)) echo $mensaje; ?>

        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-success text-white"><h5>Crear Nuevo Entrenamiento</h5></div>
            <div class="card-body">
                <form action="" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre del Evento</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Tirada larga por el Guadalquivir" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Plazas Disponibles</label>
                        <input type="number" name="plazas" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ciudad</label>
                        <input type="text" name="lugar" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Descripción / Detalles</label>
                        <textarea name="descripcion" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="guardar_evento" class="btn btn-success">Publicar Evento</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Evento</th>
                            <th>Ciudad</th>
                            <th>Plazas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($ev = $resultado_eventos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date("d/m/Y", strtotime($ev["fecha"])); ?></td>
                            <td><strong><?php echo $ev["nombre"]; ?></strong></td>
                            <td><?php echo $ev["lugar"]; ?></td>
                            <td><?php echo $ev["plazas"]; ?></td>
                            <td>
                                <a href="?eliminar=<?php echo $ev['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('¿Eliminar este entrenamiento?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>