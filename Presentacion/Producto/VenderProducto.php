<?php
require_once __DIR__ . '/../../Logica/Producto.php';
require_once __DIR__ . '/../../Logica/Admin.php';

// Validar que la sesión exista
if (!isset($_SESSION["id"])) {
    header('Location: index.php');
    exit();
}

$producto = new Producto();
$productos = $producto->consultar();

$id = $_SESSION["id"];
$rol = $_SESSION["rol"];

// AJUSTE DE SEGURIDAD: Permitir admin O empleadoVend
if ($rol != "admin" && $rol != "empleadoVend") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
    exit(); // Importante para evitar bucles infinitos
}

// Cargar datos del usuario actual
$admin = new Admin($id);
$admin->consultarPorId();
?>
<body>
    <?php include 'presentacion/menu.php'; ?>
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h3 class="mb-0">Inventario Fuego Verde</h3>
                    </div>
                    <div class="card-body">
                        <?php if (count($productos) == 0) {
                            echo "<div class='alert alert-warning' role='alert'>No hay productos registrados.</div>";
                        } else { ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Precio Venta</th>
                                        <th scope="col">Stock Disponible</th>
                                        <?php if ($rol == "admin") { echo "<th>Acciones</th>"; } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($productos as $p) {
                                    echo "<tr>";
                                    echo "<td>" . $p->getId() . "</td>";
                                    echo "<td>" . $p->getNombre() . "</td>";
                                    echo "<td>$" . number_format($p->getPrecio(), 0, ',', '.') . "</td>";
                                    
                                    // Alerta visual de stock bajo
                                    $colorStock = ($p->getCantidad_Stock() < 5) ? "text-danger fw-bold" : "";
                                    echo "<td class='$colorStock'>" . $p->getCantidad_Stock() . " unidades</td>";
                                    
                                    if ($rol == "admin") {
                                        echo "<td>
                                                <a href='#' class='btn btn-sm btn-outline-primary'><i class='fas fa-edit'></i></a>
                                              </td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>