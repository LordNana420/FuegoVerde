<?php
$id = $_SESSION["id"];
if ($_SESSION["rol"] != "empleadoVend") {
    header('Location: ?pid=' . base64_encode("noAutorizado.php"));
}
$empleadoVend = new EmpleadoVend($id);
$empleadoVend->consultarPorId();
?>
<body>
<?php include 'presentacion/menu.php'; ?>
</body>