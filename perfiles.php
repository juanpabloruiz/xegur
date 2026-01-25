<?php require_once 'conn.php' ?>

<?php

// Editar registro
if (isset($_GET['edit'])):
    $id = (int) $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM perfiles WHERE id = ?");
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
        <input type="text" name="perfil" value="<?= $row['perfil'] ?>">
        <input type="submit" name="update" value="Actualizar">
    </form>

<?php else: ?>

    <form method="POST">
        <input type="text" name="perfil" placeholder="Perfil">
        <input type="submit" name="insert" value="Insertar">
    </form>

<?php endif ?>

<table>

    <thead>
        <tr>
            <th>PERFIL</th>
            <th>FECHA</th>
        </tr>
    </thead>

    <?php
    $query = $conn->query("SELECT * FROM perfiles");
    while ($row = $query->fetch_assoc()):
    ?>

        <tbody>
            <tr>
                <td onclick="window.location='?edit=<?= $row['id'] ?>'"><?= htmlspecialchars($row['perfil']) ?></td>
                <td onclick="window.location='?edit=<?= $row['id'] ?>'"><?= date('d/m/Y ⏰ H:i', strtotime($row['fecha'])) ?></td>
            </tr>
        </tbody>

    <?php endwhile ?>

</table>

<?php

// Insertar registro
if (isset($_POST['insert'])):
    $perfil = $_POST['perfil'];
    $stmt = $conn->prepare("INSERT INTO perfiles (perfil) VALUES (?)");
    $stmt->bind_param('s', $perfil);
    $stmt->execute();
    $stmt->close();
    header('Location: perfiles.php');
    exit;
endif;

// Actualizar registro
if (isset($_POST['update'])):
    $id = $_POST['id'];
    $perfil = $_POST['perfil'];
    $stmt = $conn->prepare("UPDATE perfiles SET perfil = ? WHERE id = ?");
    $stmt->bind_param('si', $perfil, $id);
    $stmt->execute();
    $stmt->close();
    header('Location: perfiles.php');
    exit;
endif;

?>