<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bd_peluqueria';

$conn = new mysqli($servername, $username, $password, $dbname);


$conn->set_charset("utf8mb4");

// Verificar si la conexión falló (lo hará aquí si el nombre de la BD es incorrecto).
if ($conn->connect_error) {
    
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
?>