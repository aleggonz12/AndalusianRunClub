<?php
include("seguridad_admin.php");
include("../conexion.php");

// 1. LÓGICA PARA AÑADIR PRODUCTO (CREATE)
if (isset($_POST["guardar"])) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    
    // Gestión de la imagen
    $nombre_imagen = $_FILES["imagen"]["name"];
    $ruta_temporal = $_FILES["imagen"]["tmp_name"];
    $destino = "../imagenes/productos/" . $nombre_imagen;

    if (move_uploaded_file($ruta_temporal, $destino)) {
        $sql_insert = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen) 
                       VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$nombre_imagen')";
        
        if ($conn->query($sql_insert) === TRUE) {
            $mensaje = "<div class='alert alert-success'>Producto añadido con éxito.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al subir la imagen.</div>";
    }
}

// 2. LÓGICA PARA ELIMINAR (DELETE)
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $conn->query("DELETE FROM productos WHERE id = '$id'");
    $mensaje = "<div class='alert alert-warning'>Producto eliminado.</div>";
}

$productos = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <h1>Gestión de Merchandising</h1>
            <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
        </div>

        <?php if(isset($mensaje)) echo $mensaje; ?>

        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-primary text-white"><h5>Añadir Nuevo Producto</h5></div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="custom-control-input form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Stock inicial</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Imagen del producto</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="guardar" class="btn btn-success">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-striped align-middle shadow-sm bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($p = $productos->fetch_assoc()): ?>
                <tr>
                    <td><img src="../imagenes/productos/<?php echo $p['imagen']; ?>" width="50"></td>
                    <td><strong><?php echo $p['nombre']; ?></strong></td>
                    <td><?php echo $p['precio']; ?> €</td>
                    <td><?php echo $p['stock']; ?> uds.</td>
                    <td>
                        <a href="?eliminar=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Borrar producto?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>