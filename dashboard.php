<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - RunClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    </style>
</head>
<body class="bg-light">

<?php include("navbar.php"); ?>

<div class="container mt-4">
    <h2 class="fw-bold mb-1">Panel de Usuario</h2>
    <p class="text-muted mb-4">Gestiona tu actividad y descubre nuevos retos.</p>

    <h5 class="text-secondary uppercase small fw-bold mb-3">MI ACTIVIDAD PERSONAL</h5>
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-start border-primary border-4 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="fs-1 me-3">📅</div>
                    <div>
                        <h6 class="card-title mb-0">Mis Eventos</h6>
                        <a href="mis_eventos.php" class="stretched-link small text-decoration-none">Ver mis inscripciones</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-start border-success border-4 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="fs-1 me-3">📋</div>
                    <div>
                        <h6 class="card-title mb-0">Mis Planes</h6>
                        <a href="mis_planes.php" class="stretched-link small text-decoration-none">Ver mis entrenamientos</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-start border-info border-4 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="fs-1 me-3">🛍️</div>
                    <div>
                        <h6 class="card-title mb-0">Mis Compras</h6>
                        <a href="mis_compras.php" class="stretched-link small text-decoration-none">Historial de pedidos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h5 class="text-secondary uppercase small fw-bold mb-3">EXPLORAR RUNCLUB</h5>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100 shadow border-0">
                <div class="card-body text-center py-4">
                    <div class="display-6 mb-2">👟</div>
                    <h5>Eventos</h5>
                    <p class="small opacity-75">Únete a quedadas grupales</p>
                    <a href="eventos.php" class="btn btn-light btn-sm fw-bold">Ver todos</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white h-100 shadow border-0">
                <div class="card-body text-center py-4">
                    <div class="display-6 mb-2">🏁</div>
                    <h5>Carreras</h5>
                    <p class="small opacity-75">Calendario oficial de Andalucía</p>
                    <a href="carreras.php" class="btn btn-light btn-sm fw-bold">Explorar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark h-100 shadow border-0">
                <div class="card-body text-center py-4">
                    <div class="display-6 mb-2">👕</div>
                    <h5>Merchandising</h5>
                    <p class="small opacity-75">Equipamiento oficial del club</p>
                    <a href="merchandising.php" class="btn btn-dark btn-sm fw-bold">Ir a la tienda</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>