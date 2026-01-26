<?php
session_start();

// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cambiar datos del servidor
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');
$conexion->set_charset('utf8mb4');
