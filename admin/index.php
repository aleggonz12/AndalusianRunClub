<?php
include("seguridad_admin.php"); // Protección para que solo entren administradores
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - RunClub Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .card-admin {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .card-admin:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .icon-box {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <?php include("navbar_admin.php"); ?>

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 text-center text-md-start">
                <h1 class="fw-bold text-dark">Panel de Administración 🛠️</h1>
                <p class="text-secondary">Bienvenido al centro de gestión, <strong><?php echo $_SESSION["nombre"]; ?></strong>.</p>
                <hr class="w-25 mx-auto mx-md-0 border-primary border-2 opacity-75">
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card card-admin shadow-sm h-100 p-3 text-center">
                    <div class="card-body d-flex flex-column">
                        <div class="icon-box">🏁</div>
                        <h5 class="card-title fw-bold">Carreras</h5>
                        <p class="small text-muted">Añadir o eliminar carreras populares en Andalucía.</p>
                        <a href="gestion_carreras.php" class="btn btn-dark mt-auto py-2 fw-bold">Gestionar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-admin shadow-sm h-100 p-3 text-center">
                    <div class="card-body d-flex flex-column">
                        <div class="icon-box">📅</div>
                        <h5 class="card-title fw-bold">Eventos</h5>
                        <p class="small text-muted">Organizar entrenamientos grupales y eventos del club.</p>
                        <a href="gestion_eventos.php" class="btn btn-dark mt-auto py-2 fw-bold">Gestionar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-admin shadow-sm h-100 p-3 text-center">
                    <div class="card-body d-flex flex-column">
                        <div class="icon-box">👕</div>
                        <h5 class="card-title fw-bold">Tienda</h5>
                        <p class="small text-muted">Control de stock y catálogo de merchandising.</p>
                        <a href="gestion_productos.php" class="btn btn-dark mt-auto py-2 fw-bold">Gestionar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-admin shadow-sm h-100 p-3 text-center">
                    <div class="card-body d-flex flex-column">
                        <div class="icon-box">👥</div>
                        <h5 class="card-title fw-bold">Usuarios</h5>
                        <p class="small text-muted">Ver lista de corredores y dar de baja a usuarios.</p>
                        <a href="gestion_usuarios.php" class="btn btn-dark mt-auto py-2 fw-bold">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="../dashboard.php" class="btn btn-link text-decoration-none text-muted">
                    <span class="me-2">←</span> Volver a la vista de usuario
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>