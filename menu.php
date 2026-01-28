    <?php

    $pagina = basename($_SERVER['PHP_SELF']);

    $idPerfil = $_SESSION['id_perfil'];
    $esAdmin  = ($idPerfil == 1);

    if ($esAdmin) {
        $consulta = "SELECT * FROM perfiles ORDER BY nombre";
    } else {
        $consulta = "SELECT * FROM perfiles WHERE publico = 1 ORDER BY nombre";
    }

    $resultado = $conexion->query($consulta);

    while ($campo = $resultado->fetch_assoc()):
    ?>

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
                        <a href="<?= strtolower($row['nombre']) ?>.php" class="btn btn-outline-light">
                            <?= $row['nombre'] ?>
                        </a>
                    <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </nav>