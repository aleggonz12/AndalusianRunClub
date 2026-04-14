<?php
include("seguridad_admin.php");
include("../conexion.php");

// 1. LÓGICA PARA AÑADIR CARRERA (CREATE)
if (isset($_POST["guardar_carrera"])) {
    $nombre = $_POST["nombre"];
    $fecha = $_POST["fecha"];
    $lugar = $_POST["lugar"];
    $distancia = $_POST["distancia"];
    $tipo = $_POST["tipo"];
    $web = $_POST["web_oficial"];

    $sql_insert = "INSERT INTO carreras (nombre, fecha, lugar, distancia, tipo, web_oficial) 
                   VALUES ('$nombre', '$fecha', '$lugar', '$distancia', '$tipo', '$web')";
    
    if ($conn->query($sql_insert) === TRUE) {
        $mensaje = "<div class='alert alert-success'>Carrera añadida correctamente al calendario.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// 2. LÓGICA PARA ELIMINAR (DELETE)
if (isset($_GET["eliminar"])) {
    $id_carrera = $_GET["eliminar"];
    $conn->query("DELETE FROM carreras WHERE id = '$id_carrera'");
    $mensaje = "<div class='alert alert-warning'>Carrera eliminada del sistema.</div>";
}

// Consultar todas las carreras ordenadas por fecha
$resultado_carreras = $conn->query("SELECT * FROM carreras ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Carreras - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h1>Gestión del Calendario Andaluz</h1>
            <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
        </div>

        <?php if(isset($mensaje)) echo $mensaje; ?>

        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-info text-dark"><h5>Añadir Nueva Carrera Popular</h5></div>
            <div class="card-body">
                <form action="" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre de la Carrera</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select" required>
                            <option value="popular">Popular</option>
                            <option value="media">Media Maratón</option>
                            <option value="maraton">Maratón</option>
                            <option value="trail">Trail</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Lugar (Provincia/Ciudad)</label>
                        <input type="text" name="lugar" class="form-control" placeholder="Ej: Sevilla" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Distancia (km)</label>
                        <input type="number" name="distancia" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Enlace Web Oficial (opcional)</label>
                        <input type="url" name="web_oficial" class="form-control" placeholder="https://...">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="guardar_carrera" class="btn btn-info">Guardar Carrera</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-sm table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Lugar</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($c = $resultado_carreras->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date("d/m/Y", strtotime($c["fecha"])); ?></td>
                            <td><?php echo $c["nombre"]; ?></td>
                            <td><?php echo $c["lugar"]; ?></td>
                            <td><span class="badge bg-secondary"><?php echo $c["tipo"]; ?></span></td>
                            <td>
                                <a href="?eliminar=<?php echo $c['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar esta carrera?')">Eliminar</a>
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