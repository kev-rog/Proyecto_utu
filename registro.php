<?php
// Conexión a la base de datos
include("conexion.php"); // Asegúrate de que el archivo se llame exactamente "conexion.php"

// Verificar si se presionó el botón de registrar
if (isset($_POST['registrar']) && $_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitización de datos de entrada
    $Correo     = trim($_POST['correo']);
    $Nombre     = trim($_POST['nombre']);
    $Apellido   = trim($_POST['apellido']);
    $Telefono   = trim($_POST['telefono']);
    $Contrasena = trim($_POST['contrasena']);

    // Validar que los campos obligatorios no estén vacíos
    if (
        strlen($Correo) >= 1 &&
        strlen($Nombre) >= 1 &&
        strlen($Apellido) >= 1 &&
        strlen($Contrasena) >= 1
    ) {
        // Consulta para insertar en la tabla Usuario
        $consultaUsuario = "
            INSERT INTO Usuario (Nombre, Apellido, Correo, Contrasena) 
            VALUES ('$Nombre', '$Apellido', '$Correo', '$Contrasena')
        ";
        $resultadoUsuario = mysqli_query($conn, $consultaUsuario);

        if ($resultadoUsuario) {
            // Obtener el ID del usuario recién creado
            $usuarioID = mysqli_insert_id($conn);

            // Consulta para insertar en la tabla Cliente
            $consultaCliente = "
                INSERT INTO Cliente (UsuarioID)
                VALUES ('$usuarioID')
            ";
            $resultadoCliente = mysqli_query($conn, $consultaCliente);

            if ($resultadoCliente) {
                header("Location: login.html");
                        } else {
                echo '<h3 class="error">❌ Ocurrió un error al registrar como cliente</h3>';
            }
        } else {
            echo '<h3 class="error">❌ Ocurrió un error al registrar el usuario</h3>';
        }
    } else {
        echo '<h3 class="error">⚠️ Por favor completa todos los campos obligatorios</h3>';
    }
}
?>