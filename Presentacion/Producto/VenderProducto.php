<?php
require_once __DIR__ . '/../../Logica/Producto.php';
require_once __DIR__ . '/../../Logica/Admin.php';
require_once __DIR__ . '/../../Logica/Venta.php';

/* ========= PROCESAR VENTA ========= */
if (isset($_POST['datosVenta']) && !empty($_POST['datosVenta'])) {

    $carrito = json_decode($_POST['datosVenta'], true);
    $totalVenta = 0;

    foreach ($carrito as $item) {
        $totalVenta += ($item['precio'] * $item['cantidad']);
    }

    $venta = new Venta($_SESSION["id"], $totalVenta);

    if ($venta->registrarVentaMultiple($carrito)) {
        header("Location: index.php?pid=" . $_GET['pid'] . "&msj=exitosa");
        exit();
    }
}

/* ========= SEGURIDAD ========= */
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION["rol"] !== "admin" && $_SESSION["rol"] !== "empleadoVend") {
    header("Location: index.php");
    exit();
}

$producto = new Producto();
$productos = $producto->consultar();

include('Presentacion/menu.php');
?>

<div class="container-fluid mt-5 px-4">

<?php if (isset($_GET['msj']) && $_GET['msj'] === 'exitosa'): ?>
    <div class="alert alert-success alert-dismissible fade show">
        ✔ Venta registrada correctamente
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">

<!-- ================== PRODUCTOS ================== -->
<div class="col-md-7 col-lg-8">
    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold text-success">Productos</h3>
        <input type="text" id="buscador" class="form-control w-50" placeholder="Buscar producto...">
    </div>

    <div class="row" style="max-height:75vh; overflow:auto;">
        <?php foreach ($productos as $p): ?>
        <div class="col-md-4 mb-3 producto-card"
             data-nombre="<?= strtolower($p->getNombre()) ?>">
            <div class="card shadow-sm border-bottom border-success border-3">
                <div class="card-body">
                    <span class="badge <?= $p->getCantidad_Stock() < 5 ? 'bg-danger' : 'bg-dark' ?>">
                        Stock: <?= $p->getCantidad_Stock() ?>
                    </span>

                    <h6 class="mt-2 fw-bold"><?= $p->getNombre() ?></h6>
                    <h5 class="text-success fw-bold">
                        $<?= number_format($p->getPrecio(),0,',','.') ?>
                    </h5>

                    <button class="btn btn-outline-success w-100"
                        onclick='agregarAlTicket(
                            <?= json_encode((string)$p->getId()) ?>,
                            <?= json_encode($p->getNombre()) ?>,
                            <?= json_encode((float)$p->getPrecio()) ?>,
                            <?= json_encode((int)$p->getCantidad_Stock()) ?>
                        )'>
                        ➕ Agregar
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ================== TICKET ================== -->
<div class="col-md-5 col-lg-4">
<div class="card sticky-top shadow" style="top:20px;">
    <div class="card-header bg-dark text-white">
        <strong>Nueva Venta</strong>
    </div>

    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Producto</th>
                    <th class="text-center">Cant.</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="cuerpoTicket"></tbody>
        </table>
    </div>

    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <span>Ítems:</span>
            <span id="totalItems" class="fw-bold">0</span>
        </div>

        <div class="d-flex justify-content-between fw-bold">
            <span>TOTAL:</span>
            <span id="granTotal" class="text-success">$0</span>
        </div>

        <div class="mt-2">
            <label>Paga con:</label>
            <input type="number" id="pagoCliente" class="form-control">
        </div>

        <div class="d-flex justify-content-between mt-2">
            <span>Vueltas:</span>
            <span id="vueltas" class="fw-bold text-primary">$0</span>
        </div>

        <form method="POST" action="index.php?pid=<?= $_GET['pid'] ?>">
            <input type="hidden" name="datosVenta" id="datosVentaInput">
            <button id="btnFinalizar" class="btn btn-success w-100 mt-3" disabled>
                REGISTRAR VENTA
            </button>
        </form>
    </div>
</div>
</div>

</div>
</div>

<script>
let ticket = [];
let totalVenta = 0;

function agregarAlTicket(id, nombre, precio, stock){
    id = String(id);
    let item = ticket.find(p => p.id === id);

    if(item){
        if(item.cantidad < stock){
            item.cantidad++;
        } else {
            alert("No hay más stock disponible");
        }
    } else {
        ticket.push({
            id, nombre,
            precio: Number(precio),
            cantidad: 1,
            stock: stock
        });
    }
    render();
}

function cambiarCantidad(id, cambio){
    const item = ticket.find(p => p.id === id);
    if(!item) return;

    item.cantidad += cambio;

    if(item.cantidad <= 0){
        ticket = ticket.filter(p => p.id !== id);
    } else if(item.cantidad > item.stock){
        item.cantidad = item.stock;
        alert("Stock máximo alcanzado");
    }
    render();
}

function render(){
    const cuerpo = document.getElementById('cuerpoTicket');
    cuerpo.innerHTML = '';
    totalVenta = 0;
    let items = 0;

    ticket.forEach(p => {
        const subtotal = p.precio * p.cantidad;
        totalVenta += subtotal;
        items += p.cantidad;

        cuerpo.innerHTML += `
        <tr>
            <td>${p.nombre}</td>
            <td class="text-center">
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-danger"
                        onclick="cambiarCantidad('${p.id}', -1)">−</button>
                    <span class="btn btn-light">${p.cantidad}</span>
                    <button class="btn btn-outline-success"
                        onclick="cambiarCantidad('${p.id}', 1)">+</button>
                </div>
            </td>
            <td class="fw-bold text-success">
                $${subtotal.toLocaleString('es-CO')}
            </td>
            <td>
                <button class="btn btn-sm btn-outline-danger"
                    onclick="cambiarCantidad('${p.id}', -${p.cantidad})">✕</button>
            </td>
        </tr>`;
    });

    document.getElementById('granTotal').innerText =
        '$' + totalVenta.toLocaleString('es-CO');
    document.getElementById('totalItems').innerText = items;
    document.getElementById('datosVentaInput').value =
        JSON.stringify(ticket);
    document.getElementById('btnFinalizar').disabled = ticket.length === 0;

    calcularVueltas();
}

function calcularVueltas(){
    const pago = Number(document.getElementById('pagoCliente').value) || 0;
    const vueltas = pago - totalVenta;
    document.getElementById('vueltas').innerText =
        '$' + (vueltas > 0 ? vueltas.toLocaleString('es-CO') : 0);
}

document.getElementById('pagoCliente')
    .addEventListener('input', calcularVueltas);

document.getElementById('buscador')
    .addEventListener('input', e => {
        const txt = e.target.value.toLowerCase();
        document.querySelectorAll('.producto-card').forEach(c => {
            c.style.display =
                c.dataset.nombre.includes(txt) ? 'block' : 'none';
        });
    });
</script>
