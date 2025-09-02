<?php

$servername = 'localhost';
$username = 'root';
$password = ''; // Tu contraseña de MySQL, si tienes una.
$dbname = 'bd_peluqueria'; // ¡El nombre corregido, sin tilde!

$conn = new mysqli($servername, $username, $password, $dbname);

// Es una buena práctica establecer el charset para evitar problemas con tildes y eñes.
$conn->set_charset("utf8mb4");

// Verificar si la conexión falló (lo hará aquí si el nombre de la BD es incorrecto).
if ($conn->connect_error) {
    // En un entorno de producción, aquí se registraría el error en un log.
    // Para desarrollo, die() es aceptable para ver el error claramente.
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>