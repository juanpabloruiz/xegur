<?php
require_once 'conexion.php';
require_once 'funciones.php';
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
    $sentencia_usuarios = $conexion->prepare("SELECT 
    u.id,
    u.foto,
    u.apellidos,
    u.nombres,
    u.correo,
    u.id_perfil,
    p.titulo AS perfil
FROM usuarios u
LEFT JOIN perfiles p ON u.id_perfil = p.id
WHERE u.id_perfil = ?
ORDER BY u.apellidos, u.nombres
");
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#usuario<?= $campo['id'] ?>" data-id="<?= $campo['id'] ?>">
                        <div class="card h-100">
                            <picture class="ratio ratio-1x1 rounded overflow-hidden">
                                <source srcset="/fotos/<?= $campo['foto'] ?>" type="image/webp">
                                <img src="/fotos/<?= $campo['foto'] ?>" class="img-zoom" alt="Logotipo">
                            </picture>
                            <div class="card-body">
                                <?= htmlspecialchars($campo['apellidos']) ?>, <?= htmlspecialchars($campo['nombres']) ?>
                                <?= htmlspecialchars($campo['correo']) ?>

                                <div class="modal fade" id="usuario<?= $campo['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= htmlspecialchars($campo['apellidos']) ?> , <?= htmlspecialchars($campo['nombres']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div id="modalContenido">

                                                    <?= htmlspecialchars($campo['perfil']) ?? 'Sin perfil asignado' ?>


                                                    <form method="POST">
                                                        <input type="hidden" name="entrada" value="E">
                                                        <input type="submit" name="E" value="Entrada">
                                                    </form>

                                                    <form method="POST">
                                                        <input type="hidden" name="salida" value="S">
                                                        <input type="submit" name="S" value="Salida">
                                                    </form>

                                                    <?php
                                                    if (isset($_POST['E'])) {
                                                        $entrada = $_POST['entrada'];
                                                        $sentencia = $conexion->prepare("INSERT INTO movimientos (registro, id_usuario) VALUES (?, ?)");
                                                        $sentencia->bind_param('si', $entrada, $id_usuario);
                                                        $sentencia->execute();
                                                        $sentencia->close();
                                                    }
                                                    ?>

                                                    <!-- Mostrar entradas y salidas -->
                                                    <?php
                                                    $idUsuario = $campo['id'];

                                                    $consulta = $conexion->prepare("
                                                        SELECT m.registro, m.agregado
                                                        FROM movimientos m
                                                        WHERE m.id_usuario = ?
                                                        ORDER BY m.agregado DESC
                                                    ");
                                                    $consulta->bind_param("i", $idUsuario);
                                                    $consulta->execute();
                                                    $resultado = $consulta->get_result();
                                                    ?>
                                                    <?php if ($resultado->num_rows > 0): ?>
                                                        <ul class="list-group">
                                                            <?php while ($mov = $resultado->fetch_assoc()): ?>
                                                                <li class="list-group-item d-flex justify-content-between">
                                                                    <span>
                                                                        <?= $mov['registro'] === 'E' ? 'Entrada' : 'Salida' ?>
                                                                    </span>
                                                                    <small class="text-muted">
                                                                        <?= date('d/m/Y H:i', strtotime($mov['agregado'])) ?>
                                                                    </small>
                                                                </li>
                                                            <?php endwhile; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        <p class="text-muted">Sin movimientos registrados</p>
                                                    <?php endif; ?>





                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>

</main>




<?php else: ?>

    <p>No hay usuarios cargados en esta sección.</p>

<?php
    endif;
?>





<?php require_once 'pie.php';
