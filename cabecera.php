<?php require_once 'conexion.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">

</head>

<body data-bs-theme="dark">

    <?php $pagina = basename($_SERVER['PHP_SELF']); ?>

    <!-- Menú -->
    <nav class="navbar bg-dark navbar-expand-lg border-bottom" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Xegur</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pagina == 'perfiles.php') ? 'active' : '' ?>" href="perfiles.php">Perfiles</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($pagina == 'usuarios.php') ? 'active' : '' ?>" href="usuarios.php">Usuarios</a></li>
                </ul>
            </div>
        </div>
    </nav>