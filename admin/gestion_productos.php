<?php
include("seguridad_admin.php");
include("../conexion.php");

$mensaje = "";

// 1. LÓGICA PARA AÑADIR PRODUCTO (CREATE) - Versión Blindada
if (isset($_POST["guardar"])) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    
    // Gestión segura de la imagen
    $nombre_imagen = $_FILES["imagen"]["name"];
    $ruta_temporal = $_FILES["imagen"]["tmp_name"];
    // Generamos un nombre único para evitar que imágenes con el mismo nombre se sobreescriban
    $nombre_final = time() . "_" . $nombre_imagen;
    $destino = "../imagenes/productos/" . $nombre_final;

    if (move_uploaded_file($ruta_temporal, $destino)) {
        // Uso de Sentencias Preparadas
        $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $stock, $nombre_final);
        
        if ($stmt->execute()) {
            $mensaje = "<div class='alert alert-success shadow-sm'>Producto añadido con éxito a la tienda.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger shadow-sm'>Error en la base de datos: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        $mensaje = "<div class='alert alert-danger shadow-sm'>Error crítico: No se pudo subir la imagen al servidor.</div>";
    }
}

// 2. LÓGICA PARA ELIMINAR (DELETE) - Versión Blindada
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    
    // Primero deberíamos borrar la imagen física del servidor (opcional pero recomendado)
    // Pero para el blindaje SQL usamos:
    $stmt_del = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt_del->bind_param("i", $id);
    
    if ($stmt_del->execute()) {
        $mensaje = "<div class='alert alert-warning shadow-sm'>Producto eliminado correctamente.</div>";
    }
    $stmt_del->close();
}

$productos = $conn->query("SELECT * FROM productos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos - Admin RunClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include("navbar_admin.php"); ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col">
                <h1 class="fw-bold">Gestión de Merchandising</h1>
                <p class="text-muted">Control de stock y catálogo de la tienda oficial.</p>
            </div>
        </div>

        <?php echo $mensaje; ?>

        <div class="card mb-5 shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold py-3">
                Añadir Nuevo Producto al Catálogo
            </div>
            <div class="card-body p-4">
                <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre del Producto</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Camiseta Técnica RunClub" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" class="form-control" placeholder="0.00" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Stock Inicial</label>
                        <input type="number" name="stock" class="form-control" placeholder="Ej: 50" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Descripción Corta</label>
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Detalles del producto, materiales, tallas..." required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Imagen del Producto (Formato recomendado: JPG/PNG)</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" name="guardar" class="btn btn-primary fw-bold px-4">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Vista</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = $productos->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-4">
                                <img src="../imagenes/productos/<?php echo $p['imagen']; ?>" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold"><?php echo $p['nombre']; ?></div>
                                <small class="text-muted"><?php echo $p['descripcion']; ?></small>
                            </td>
                            <td class="fw-bold text-primary"><?php echo number_format($p['precio'], 2, ',', '.'); ?> €</td>
                            <td class="text-center">
                                <?php 
                                    // Definimos la clase de color según el stock
                                    if ($p['stock'] == 0) {
                                        $clase_stock = "bg-danger"; // Rojo si es 0
                                    } elseif ($p['stock'] < 10) {
                                        $clase_stock = "bg-warning text-dark"; // Naranja si es menos de 10
                                    } else {
                                        $clase_stock = "bg-success"; // Verde si es 10 o más
                                    }
                                ?>
                                <span class="badge rounded-pill <?php echo $clase_stock; ?> px-3">
                                    <?php echo $p['stock']; ?> uds.
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="?eliminar=<?php echo $p['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Borrar producto permanentemente?')">Eliminar</a>
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