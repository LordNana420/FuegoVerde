<?php 
require_once ("logica/Persona.php");
require_once ("logica/Admin.php");
require_once ("logica/EmpleadoInv.php");
require_once ("logica/EmpleadoVend.php");

$error = 0;

if(isset($_POST["autenticar"])){
    $usuario = $_POST["correo"]; // Es el valor del input "usuario"
    $clave = $_POST["clave"];

    // 1. Intentar con Admin (Rol 1)
    $admin = new Admin("", "", "", $usuario, $clave);
    if($admin->autenticar() && $admin->getRol() == 1){
        $_SESSION["id"] = $admin->getId();
        $_SESSION["rol"] = "admin";
        header('Location: ?pid=' . base64_encode("Presentacion/sesionAdmin.php"));
        exit();
    }

    // 2. Intentar con Empleado Vendedor (Rol 2)
    $empleadoVent = new EmpleadoVend("", "", "", $usuario, $clave);
    if($empleadoVent->autenticar() && $empleadoVent->getRol() == 2){
        $_SESSION["id"] = $empleadoVent->getId();
        $_SESSION["rol"] = "empleadoVend";
        header('Location: ?pid=' . base64_encode("Presentacion/sesionEmpleadoVend.php"));
        exit();
    }

    // 3. Intentar con Empleado Inventario (Rol 3)
    $empleadoInt = new EmpleadoInv("", "", "", $usuario, $clave);
    if($empleadoInt->autenticar() && $empleadoInt->getRol() == 3){
        $_SESSION["id"] = $empleadoInt->getId();
        $_SESSION["rol"] = "empleadoInt";
        header('Location: ?pid=' . base64_encode("Presentacion/sesionEmpleadoInt.php"));
        exit();
    }

    $error = 1;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Fuego Verde</title>
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
	<div class="container">
		<div class="row mt-5">
			<div class="col-4"></div>
			<div class="col-4">
				<div class="card">
					<div class="card-header">
						<h3>Autenticar</h3>
					</div>
					<div class="card-body">
						<?php 
						if(isset($_POST["registrar"])){
						    echo "<div class='alert alert-success' role='alert'>
                                    Cliente almacenado
                                    </div>";
						}
						?>
						<form method="post" action="?pid=<?php echo base64_encode("Presentacion/autenticar.php")?>">
							<div class="mb-3">
								<input type="text" class="form-control" name="correo"
									placeholder="usuario" required>
							</div>
							<div class="mb-3">
								<input type="password" class="form-control" name="clave"
									placeholder="Clave" required>
							</div>
							<div class="mb-3">
								<button type="submit" class="btn btn-primary" name="autenticar">Autenticar</button>
								<a href="?pid=<?php echo base64_encode("presentacion/cliente/registrarCliente.php") ?>">Registrar</a>
							</div>
						</form>
						<?php
                        if ($error == 1) {
                            echo "<div class='alert alert-danger' role='alert'>
                                    Correo o clave incorrectos
                                    </div>";
                        }else if($error == 2){
                            echo "<div class='alert alert-danger' role='alert'>
                                    Cliente inhabilitado
                                    </div>";
                        }
                        ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>