<?php

require_once 'conexion.php';
require_once 'funciones.php';

// Insertar registro
if (isset($_POST['insertar'])):
    $titulo = $_POST['titulo'];
    $slug = generarSlug($titulo);
    $descripcion = $_POST['descripcion'];
    $sentencia = $conexion->prepare("INSERT INTO perfiles (titulo, slug, descripcion) VALUES (?, ?)");
    $sentencia->bind_param('sss', $titulo, $slug, $descripcion);
    $sentencia->execute();
    $sentencia->close();
    header("Location: perfiles.php");
    exit;
endif;

// Actualizar registro
if (isset($_POST['actualizar'])):
    $id = (int) $_POST['id'];
    $titulo = $_POST['titulo'];
    $slug = generarSlug($titulo);
    $descripcion = $_POST['descripcion'];
    $sentencia = $conexion->prepare("UPDATE perfiles SET titulo = ?, slug= ?, descripcion = ? WHERE id = ?");
    $sentencia->bind_param('sssi', $titulo, $slug, $descripcion, $id);
    $sentencia->execute();
    $sentencia->close();
    header("Location: perfiles.php");
    exit;
endif;

// Eliminar registro
if (isset($_POST['eliminar'])):
    $id = (int) $_POST['eliminar'];
    $sentencia = $conexion->prepare("DELETE FROM perfiles WHERE id = ?");
    $sentencia->bind_param('i', $id);
    $sentencia->execute();
    $sentencia->close();
    header("Location: perfiles.php");
    exit;
endif;

?>

<!-- Cabecera -->
<?php require_once 'cabecera.php'; ?>

<!-- Menú -->
<?php require_once 'menu.php'; ?>

<main class="container my-3">

    <?php

    // Editar registro
    if (isset($_GET['editar'])):
        $id = (int) $_GET['editar'];
        $sentencia = $conexion->prepare("SELECT * FROM perfiles WHERE id = ?");
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $campo = $resultado->fetch_assoc();
        if (!$campo):
            echo '<script>window.location="perfiles.php"</script>';
            exit;
        endif;

    ?>

        <!-- Formulario de edición -->
        <form method="POST" class="d-flex flex-column flex-md-row gap-2 mb-3">
            <input type="hidden" name="id" value="<?= $campo['id'] ?>">
            <input type="text" name="titulo" class="form-control" value="<?= $campo['titulo'] ?>">
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción..." value="<?= $campo['descripcion'] ?>">
            <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary">
        </form>

    <?php else: ?>

        <!-- Formulario de inserción -->
        <form method="POST" class="d-flex flex-column flex-md-row gap-2 mb-3">
            <input type="text" name="titulo" class="form-control" placeholder="Perfil">
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción...">
            <input type="submit" name="insertar" value="Insertar" class="btn btn-primary">
        </form>

    <?php endif ?>

    <!-- Tabla para mostrar registros -->
    <div class="table-responsive">

        <table class="table table-hover">

            <thead>
                <tr>
                    <th class="text-center">TÍTULO</th>
                    <th class="text-center">DESCRIPCIÓN</th>
                    <th class="text-center">AGREGADO</th>
                    <th class="text-center">MODIFICADO</th>
                    <th class="text-center">ELIMINAR</th>
                </tr>
            </thead>

            <?php
            $consulta = $conexion->query("SELECT p.id, p.titulo, p.agregado, p.modificado, COUNT(u.id) AS total_usuarios FROM perfiles p LEFT JOIN usuarios u ON u.id_perfil = p.id GROUP BY p.id, p.titulo");
            while ($campo = $consulta->fetch_assoc()):
            ?>

                <tbody>
                    <tr>
                        <td onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($campo['titulo']) ?></td>
                        <td onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($campo['descripcion'] ?? '') ?></td>

                        <td class="text-center" onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;">
                            <?= date('d/m/Y', strtotime($campo['agregado'])) ?>
                            <i class="fa-solid fa-clock"></i>
                            <?= date('H:i', strtotime($campo['agregado'])) ?>
                        </td>

                        <td class="text-center" onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;">

                            <?php if (!empty($campo['modificado'])): ?>
                                <?= date('d/m/Y', strtotime($campo['modificado'])) ?>
                                <i class="fa-solid fa-clock"></i>
                                <?= date('H:i', strtotime($campo['modificado'])) ?>
                            <?php else: ?>
                                —
                            <?php endif; ?>

                        </td>

                        <td class="text-center">
                            <?php if ($campo['total_usuarios'] == 0): ?>
                                <form method="post" style="display:inline">
                                    <input type="hidden" name="eliminar" value="<?= $campo['id'] ?>">
                                    <button type="submit" class="btn btn-link p-0" onclick="return confirm('¿Eliminar este perfil?');" title="Eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <i class="fa-solid fa-lock text-secondary" title="No se puede eliminar: hay usuarios asociados"></i>
                            <?php endif; ?>
                        </td>


                    </tr>
                </tbody>

            <?php endwhile ?>

        </table>

    </div>

</main>

<!-- Pié de página -->
<?php require_once 'pie.php'; ?>