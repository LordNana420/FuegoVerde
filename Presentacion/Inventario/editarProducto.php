<?php 
if (session_status() == PHP_SESSION_NONE) session_start();

// Solo admins o empleados internos pueden editar
if(!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['admin','empleadoInt'])){
    header('Location: ../../index.php');
    exit();
}

require_once(__DIR__ . '/../../Logica/Inventario.php');

$mensaje = "";

// Obtener ID del producto desde la URL
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('Location: index.php?pid=' . base64_encode('Presentacion/Inventario/inventario.php'));
    exit();
}

$idProducto = intval($_GET['id']);

// Crear objeto Inventario con el ID
$inventarioObj = new Inventario();
$inventarioObj->setId($idProducto);

// Cargar datos del producto
$productoObj = $inventarioObj->consultarPorId();

if(!$productoObj){
    $mensaje = "Producto no encontrado.";
}

// Procesar formulario de actualización
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    if($nombre !== "" && $precio >= 0 && $cantidad >= 0){
        // Asignar valores al objeto y actualizar
        $inventarioObj->setProducto($nombre);
        $inventarioObj->setPrecio($precio);
        $inventarioObj->setCantidad($cantidad);
        $inventarioObj->editar();
        $mensaje = "Producto actualizado correctamente.";

        // Recargar datos actualizados
        $productoObj = $inventarioObj->consultarPorId();
    } else {
        $mensaje = "Por favor, completa todos los campos correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto - Fuego Verde</title>
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
                    <i class="fas fa-edit me-2"></i> Editar Producto
                </div>
                <div class="card-body">

                    <?php if($mensaje != ""): ?>
                        <div class="alert alert-info"><?php echo $mensaje; ?></div>
                    <?php endif; ?>

                    <?php if($productoObj): ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required value="<?php echo htmlspecialchars($productoObj['nombre']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" step="0.01" name="precio" id="precio" class="form-control" required value="<?php echo $productoObj['precio']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad en Stock</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" required value="<?php echo $productoObj['cantidad_stock']; ?>">
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Actualizar Producto
                                </button>

                                <a href="index.php?pid=<?php echo base64_encode('Presentacion/Inventario/inventario.php'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </form>
                    <?php else: ?>
                        <a href="index.php?pid=<?php echo base64_encode('Presentacion/Inventario/inventario.php'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
