<?php
include("conexion.php"); // Usa el nombre sin tilde

if (isset($_POST['registrar'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Correo = trim($_POST['correo']);
        $Nombre = trim($_POST['nombre']);
        $Apellido = trim($_POST['apellido']);
        $Telefono = trim($_POST['telefono']);
        $Contrasena = trim($_POST['contrasena']); // Cambiado aquí

        if (
            strlen($Correo) >= 1 &&
            strlen($Nombre) >= 1 &&
            strlen($Apellido) >= 1 &&
            strlen($Contrasena) >= 1
        ) {
            // Ya no creamos una nueva conexión, usamos $conn de conexion.php

            // Insertar en Usuario
            $consultaUsuario = "INSERT INTO Usuario (Nombre, Apellido, Correo, Contrasena)
                VALUES ('$Nombre','$Apellido','$Correo','$Contrasena')";
            $resultadoUsuario = $conn->query($consultaUsuario);

            if ($resultadoUsuario) {
                // Obtener el ID del usuario recién creado
                $usuarioID = $conn->insert_id;

                // Insertar en Cliente
                $consultaCliente = "INSERT INTO Cliente (UsuarioID) VALUES ('$usuarioID')";
                $resultadoCliente = $conn->query($consultaCliente);

                if ($resultadoCliente) {
                    echo '<h3 class="success">Tu registro ha sido completado correctamente</h3>';
                } else {
                    echo '<h3 class="error">Ocurrió un error al registrar como cliente</h3>';
                }
            } else {
                echo '<h3 class="error">Ocurrió un error al registrar el usuario</h3>';
            }
        } else {
            echo '<h3 class="error">Por favor completa todos los campos obligatorios</h3>';
        }
    }
}