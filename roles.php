<?php require_once 'conn.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfiles</title>

    <!-- Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">

</head>

<body data-bs-theme="dark">

    <main class="container my-3">

        <?php

        // Editar registro
        if (isset($_GET['edit'])):
            $id = (int) $_GET['edit'];
            $stmt = $conn->prepare("SELECT * FROM roles WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if (!$row):
                echo '<script>window.location="roles.php"</script>';
                exit;
            endif;

        ?>

            <!-- Form Edit -->
            <form method="POST" class="d-flex flex-column flex-md-row gap-2 mb-3">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="text" name="title" class="form-control" value="<?= $row['title'] ?>">
                <input type="text" name="content" class="form-control" placeholder="Descripción..." value="<?= $row['content'] ?>">
                <input type="submit" name="update" value="Actualizar" class="btn btn-primary">
            </form>

        <?php else: ?>

            <!-- Form Insert -->
            <form method="POST" class="d-flex flex-column flex-md-row gap-2 mb-3">
                <input type="text" name="title" class="form-control" placeholder="Perfil">
                <input type="text" name="content" class="form-control" placeholder="Contenido">
                <input type="submit" name="insert" value="Insertar" class="btn btn-primary">
            </form>

        <?php endif ?>

        <!-- Table to display records -->
        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th class="text-center">TÍTULO</th>
                        <th class="text-center">CONTENIDO</th>
                        <th class="text-center">CREADO</th>
                        <th class="text-center">MODIFICADO</th>
                        <th class="text-center">ELIMINAR</th>
                    </tr>
                </thead>

                <?php
                $query = $conn->query("SELECT * FROM roles");
                while ($row = $query->fetch_assoc()):
                ?>

                    <tbody>
                        <tr>
                            <td onclick="window.location='?edit=<?= $row['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($row['title']) ?></td>
                            <td onclick="window.location='?edit=<?= $row['id'] ?>'" style="cursor: pointer;"><?= htmlspecialchars($row['content'] ?? '') ?></td>
                            <td class="text-center" onclick="window.location='?edit=<?= $row['id'] ?>'" style="cursor: pointer;"><?= date('d/m/Y ⏰ H:i', strtotime($row['created_at'])) ?></td>
                            <td class="text-center" onclick="window.location='?edit=<?= $row['id'] ?>'" style="cursor: pointer;"><?= $row['updated_at'] ? date('d/m/Y ⏰ H:i', strtotime($row['updated_at'])) : '—' ?></td>
                            <td class="text-center"><a href="?delete=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este registro?');" title="Eliminar">🗑️</a></td>
                        </tr>
                    </tbody>

                <?php endwhile ?>

            </table>

        </div>

    </main>

    <!-- Scripts -->
    <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php

// Insertar registro
if (isset($_POST['insert'])):
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("INSERT INTO roles (title, content) VALUES (?, ?)");
    $stmt->bind_param('ss', $title, $content);
    $stmt->execute();
    $stmt->close();
    echo '<script>window.location="roles.php"</script>';
    exit;
endif;

// Actualizar registro
if (isset($_POST['update'])):
    $id = (int) $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("UPDATE roles SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param('ssi', $title, $content, $id);
    $stmt->execute();
    $stmt->close();
    echo '<script>window.location="roles.php"</script>';
    exit;
endif;

// Delete registro
if (isset($_GET['delete'])):
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM roles WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo '<script>window.location="roles.php"</script>';
    exit;
endif;

?>