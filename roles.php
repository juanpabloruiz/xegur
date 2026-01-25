<?php require_once 'conn.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfiles</title>

    <!-- Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body>

    <main class="container-fluid my-3">

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
                header('Location: roles.php');
                exit;
            endif;

        ?>

            <!-- Form Insert -->
            <form method="POST">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="text" name="title" class="form-control" value="<?= $row['title'] ?>">
                <input type="submit" name="update" value="Actualizar" class="btn btn-primary">
            </form>

        <?php else: ?>

            <!-- Form Update -->
            <form method="POST">
                <input type="text" name="title" class="form-control" placeholder="Perfil">
                <input type="submit" name="insert" value="Insertar" class="btn btn-primary">
            </form>

        <?php endif ?>

        <!-- Table to display records -->
        <div class="table-responsive">
            
            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>TÍTULO</th>
                        <th>CREADO</th>
                    </tr>
                </thead>

                <?php
                $query = $conn->query("SELECT * FROM roles");
                while ($row = $query->fetch_assoc()):
                ?>

                    <tbody>
                        <tr>
                            <td onclick="window.location='?edit=<?= $row['id'] ?>'"><?= htmlspecialchars($row['title']) ?></td>
                            <td onclick="window.location='?edit=<?= $row['id'] ?>'"><?= date('d/m/Y ⏰ H:i', strtotime($row['created_at'])) ?></td>
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
    $stmt = $conn->prepare("INSERT INTO roles (title) VALUES (?)");
    $stmt->bind_param('s', $title);
    $stmt->execute();
    $stmt->close();
    header('Location: roles.php');
    exit;
endif;

// Actualizar registro
if (isset($_POST['update'])):
    $id = $_POST['id'];
    $title = $_POST['title'];
    $stmt = $conn->prepare("UPDATE roles SET title = ? WHERE id = ?");
    $stmt->bind_param('si', $title, $id);
    $stmt->execute();
    $stmt->close();
    header('Location: roles.php');
    exit;
endif;

?>