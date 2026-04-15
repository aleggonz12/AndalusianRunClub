<?php
// Detectamos el nombre del archivo actual para resaltar el enlace activo
$archivo_actual = basename($_SERVER['PHP_SELF']);

// Detectamos si estamos en la carpeta admin para las rutas (por si acaso)
$directorio_actual = basename(dirname($_SERVER['PHP_SELF']));
$path_to_root = ($directorio_actual == 'admin') ? "../" : "";
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow mb-4" style="border-bottom: 3px solid #ffc107;">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
      🏃‍♂️ RunClub 
      <span class="badge bg-warning text-dark ms-2" style="font-size: 0.5em; letter-spacing: 1px;">
           MODO ADMIN
      </span>
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav me-auto">
        
        <li class="nav-item">
          <a class="nav-link fw-bold <?php echo ($archivo_actual == 'gestion_carreras.php') ? 'text-warning' : 'text-white-50'; ?>" 
             href="gestion_carreras.php">Gestión Carreras</a>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-bold <?php echo ($archivo_actual == 'gestion_eventos.php') ? 'text-warning' : 'text-white-50'; ?>" 
             href="gestion_eventos.php">Gestión Eventos</a>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-bold <?php echo ($archivo_actual == 'gestion_productos.php') ? 'text-warning' : 'text-white-50'; ?>" 
             href="gestion_productos.php">Gestión Tienda</a>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-bold <?php echo ($archivo_actual == 'gestion_usuarios.php') ? 'text-warning' : 'text-white-50'; ?>" 
             href="gestion_usuarios.php">Gestión Usuarios</a>
        </li>

        <li class="nav-item border-start ms-2 ps-2">
          <a class="nav-link text-info" href="<?php echo $path_to_root; ?>dashboard.php">Vista Usuario</a>
        </li>
      </ul>
      
      <div class="d-flex align-items-center">
        <span class="navbar-text me-3 text-white small">
          Admin: <strong><?php echo $_SESSION["nombre"]; ?></strong>
        </span>
        <a href="<?php echo $path_to_root; ?>logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
      </div>
    </div>
  </div>
</nav>