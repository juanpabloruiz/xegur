<?php require_once 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body data-bs-theme="dark">

    <h1>Usuarios</h1>

    <table>
        <tr>
            <th>APELLIDO</th>
            <th>NOMBRE</th>
            <th>CORREO</th>
            <th>INGRESO</th>
            <th>EDITADO</th>
        </tr>
        <?php
        $consulta = $conxion->query("SELECT * FROM usuarios ORDER BY apellido ASC");
        while ($campo = $consulta->fetch_assoc()):
        ?>
        <tr>
            <td><?= $campo['apellido'] ?></td>
            <td><?= $campo['nombre'] ?></td>
            <td><?= $campo['correo'] ?></td>
            <td><?= $campo['ingreso'] ?></td>
            <td><?= $campo['editado'] ?></td>
        </tr>
        <?php endwhile ?>
    </table>

</body>

</html>