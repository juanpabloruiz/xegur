<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body data-bs-theme="dark">

    <h1>Usuarios</h1>

    <main class="container-fluid">

        <form method="POST">
            <?php
            if (isset($_POST['insertar'])):
                $apellidos = $_POST['apellidos'];
                $nombres = $_POST['nombres'];
                $correo = $_POST['correo'];
                $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
                $categoria = $_POST['categoria'];
                $sentencia = $conexion->prepare("INSERT INTO usuarios (apellidos, nombres, correo, clave, categoria) VALUES (?, ?, ?, ?, ?)");
                $sentencia->bind_param('sssss', $apellidos, $nombres, $correo, $clave, $categoria);
                $sentencia->execute();
                $sentencia->close();
                echo 'Usuario agregado';
            endif;
            ?>
            <div class="mb-3">
                <input type="text" name="apellidos" class="form-control" placeholder="Apellido">
            </div>
            <div class="mb-3">
                <input type="text" name="nombres" class="form-control" placeholder="Nombre">
            </div>
            <div class="mb-3">
                <input type="email" name="correo" class="form-control" placeholder="Correo electrónico">
            </div>
            <div class="mb-3">
                <input type="password" name="clave" class="form-control" placeholder="Contraseña">
            </div>
            <div class="mb-3">
                <select name="categoria" class="form-select">
                    <option value="">Seleccionar</option>
                    <option value="Administrador">Administradores</option>
                    <option value="Empleado">Empleados</option>
                    <option value="Senador">Senadores</option>
                    <option value="Diputado">Diputados</option>
                </select>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-auto">
                    <input type="submit" name="insertar" class="btn btn-primary w-100" value="Agregar usuario">
                </div>
            </div>

        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>APELLIDOS</th>
                        <th>NOMBRES</th>
                        <th>CORREO</th>
                        <th>CATEGORIA</th>
                        <th>INGRESO</th>
                        <th>EDITADO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $consulta = $conexion->query("SELECT * FROM usuarios ORDER BY apellidos ASC");
                    while ($campo = $consulta->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($campo['apellidos']) ?></td>
                            <td><?= htmlspecialchars($campo['nombres']) ?></td>
                            <td><?= htmlspecialchars($campo['correo']) ?></td>
                            <td><?= htmlspecialchars($campo['categoria']) ?></td>
                            <td><?= date('d/m/Y', strtotime($campo['ingreso'])) ?></td>
                            <td><?= $campo['editado'] ? date('d/m/Y', strtotime($campo['editado'])) : '' ?></td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </main>

    <!-- Scripts -->
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>