<?php
if (session_status() == PHP_SESSION_NONE) session_start();

// Solo admins o empleados internos pueden agregar
if(!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin','empleadoInt'])){
    header('Location: ../../index.php');
    exit();
}

require_once(__DIR__ . '/../../Logica/Inventario.php');

$productoObj = new Inventario();
$mensaje = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    if($nombre !== "" && $precio >= 0 && $cantidad >= 0){
        $productoObj->setProducto($nombre);
        $productoObj->setPrecio($precio);
        $productoObj->setCantidad($cantidad);
        $productoObj->agregar();
        $mensaje = "Producto agregado correctamente.";
    } else {
        $mensaje = "Por favor, completa todos los campos correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto - Fuego Verde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2d9b9d9b9.js" crossorigin="anonymous"></script>
</head>
<body>

<?php include_once(__DIR__ . '/../menu.php'); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white fw-bold" style="background-color: #1a6b4f;">
                    <i class="fas fa-boxes me-2"></i> Agregar Producto
                </div>
                <div class="card-body">
                    <?php if($mensaje != ""): ?>
                        <div class="alert alert-info"><?php echo $mensaje; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad en Stock</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Agregar Producto
                            </button>

                            <a href="index.php?pid=<?php echo base64_encode('Presentacion/Inventario/inventario.php'); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
