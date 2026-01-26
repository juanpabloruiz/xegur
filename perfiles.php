<?php require_once 'conexion.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfiles</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">

</head>

<body data-bs-theme="dark">

    <!-- Menú -->
    <nav class="navbar bg-dark navbar-expand-lg border-bottom" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Xegur</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="perfiles.php">Perfiles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Usuarios</a>
                    </li>
            </div>
        </div>
    </nav>

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

            <!-- Form Edit -->
            <form method="POST" class="d-flex flex-column flex-md-row gap-2 mb-3">
                <input type="hidden" name="id" value="<?= $campo['id'] ?>">
                <input type="text" name="titulo" class="form-control" value="<?= $campo['titulo'] ?>">
                <input type="text" name="descripcion" class="form-control" placeholder="Descripción..." value="<?= $campo['descripcion'] ?>">
                <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary">
            </form>

        <?php else: ?>

            <!-- Form Insert -->
            <form method="POST" class="d-flex flex-column flex-md-row gap-2 mb-3">
                <input type="text" name="titulo" class="form-control" placeholder="Perfil">
                <input type="text" name="descripcion" class="form-control" placeholder="Descripción...">
                <input type="submit" name="insertar" value="Insertar" class="btn btn-primary">
            </form>

        <?php endif ?>

        <!-- Table to display records -->
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
                $consulta = $conexion->query("SELECT * FROM perfiles");
                while ($campo = $consulta->fetch_assoc()):
                ?>

                    <tbody>
                        <tr>
                            <td onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($campo['titulo']) ?></td>
                            <td onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($campo['descripcion'] ?? '') ?></td>
                            <td class="text-center" onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;"><?= date('d/m/Y ⏰ H:i', strtotime($campo['agregado'])) ?></td>
                            <td class="text-center" onclick="window.location='?editar=<?= $campo['id'] ?>'" style="cursor: pointer;"><?= $campo['modificado'] ? date('d/m/Y ⏰ H:i', strtotime($campo['modificado'])) : '—' ?></td>
                            <td class="text-center"><a href="?eliminar=<?= $campo['id'] ?>" onclick="return confirm('¿Eliminar este registro?');" title="Eliminar">🗑️</a></td>
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
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $sentencia = $conexion->prepare("INSERT INTO perfiles (titulo, descripcion) VALUES (?, ?)");
    $sentencia->bind_param('ss', $titulo, $content);
    $sentencia->execute();
    $sentencia->close();
    echo '<script>window.location="perfiles.php"</script>';
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

// Delete registro
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