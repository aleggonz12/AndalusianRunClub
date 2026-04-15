<?php
// No ponemos session_start() aquí porque lo pondremos en cada página antes de incluir este archivo
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="dashboard.php">🏃‍♂️ RunClub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="carreras.php">Carreras</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="eventos.php">Eventos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="merchandising.php">Tienda</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Mi Perfil
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="mis_eventos.php">Mis Eventos</a></li>
            <li><a class="dropdown-item" href="mis_planes.php">Mis Planes</a></li>
            <li><a class="dropdown-item" href="mis_compras.php">Mis Compras</a></li>
          </ul>
        </li>
      </ul>
      
      <div class="d-flex align-items-center">
        <?php if ($_SESSION["rol"] == "admin"): ?>
          <a href="admin/index.php" class="btn btn-outline-warning btn-sm me-2">Panel Admin</a>
        <?php endif; ?>
        
        <span class="navbar-text me-3 text-white small">
          Hola, <strong><?php echo $_SESSION["nombre"]; ?></strong>
        </span>
        <a href="logout.php" class="btn btn-danger btn-sm">Salir</a>
      </div>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>