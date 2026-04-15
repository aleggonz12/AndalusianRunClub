<?php
include("seguridad_admin.php"); 
include("../conexion.php");    

$mensaje = "";

// 1. LÓGICA DE ELIMINACIÓN BLINDADA
if (isset($_GET["eliminar"])) {
    $id_a_borrar = $_GET["eliminar"];
    
    // PASO A: Consultamos el rol del usuario antes de intentar borrar
    $check_stmt = $conn->prepare("SELECT rol FROM usuarios WHERE id = ?");
    $check_stmt->bind_param("i", $id_a_borrar);
    $check_stmt->execute();
    $res_check = $check_stmt->get_result();
    $usuario_target = $res_check->fetch_assoc();

    if (!$usuario_target) {
        $mensaje = "<div class='alert alert-secondary'>El usuario ya no existe.</div>";
    }
    // PROTECCIÓN 1: No borrarse a sí mismo
    elseif ($id_a_borrar == $_SESSION["id"]) {
        $mensaje = "<div class='alert alert-danger shadow-sm text-center fw-bold'>No puedes borrar tu propia cuenta.</div>";
    } 
    // PROTECCIÓN 2: Los admins son INTOCABLES desde la web
    elseif ($usuario_target['rol'] == 'admin') {
        $mensaje = "<div class='alert alert-warning shadow-sm text-center fw-bold'>Seguridad: No se pueden eliminar cuentas de Administrador desde el panel.</div>";
    } 
    else {
        // Si pasa las protecciones, procedemos al borrado seguro
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id_a_borrar);
        
        if ($stmt->execute()) {
            $mensaje = "<div class='alert alert-success shadow-sm text-center fw-bold'>Usuario eliminado correctamente.</div>";
        }
        $stmt->close();
    }
    $check_stmt->close();
}

$resultado = $conn->query("SELECT id, nombre, email, nivel, rol FROM usuarios ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Admin RunClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <<style>
    .btn-eliminar { 
        background-color: white; 
        color: #dc3545; /* Rojo Bootstrap */
        border: 1px solid #dc3545; 
        padding: 5px 15px; 
        border-radius: 5px; 
        text-decoration: none; 
        font-size: 0.875rem; 
        display: inline-block;
        transition: all 0.3s ease;
    }

    /* Efecto al pasar el ratón: Fondo rojo, texto blanco */
    .btn-eliminar:hover { 
        background-color: #dc3545; 
        color: white; 
    }
    
    /* Otros admins */
    .table-info td { background-color: #d9eef2 !important; }

    /* TU FILA: Aplicamos el color directamente a las celdas (td) */
    .fila-propia td { 
        background-color: #a0d1d6 !important; }
    
</style>
</head>
<body class="bg-light">

    <?php include("navbar_admin.php"); ?>

    <div class="container mt-4">
        <div class="mb-4">
            <h1 class="fw-bold">Gestión de Usuarios</h1>
            <p class="text-muted">Panel de control de comunidad y seguridad de perfiles.</p>
        </div>

        <?php echo $mensaje; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
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
                                // 1. Colores de Niveles (Tu diseño original)
                                $color_nivel = "bg-secondary"; 
                                if ($row["nivel"] == "principiante") { $color_nivel = "bg-success"; } 
                                elseif ($row["nivel"] == "intermedio") { $color_nivel = "bg-warning text-dark"; } 
                                elseif ($row["nivel"] == "avanzado") { $color_nivel = "bg-danger"; }

                                // 2. Estilo para las Filas (Diferenciando tu cuenta de otros admins)
                                if ($row["id"] == $_SESSION["id"]) {
                                    $clase_fila = 'fila-propia'; // Azul más fuerte con borde
                                } elseif ($row["rol"] == 'admin') {
                                    $clase_fila = 'table-info';  // Azul claro
                                } else {
                                    $clase_fila = ''; 
                                }

                                // Si es admin lo ponemos en azul fuerte, si es usuario en gris
                                $color_rol = ($row["rol"] == 'admin') ? 'bg-primary' : 'bg-secondary';
                            ?>
                            <tr class="<?php echo $clase_fila; ?>">
                                <td class="text-muted small">#<?php echo $row["id"]; ?></td>
                                <td class="fw-bold"><?php echo $row["nombre"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><span class="badge <?php echo $color_nivel; ?> px-3 py-2"><?php echo ucfirst($row["nivel"]); ?></span></td>
                                
                                <td><span class="badge <?php echo $color_rol; ?> px-3 py-2"><?php echo strtoupper($row["rol"]); ?></span></td>
                                
                                <td>
                                    <?php if ($row["id"] == $_SESSION["id"]): ?>
                                        <span class="text-muted small fw-bold">Tu cuenta</span>
                                    <?php elseif ($row["rol"] != 'admin'): ?>
                                        <a href="gestion_usuarios.php?eliminar=<?php echo $row["id"]; ?>" 
                                        class="btn-eliminar" 
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar a este usuario?')">
                                            Eliminar
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>