<?php

require_once 'conexion.php';
require_once 'cabecera.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo']);
    $clave  = $_POST['clave'];

    $sentencia = $conexion->prepare("SELECT id, clave, id_perfil FROM usuarios WHERE correo = ? LIMIT 1");
    $sentencia->bind_param("s", $correo);
    $sentencia->execute();
    $resultado = $sentencia->get_result();

    if ($campo = $resultado->fetch_assoc()) {

        if (password_verify($clave, $campo['clave'])) {

            // LOGIN OK
            $_SESSION['id_usuario'] = $campo['id'];
            $_SESSION['id_perfil']  = $campo['id_perfil'];

            header("Location: panel.php");
            exit;
        } else {
            $error = "Credenciales incorrectas";
        }
    } else {
        $error = "Credenciales incorrectas";
    }
}

?>

<main class="min-vh-100 d-flex align-items-center">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-4">

                <picture class="">
                    <source srcset="img/logo22.webp" type="image/webp">
                    <img src="img/logo22.png" class="img-fluid mx-auto d-block" fetchpriority=high height="100%" width="500" alt="Logotipo">
                </picture>

                <form method="post">

                    <div class="mb-3">
                        <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
                    </div>

                    <div class="mb-3">
                        <input type="password" name="clave" class="form-control" placeholder="Contraseña" required>
                    </div>
                    
                    <div class="mb-3">
                        <input type="submit" name="ingreso" value="Ingresar" class="btn btn-primary w-100">
                    </div>

                </form>

            </div>

        </div>

</main>
