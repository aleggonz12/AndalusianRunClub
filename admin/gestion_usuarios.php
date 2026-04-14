<?php
include("seguridad_admin.php"); // Protección de acceso
include("../conexion.php");    // Conexión (está un nivel arriba)

// Lógica para eliminar un usuario si se recibe el ID
if (isset($_GET["eliminar"])) {
    $id_a_borrar = $_GET["eliminar"];
    
    // Evitar que el admin se borre a sí mismo por error
    if ($id_a_borrar == $_SESSION["id"]) {
        $mensaje = "<div class='alert alert-danger'>No puedes borrar tu propia cuenta de administrador.</div>";
    } else {
        $sql_borrar = "DELETE FROM usuarios WHERE id = '$id_a_borrar'";
        if ($conn->query($sql_borrar) === TRUE) {
            $mensaje = "<div class='alert alert-success'>Usuario eliminado correctamente.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al eliminar: " . $conn->error . "</div>";
        }
    }
}

// Consultar todos los usuarios
$sql = "SELECT id, nombre, email, nivel, rol FROM usuarios ORDER BY id DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Gestión de Usuarios</h1>
            <a href="index.php" class="btn btn-secondary">Volver al Panel</a>
        </div>
        <hr>

        <?php if(isset($mensaje)) echo $mensaje; ?>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Nivel</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $resultado->fetch_assoc()): 
                            // 1. Lógica de colores para el NIVEL
                            $color_nivel = "bg-secondary"; 
                            if ($row["nivel"] == "principiante") { $color_nivel = "bg-success"; } 
                            elseif ($row["nivel"] == "intermedio") { $color_nivel = "bg-warning text-dark"; } 
                            elseif ($row["nivel"] == "avanzado") { $color_nivel = "bg-danger"; }

                            // 2. Lógica para resaltar la FILA del ADMIN
                            $clase_fila = ($row["rol"] == 'admin') ? 'table-info' : '';
        
                            // 3. Lógica para el color del badge del ROL
                            $color_rol = ($row["rol"] == 'admin') ? 'bg-primary' : 'bg-secondary';
                        ?>
                        <tr class="<?php echo $clase_fila; ?>">
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["nombre"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td>
                                <span class="badge <?php echo $color_nivel; ?>">
                                    <?php echo $row["nivel"]; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo $color_rol; ?>">
                                    <?php echo $row["rol"]; ?>
                                </span>
                            </td>
                            <td>
                                <a href="gestion_usuarios.php?eliminar=<?php echo $row["id"]; ?>" 
                                    class="btn btn-sm text-white" 
                                    style="background-color: #ff6666; border: none;" 
                                    onclick="return confirm('¿Estás seguro de que quieres eliminar a este usuario?')">
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
</body>
</html>