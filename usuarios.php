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
                $consulta = $conexion->query("SELECT * FROM usuarios u LEFT JOIN perfiles p ON u.id_perfil = p.id");
                while ($campo = $consulta->fetch_assoc()):
                ?>

                    <tbody>
                        <tr>
                            
                            <td class="text-center" onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;">
                                <?= htmlspecialchars($campo['apellidos'] . '') ?>, <?= htmlspecialchars($campo['nombres'] ?? '') ?>
                            </td>

                            <td class="text-center" onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($campo['correo'] ?? '') ?></td>
                            <td class="text-center" onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($campo['titulo'] ?? '') ?></td>
                            
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

                            <td class="text-center"><a href="?eliminar=<?= $campo['id'] ?>" onclick="return confirm('¿Eliminar este registro?');" title="Eliminar"><i class="fa-solid fa-trash"></i></a></td>
                        </tr>
                    </tbody>

                <?php endwhile ?>

            </table>

        </div>

    </main>

    <!-- Javascript -->
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php

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
    echo '<script>window.location="usuarios.php"</script>';
    exit;
endif;

// Actualizar registro
if (isset($_POST['actualizar'])):
    $id = (int) $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $sentencia = $conexion->prepare("UPDATE perfiles SET titulo = ?, descripcion = ? WHERE id = ?");
    $sentencia->bind_param('ssi', $titulo, $descripcion, $id);
    $sentencia->execute();
    $sentencia->close();
    echo '<script>window.location="perfiles.php"</script>';
    exit;
endif;

// Eliminar registro
if (isset($_GET['eliminar'])):
    $id = (int) $_GET['eliminar'];
    $sentencia = $conexion->prepare("DELETE FROM perfiles WHERE id = ?");
    $sentencia->bind_param('i', $id);
    $sentencia->execute();
    $sentencia->close();
    echo '<script>window.location="perfiles.php"</script>';
    exit;
endif;

?>