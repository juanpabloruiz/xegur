<?php

require_once 'conexion.php';
require_once 'cabecera.php';

?>

<form method="post">
    <input type="email" name="correo" placeholder="Correo electrónico" required>
    <input type="password" name="clave" placeholder="Contraseña" required>
    <input type="submit" name="ingreso" value="Ingresar">
</form>
