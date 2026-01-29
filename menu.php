<?php
$pagina = basename($_SERVER['PHP_SELF']);

$idPerfil = $_SESSION['id_perfil'];
$esAdmin  = ($idPerfil == 3);

if ($esAdmin) {
    $consulta = "SELECT * FROM perfiles ORDER BY titulo";
} else {
    $consulta = "SELECT * FROM perfiles WHERE publico = 1 ORDER BY titulo";
}

$resultado = $conexion->query($consulta);
?>

<nav class="navbar bg-dark navbar-expand-lg border-bottom" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="panel.php">Xegur</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- LINKS SOLO ADMIN -->
                <?php if ($esAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pagina == 'perfiles.php') ? 'active' : '' ?>"
                            href="perfiles.php">Perfiles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($pagina == 'usuarios.php') ? 'active' : '' ?>"
                            href="usuarios.php">Usuarios</a>
                    </li>
                <?php endif; ?>

                <!-- LINKS DINÁMICOS -->
                <?php while ($campo = $resultado->fetch_assoc()): ?>
                    <li class="nav-item">
                        <a class="nav-link 
                    <?= ($pagina == 'secciones.php' && isset($_GET['id']) && $_GET['id'] == $campo['id'])
                        ? 'active' : '' ?>"
                            href="secciones.php?id=<?= $campo['id'] ?>">
                            <?= $campo['titulo'] ?>
                        </a>
                    </li>
                <?php endwhile; ?>

            </ul>
        </div>

    </div>
</nav>