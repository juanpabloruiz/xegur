<?php require_once 'conexion.php'; ?>

<!-- Cabecera -->
<?php require_once 'cabecera.php'; ?>

<!-- Menú -->
<?php require_once 'menu.php'; ?>

<main class="container-fluid">
    
    <?php
    $esAdmin = 3;
    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE id_perfil = ?");
    $sentencia->bind_param('i', $esAdmin);
    $sentencia->execute();
    $resultados = $sentencia->get_result();
    while ($campo = $resultados->fetch_assoc()):
    ?>

    <div class="row">
        <div class="col-md-2"><?= $campo['apellidos'] . ', ' . $campo['nombres'] ?></div>
    </div>

    <?php endwhile ?>
</main>

<!-- Pié de página -->
<?php require_once 'pie.php'; ?>