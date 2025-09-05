<?php
include("conexion.php"); // Incluir la conexión existente en lugar de crear una nueva

// Verifica si los datos existen antes de usarlos
if (isset($_POST['Correo']) && isset($_POST['Contrasena'])) {
    $correo = $_POST['Correo'];
    $pass = $_POST['Contrasena'];

    // Cambia 'correo' por el nombre real de la columna en tu tabla
    $sql = "SELECT * FROM usuario WHERE correo = '$correo' AND Contrasena = '$pass'";
    // Usar la conexión existente $conn en lugar de crear una nueva
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        header("Location: index.html");
        exit();
    } else {
        echo "<h1>Usuario o contraseña incorrectos</h1>";
    }
} else {
    echo "<h1>Por favor complete todos los campos</h1>";
}

$conn->close();
?>