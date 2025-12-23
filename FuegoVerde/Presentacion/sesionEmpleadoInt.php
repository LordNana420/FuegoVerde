<?php
$id = $_SESSION["id"];
if ($_SESSION["rol"] != "empleadoInt") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}
$empleadoInv = new EmpleadoInv($id);
$empleadoInv->consultarPorId();
?>
<body>
<?php include 'presentacion/menu.php'; ?>
</body>