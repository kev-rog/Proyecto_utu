<?php
session_start();
include("conexion.php");

if (isset($_POST['registrar']) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $correo     = trim($_POST['correo']);
    $nombre     = trim($_POST['nombre']);
    $apellido   = trim($_POST['apellido']);
    $contrasena = trim($_POST['contrasena']);
    $confirmarContrasena = trim($_POST['confirmar_contrasena']);

    // 1. Validar contraseñas iguales
    if ($contrasena !== $confirmarContrasena) {
        $_SESSION['error'] = "❌ Las contraseñas no coinciden.";
        header("Location: register.php");
        exit();
    }

    // 2. Validar longitud mínima
    if (strlen($contrasena) < 8) {
        $_SESSION['error'] = "❌ La contraseña debe tener al menos 8 caracteres.";
        header("Location: register.php");
        exit();
    }

    // 3. Verificar si el correo ya existe
    $checkCorreo = $conn->prepare("SELECT UsuarioID FROM Usuario WHERE Correo = ?");
    $checkCorreo->bind_param("s", $correo);
    $checkCorreo->execute();
    $checkCorreo->store_result();

    if ($checkCorreo->num_rows > 0) {
        $_SESSION['error'] = "❌ El correo electrónico ya está registrado.";
        $checkCorreo->close();
        header("Location: register.php");
        exit();
    }
    $checkCorreo->close();

    // 4. Hash seguro
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    if (!empty($correo) && !empty($nombre) && !empty($apellido)) {
        $stmtUsuario = $conn->prepare("INSERT INTO Usuario (Nombre, Apellido, Correo, Contrasena) VALUES (?, ?, ?, ?)");
        $stmtUsuario->bind_param("ssss", $nombre, $apellido, $correo, $contrasena_hash);

        if ($stmtUsuario->execute()) {
            $usuarioID = $stmtUsuario->insert_id;
            $stmtUsuario->close();

            $stmtCliente = $conn->prepare("INSERT INTO Cliente (UsuarioID) VALUES (?)");
            $stmtCliente->bind_param("i", $usuarioID);

            if ($stmtCliente->execute()) {
                $stmtCliente->close();
                $conn->close();
                header("Location: inicio_sesion.php?registro=exitoso");
                exit();
            } else {
                $_SESSION['error'] = "❌ Ocurrió un error al registrar como cliente.";
                header("Location: register.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "❌ Ocurrió un error al registrar el usuario.";
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "⚠️ Por favor completa todos los campos obligatorios.";
        header("Location: register.php");
        exit();
    }
}
