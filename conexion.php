<?php
// Me conecto a la base de datos Inmobiliaria usando root
$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "Inmobiliaria",
    3307
);

// Compruebo si hay algún error de conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configuro los caracteres para mostrar correctamente las tildes
$conexion->set_charset("utf8mb4");
?>