<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow"
     style="background: linear-gradient(90deg, #0f3d2e, #1a6b4f);">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
      Fuego Verde - Operaciones
    </a>

    <div class="ms-auto">
      <a href="?pid=<?php echo base64_encode("Presentacion/autenticar.php") ?>"
         class="btn btn-outline-light px-4">
        <i class="fa-solid fa-unlock-keyhole me-1"></i> Acceso Staff
      </a>
    </div>
  </div>
</nav>

<header class="d-flex align-items-center text-light"
        style="margin-top: 70px; height: 60vh; background: linear-gradient(rgba(15,61,46,0.85), rgba(15,61,46,0.85)), url('img/hero.jpg') center/cover no-repeat;">
  <div class="container text-center">
    <h1 class="display-4 fw-bold">Sistema de Gestión</h1>
    <p class="fs-4 mb-4">Control de Inventario, Compras y Ventas</p>

    <div class="d-flex justify-content-center gap-3">
      <a href="?pid=<?php echo base64_encode("Presentacion/autenticar.php") ?>" class="btn btn-success btn-lg px-5 shadow">
        Comenzar Turno
      </a>
    </div>
  </div>
</header>

<section class="container my-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold text-success">Módulos del Sistema</h2>
    <p class="text-muted">Acceda a las herramientas según su rol asignado</p>
  </div>

  <div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center p-4">
          <i class="fa-solid fa-cash-register fa-3x text-success mb-3"></i>
          <h5 class="card-title fw-bold">Ventas</h5>
          <p class="card-text text-muted small">Registro de pedidos y facturación rápida para clientes.</p>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center p-4">
          <i class="fa-solid fa-boxes-stacked fa-3x text-success mb-3"></i>
          <h5 class="card-title fw-bold">Inventario</h5>
          <p class="card-text text-muted small">Control de stock de insumos y actualización de productos.</p>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body text-center p-4">
          <i class="fa-solid fa-cart-shopping fa-3x text-success mb-3"></i>
          <h5 class="card-title fw-bold">Compras</h5>
          <p class="card-text text-muted small">Gestión de proveedores y entrada de nueva mercancía.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="text-center text-light py-4" style="background: linear-gradient(90deg, #1a6b4f, #0f3d2e);">
  <div class="container">
    <p class="mb-1 fw-semibold">© 2025 Fuego Verde · Panel de Control</p>
  </div>
</footer>

</body>