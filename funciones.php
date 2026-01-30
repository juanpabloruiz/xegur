<?php

// Función para mejorar títulos
function generarSlug(string $texto): string
{
    // Pasar a minúsculas
    $texto = mb_strtolower($texto, 'UTF-8');

    // Reemplazos manuales (ñ primero)
    $reemplazos = [
        'á' => 'a',
        'é' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ú' => 'u',
        'à' => 'a',
        'è' => 'e',
        'ì' => 'i',
        'ò' => 'o',
        'ù' => 'u',
        'ä' => 'a',
        'ë' => 'e',
        'ï' => 'i',
        'ö' => 'o',
        'ü' => 'u',
        'ñ' => 'n'
    ];
    $texto = strtr($texto, $reemplazos);

    // Quitar todo lo que no sea letras, números o espacios
    $texto = preg_replace('/[^a-z0-9\s-]/', '', $texto);

    // Espacios y guiones múltiples → un solo guión
    $texto = preg_replace('/[\s-]+/', '-', trim($texto));

    return $texto;
}

// Función para crear títulos dinámicos
function tituloPagina(): string
{
    // 1️⃣ Si estamos en secciones.php con slug válido
    if (
        basename($_SERVER['SCRIPT_NAME']) === 'secciones.php'
        && isset($_GET['seccion'])
    ) {
        return ucfirst($_GET['seccion']);
    }

    // 2️⃣ Páginas fijas
    $mapa = [
        'index.php'    => 'Inicio',
        'panel.php'    => 'Panel',
        'usuarios.php' => 'Usuarios',
        'perfiles.php' => 'Perfiles',
        'login.php'    => 'Iniciar sesión',
    ];

    $archivo = basename($_SERVER['SCRIPT_NAME']);

    return $mapa[$archivo] ?? 'Xegur';
}

