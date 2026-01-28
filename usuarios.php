<?php

require_once 'conexion.php';

// Insertar registro
if (isset($_POST['insertar'])):
    $apellidos = $_POST['apellidos'];
    $nombres = $_POST['nombres'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
    $id_perfil = $_POST['id_perfil'];
    $sentencia = $conexion->prepare("INSERT INTO usuarios (apellidos, nombres, correo, clave, id_perfil) VALUES (?, ?, ?, ?, ?)");
    $sentencia->bind_param('ssssi', $apellidos, $nombres, $correo, $clave, $id_perfil);
    $sentencia->execute();
    $sentencia->close();
    header("Location: usuarios.php");
    exit;
endif;

// Actualizar registro
if (isset($_POST['actualizar'])):
    $id = (int) $_POST['id'];
    $apellidos = $_POST['apellidos'];
    $nombres = $_POST['nombres'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
    $id_perfil = $_POST['id_perfil'];
    $sentencia = $conexion->prepare("UPDATE usuarios SET apellidos = ?, nombres = ?, correo = ?, clave = ?, id_perfil = ? WHERE id = ?");
    $sentencia->bind_param('ssssii', $apellidos, $nombres, $correo, $clave, $id_perfil, $id);
    $sentencia->execute();
    $sentencia->close();
    header("Location: usuarios.php");
    exit;
endif;

// Eliminar registro
if (isset($_POST['eliminar'])):
    $id = (int) $_POST['eliminar'];
    $sentencia = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $sentencia->bind_param('i', $id);
    $sentencia->execute();
    $sentencia->close();
    header("Location: usuarios.php");
    exit;
endif;

?>

<!-- Cabecera -->
<?php require_once 'cabecera.php'; ?>

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
            <input type="text" name="apellidos" class="form-control" placeholder="Apellidos">
            <input type="text" name="nombres" class="form-control" placeholder="Nombres">
            <input type="text" name="correo" class="form-control" placeholder="Correo electrónico">
            <input type="password" name="clave" class="form-control" placeholder="Contraseña">

            <select name="id_perfil" id="id_perfil" class="form-select" required>
                <option value="" disabled selected>Seleccionar perfil</option>
                <?php
                $consulta = $conexion->query("SELECT id, titulo FROM perfiles ORDER BY titulo");
                while ($campo = $consulta->fetch_assoc()):
                ?>

                    <option value="<?= $campo['id'] ?>"><?= htmlspecialchars($campo['titulo']) ?></option>

                <?php endwhile ?>

            </select>

            <input type="submit" name="insertar" value="Insertar" class="btn btn-primary">
        </form>

    <?php endif ?>

    <!-- Tabla para mostrar registros -->
    <div class="table-responsive">

        <table class="table table-hover">

            <thead>
                <tr>
                    <th class="text-center">USUARIO</th>
                    <th class="text-center">CORREO ELECTRÓNICO</th>
                    <th class="text-center">PERFIL</th>
                    <th class="text-center">AGREGADO</th>
                    <th class="text-center">MODIFICADO</th>
                    <th class="text-center">ELIMINAR</th>
                </tr>
            </thead>

            <?php
            $consulta = $conexion->query("SELECT 
        u.id AS id_usuario,
        u.apellidos,
        u.nombres,
        u.correo,
        u.agregado,
        u.modificado,
        p.titulo
    FROM usuarios u
    LEFT JOIN perfiles p ON u.id_perfil = p.id");
            while ($campo = $consulta->fetch_assoc()):
            ?>

                <tbody>
                    <tr>

                        <td class="text-center" onclick="window.location='?editar=<?= $campo['id_usuario'] ?>'" style="cursor: pointer;">
                            <?= htmlspecialchars($campo['apellidos'] . '') ?>, <?= htmlspecialchars($campo['nombres'] ?? '') ?>
                        </td>

                        <td class="text-center" onclick="window.location='?editar=<?= $campo['id_usuario'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($campo['correo'] ?? '') ?></td>
                        <td class="text-center" onclick="window.location='?editar=<?= $campo['id_usuario'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($campo['titulo'] ?? '') ?></td>

                        <td class="text-center" onclick="window.location='?editar=<?= $campo['id_usuario'] ?>'" style="cursor: pointer;">
                            <?= date('d/m/Y', strtotime($campo['agregado'])) ?>
                            <i class="fa-solid fa-clock"></i>
                            <?= date('H:i', strtotime($campo['agregado'])) ?>
                        </td>

                        <td class="text-center" onclick="window.location='?editar=<?= $campo['id_usuario'] ?>'" style="cursor: pointer;">

                            <?php if (!empty($campo['modificado'])): ?>
                                <?= date('d/m/Y', strtotime($campo['modificado'])) ?>
                                <i class="fa-solid fa-clock"></i>
                                <?= date('H:i', strtotime($campo['modificado'])) ?>
                            <?php else: ?>
                                —
                            <?php endif; ?>

                        </td>

                        <td class="text-center">
                            <form method="post" style="display:inline">
                                <input type="hidden" name="eliminar" value="<?= $campo['id_usuario'] ?>">
                                <button type="submit" class="btn btn-link p-0" onclick="return confirm('¿Eliminar este registro?');" title="Eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                </tbody>

            <?php endwhile ?>

        </table>

    </div>

</main>

<!-- Pié de página -->
<?php require_once 'cabecera.php'; ?>