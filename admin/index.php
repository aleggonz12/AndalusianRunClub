<?php
include("seguridad_admin.php"); // Protección
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin - RunClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1>Panel de Administración 🛠️</h1>
        <p>Bienvenido, administrador: <?php echo $_SESSION["nombre"]; ?></p>
        <hr>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Eventos</h5>
                        <p>Crear y borrar entrenamientos grupales.</p>
                        <a href="gestion_eventos.php" class="btn btn-primary">Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Carreras</h5>
                        <p>Añadir nuevas carreras al calendario de Andalucía.</p>
                        <a href="gestion_carreras.php" class="btn btn-primary">Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Productos</h5>
                        <p>Añadir material al catálogo de merchandising.</p>
                        <a href="gestion_productos.php" class="btn btn-primary">Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p>Ver y dar de baja a corredores.</p>
                        <a href="gestion_usuarios.php" class="btn btn-primary">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="../dashboard.php" class="btn btn-outline-light">Volver a la Web</a>
    </div>
</body>
</html>