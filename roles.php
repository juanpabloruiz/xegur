<?php require_once 'conn.php' ?>

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
        header('Location: perfiles.php');
        exit;
    endif;

?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="text" name="title" value="<?= $row['title'] ?>">
        <input type="submit" name="update" value="Actualizar">
    </form>

<?php else: ?>

    <form method="POST">
        <input type="text" name="title" placeholder="Perfil">
        <input type="submit" name="insert" value="Insertar">
    </form>

<?php endif ?>

<table>

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

<?php

// Insertar registro
if (isset($_POST['insert'])):
    $title = $_POST['title'];
    $stmt = $conn->prepare("INSERT INTO roles (title) VALUES (?)");
    $stmt->bind_param('s', $title);
    $stmt->execute();
    $stmt->close();
    header('Location: perfiles.php');
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
    header('Location: perfiles.php');
    exit;
endif;

?>