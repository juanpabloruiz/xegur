<?php
// ===============================
// Inicialización
// ===============================
require_once 'conexion.php';
require_once 'cabecera.php';
require_once 'menu.php';

// ===============================
// Validar sesión
// ===============================
if (!isset($_SESSION['id_usuario'], $_SESSION['id_perfil'])) {
    header("Location: ./");
    exit;
}

// ===============================
// Validar parámetro seccion
// ===============================
if (!isset($_GET['seccion'])) {
    echo "<p>Sección inválida</p>";
    require_once 'pie.php';
    exit;
}

$slug = $_GET['seccion'];

// ===============================
// Buscar sección (perfil)
// ===============================
$sentencia = $conexion->prepare("SELECT id, titulo, publico FROM perfiles WHERE slug = ? LIMIT 1");
$sentencia->bind_param("s", $slug);
$sentencia->execute();
$resultado = $sentencia->get_result();

$seccion = $resultado->fetch_assoc();

if (!$seccion) {
    echo "<p>La sección no existe</p>";
    require_once 'pie.php';
    exit;
}

$idSeccion = (int) $seccion['id'];

// ===============================
// Seguridad por visibilidad
// ===============================
$esAdmin = ($_SESSION['id_perfil'] == 3); // ID del perfil administrador

if (!$esAdmin && $seccion['publico'] == 0) {
    echo "<p>Acceso restringido</p>";
    require_once 'pie.php';
    exit;
}

?>

<main class="container-fluid my-3">

    <?php

    // ===============================
    // Traer usuarios del perfil
    // ===============================
    $sentencia_usuarios = $conexion->prepare("SELECT id, foto, apellidos, nombres, correo FROM usuarios WHERE id_perfil = ? ORDER BY apellidos, nombres");
    $sentencia_usuarios->bind_param("i", $idSeccion);
    $sentencia_usuarios->execute();
    $usuarios = $sentencia_usuarios->get_result();

    // ===============================
    // Mostrar usuarios
    // ===============================
    if ($usuarios->num_rows > 0): ?>


        <div class="row">
            <?php while ($campo = $usuarios->fetch_assoc()): ?>
                <div class="col-md-2">
                    <div class="card">
                        <picture class="ratio ratio-1x1 rounded overflow-hidden">
                            <source srcset="/fotos/<?= $campo['foto'] ?>" type="image/webp">
                            <img src="/fotos/<?= $campo['foto'] ?>" class="img-zoom" alt="Logotipo">
                        </picture>
                        <div class="card-body">
                            <?= htmlspecialchars($campo['apellidos']) ?>
                            <?= htmlspecialchars($campo['nombres']) ?>
                            <?= htmlspecialchars($campo['correo']) ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

</main>




<?php else: ?>

    <p>No hay usuarios cargados en esta sección.</p>

<?php
    endif;


    require_once 'pie.php';
