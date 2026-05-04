<?php
include("seguridad_admin.php"); // Mantén tu archivo de seguridad
include("../conexion.php");

$mensaje = "";

// 1. LÓGICA PARA AÑADIR CARRERA (CREATE) - Versión Segura
if (isset($_POST["guardar_carrera"])) {
    $nombre = $_POST["nombre"];
    $fecha = $_POST["fecha"];
    $lugar = $_POST["lugar"];
    $distancia = $_POST["distancia"];
    $tipo = $_POST["tipo"];
    $web = $_POST["web_oficial"];

    // Usamos sentencia preparada
    $stmt = $conn->prepare("INSERT INTO carreras (nombre, fecha, lugar, distancia, tipo, web_oficial) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdss", $nombre, $fecha, $lugar, $distancia, $tipo, $web);
    
    if ($stmt->execute()) {
        $mensaje = "<div class='alert alert-success shadow-sm'>Carrera añadida correctamente al calendario.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger shadow-sm'>Error: " . $conn->error . "</div>";
    }
    $stmt->close();
}

// 2. LÓGICA PARA ELIMINAR (DELETE) - Versión Segura
if (isset($_GET["eliminar"])) {
    $id_carrera = $_GET["eliminar"];
    $stmt_del = $conn->prepare("DELETE FROM carreras WHERE id = ?");
    $stmt_del->bind_param("i", $id_carrera);
    $stmt_del->execute();
    $mensaje = "<div class='alert alert-warning shadow-sm'>Carrera eliminada del sistema.</div>";
    $stmt_del->close();
}

// Consultar todas las carreras
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

    <?php include("navbar_admin.php"); ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col">
                <h1 class="fw-bold">Gestión del Calendario</h1>
                <p class="text-muted">Panel de control administrativo para eventos de Andalucía.</p>
            </div>
        </div>

        <?php echo $mensaje; ?>

        <div class="card mb-5 shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold py-3">
                <i class="bi bi-plus-circle me-2"></i>Añadir Nueva Carrera Popular
            </div>
            <div class="card-body p-4">
                <form action="" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre de la Carrera</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Nocturna de Sevilla" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Fecha</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipo</label>
                        <select name="tipo" class="form-select" required>
                            <option value="popular">Popular</option>
                            <option value="media">Media Maratón</option>
                            <option value="maraton">Maratón</option>
                            <option value="trail">Trail</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Lugar</label>
                        <input type="text" name="lugar" class="form-control" placeholder="Ej: Córdoba" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Distancia (km)</label>
                        <input type="number" step="0.1" name="distancia" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Enlace Web Oficial</label>
                        <input type="url" name="web_oficial" class="form-control" placeholder="https://...">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="guardar_carrera" class="btn btn-primary fw-bold px-4">Guardar Carrera</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Lugar</th>
                            <th>Tipo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($c = $resultado_carreras->fetch_assoc()): 
                            // 1. Definimos la clase de Bootstrap según el tipo
                            $color_badge = "bg-secondary"; // Color por defecto

                            switch ($c["tipo"]) {
                                case "popular":
                                    $color_badge = "bg-primary";  // Azul
                                    break;
                                case "media":
                                    $color_badge = "bg-warning text-dark"; // Amarillo (con texto oscuro para legibilidad)
                                    break;
                                case "maraton":
                                    $color_badge = "bg-danger";   // Rojo
                                    break;
                                case "trail":
                                    $color_badge = "bg-success";  // Verde
                                    break;
                            }
                        ?>
                        <tr>
                            <td class="fw-bold"><?php echo date("d/m/Y", strtotime($c["fecha"])); ?></td>
                            <td><?php echo $c["nombre"]; ?></td>
                            <td><?php echo $c["lugar"]; ?></td>
                            <!-- 2. Aplicamos la variable $color_badge aquí -->
                            <td>
                                <span class="badge <?php echo $color_badge; ?>">
                                    <?php echo ucfirst($c["tipo"]); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="?eliminar=<?php echo $c['id']; ?>" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('¿Seguro que quieres eliminar esta carrera?')">Eliminar</a>
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