<nav class="navbar navbar-expand-lg navbar-light shadow-sm mb-4 arc-navbar">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center arc-brand" href="dashboard.php">
      <img src="Logo_Andalusian_Run_Club.png" alt="Logo ARC" class="me-2 arc-logo">
      <span class="arc-title">Andalusian Run Club</span>
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto arc-nav-links">
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
      
      <div class="d-flex align-items-center arc-user-info">
        <?php if ($_SESSION["rol"] == "admin"): ?>
          <a href="admin/index.php" class="btn btn-warning btn-sm me-2 fw-bold">Panel Admin</a>
        <?php endif; ?>
        
        <span class="navbar-text me-3 small arc-welcome">
          Hola, <strong><?php echo $_SESSION["nombre"]; ?></strong>
        </span>
        <a href="logout.php" class="btn btn-outline-danger btn-sm">Salir</a>
      </div>
    </div>
  </div>
</nav>

<style>
    /* 1. Estilo General de la Navbar ARC */
    .arc-navbar {
        background-color: #E8F5E9 !important; /* Un verde claro suave que combine con el logo */
        border-bottom: 2px solid #C8E6C9; /* Un borde sutil ligeramente más oscuro */
    }

    /* 2. Estilo del Logo */
    .arc-logo {
        height: 75px; /* Ajusta este valor para que el logo se vea bien con el texto */
        width: auto;
        object-fit: contain;
    }

    /* 3. Estilo del Título de la Marca */
    .arc-title {
        color: #174d19; /* Un verde oscuro intenso para el nombre de la marca */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* 4. Estilo de los Enlaces (para que resalten sobre el verde claro) */
    .arc-navbar .nav-link {
        color: #1B5E20 !important; /* Verde muy oscuro para los enlaces */
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .arc-navbar .nav-link:hover {
        color: #003a0f !important;
        transform: scale(1.15);
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1); /* Color Bootstrap primario al pasar el ratón */
    }

    .arc-logo:hover {
        transform: scale(1.1);
        transition: 0.3s;
    }

    /* 5. Estilo de los textos de bienvenida */
    .arc-welcome {
        color: #1B5E20 !important;
    }
</style>