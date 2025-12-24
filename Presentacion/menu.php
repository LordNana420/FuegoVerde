<?php
// Asegurarse de inicializar variables para evitar errores de "undefined variable"
$admin = null;
$empleadoInt = null;
$empleadoVend = null;

if(isset($_SESSION["rol"])){
    switch($_SESSION["rol"]){
        case "admin":
            $admin = new Admin($_SESSION["id"]);
            $admin->consultarPorId();
            break;
        case "empleadoInt":
            $empleadoInt = new EmpleadoInv($_SESSION["id"]);
            $empleadoInt->consultarPorId();
            break;
        case "empleadoVend":
            $empleadoVend = new EmpleadoVend($_SESSION["id"]);
            $empleadoVend->consultarPorId();
            break;
        default:
            header('Location: index.php');
            exit();
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark shadow" 
     style="background: linear-gradient(90deg, #0f3d2e, #1a6b4f);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            Fuego Verde
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuInterno">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuInterno">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                <li class="nav-item">
                    <a class="nav-link active" href="?pid=<?php echo base64_encode('presentacion/inicio.php')
 ?>">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>

                <?php if ($_SESSION["rol"] == "admin"): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Usuarios</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Registrar Empleado</a></li>
                            <li><a class="dropdown-item" href="#">Listar Usuarios</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Comprar Producto</a></li>
                    <li class="nav-item">

                    <a class="nav-link" href="index.php?pid=<?php echo base64_encode('Presentacion/Producto/VenderProducto.php'); ?>" >Vender</a>
                    </li>
                    <li class="nav-item">
    <a class="nav-link" href="index.php?pid=<?php echo base64_encode('Presentacion/Inventario/inventario.php'); ?>">
        Gestionar Inventario
    </a>
</li>
                <?php elseif ($_SESSION["rol"] == "empleadoVend"): ?>
                    <li class="nav-item"><a class="nav-link" 
   href="index.php?pid=<?php echo base64_encode('Presentacion/Producto/VenderProducto.php'); ?>">
    Vender Productos
</a>
</li>
                    <li class="nav-item"><a class="nav-link" href="#">Mis Ventas del Día</a></li>

                <?php elseif ($_SESSION["rol"] == "empleadoInt"): ?>
                    <li class="nav-item"><a class="nav-link" href="#">Registrar Inventario</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Stock de Insumos</a></li>
                <?php endif; ?>

            </ul>
            
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link text-light fw-semibold">
                        <i class="fas fa-user-circle me-1"></i> 
                        <?php 
                            if($admin) echo $admin->getNombre();
                            elseif($empleadoVend) echo $empleadoVend->getNombre();
                            elseif($empleadoInt) echo $empleadoInt->getNombre();
                        ?> 
                        <span class="badge bg-success ms-1" style="background-color: #1a6b4f !important;">
                            <?php echo ucfirst($_SESSION["rol"]) ?>
                        </span>
                    </span>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-outline-light btn-sm mt-1" href="index.php?salir=1">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>