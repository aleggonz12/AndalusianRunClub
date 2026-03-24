<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - RunClub</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Bienvenido, <?php echo $_SESSION["nombre"]; ?> 👋</h2>

<hr>

<h3>Menú</h3>


    <div class="row">

        <div class="col-md-4">
            <a href="mis_eventos.php" class="btn btn-primary w-100 mb-3">Mis eventos</a>
        </div>
       
        <div class="col-md-4">
            <a href="mis_planes.php" class="btn btn-primary w-100 mb-3">Mis planes de entrenamiento</a> 
        </div>

        <div class="col-md-4">
            <a href="mis_compras.php" class="btn btn-primary w-100 mb-3">Mis compras</a>
        </div>

        <div class="col-md-4">
            <a href="eventos.php" class="btn btn-primary w-100 mb-3">Eventos</a>
        </div>

        <div class="col-md-4">
            <a href="carreras.php" class="btn btn-primary w-100 mb-3">Carreras</a>
        </div>

        <div class="col-md-4">
            <a href="merchandising.php" class="btn btn-primary w-100 mb-3">Merchandising</a>
        </div>

        <div class="col-md-4">
            <a href="logout.php" class="btn btn-primary w-100 mb-3">Cerrar sesión</a>
        </div>
  
    </div>


</div>
</body>
</html>
