<?php
include("conexion.php"); // Archivo de conexión (sin tilde en el nombre)

if (isset($_POST['registrar'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Sanitización de datos de entrada
        $Correo     = trim($_POST['correo']);
        $Nombre     = trim($_POST['nombre']);
        $Apellido   = trim($_POST['apellido']);
        $Telefono   = trim($_POST['telefono']);
        $Contrasena = trim($_POST['contrasena']);

        // Validar campos obligatorios
        if (
            strlen($Correo) >= 1 &&
            strlen($Nombre) >= 1 &&
            strlen($Apellido) >= 1 &&
            strlen($Contrasena) >= 1
        ) {
            // Insertar en tabla Usuario
            $consultaUsuario = "INSERT INTO Usuario (Nombre,Apellido, Correo, Contrasena) 
             
     VALUES ('$Nombre', '$Apellido', '$Correo', '$Contrasena')";
            
    $resultadoUsuario = mysqli_query($conn,$consultaUsuario);

            if ($resultadoUsuario) {
                // Obtener el ID del usuario recién creado
                $usuarioID = mysqli_insert_id($conn);

                // Insertar en tabla Cliente
                $consultaCliente = "
                    INSERT INTO Cliente (UsuarioID)
                    VALUES ('$usuarioID')
                ";
                $resultadoCliente = mysqli_query($conn, $consultaCliente);

                if ($resultadoCliente) {
                    echo '<h3 class="success">✅ Tu registro ha sido completado correctamente</h3>';
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
}
?>