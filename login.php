<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST['Correo']);
    $pass   = trim($_POST['Contrasena']);

    $stmt = $conn->prepare("SELECT UsuarioID, Nombre, Apellido, Correo, Contrasena FROM usuario WHERE Correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($pass, $usuario['Contrasena'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuario['UsuarioID'];
            $_SESSION['usuario']    = $usuario['Correo'];
            $_SESSION['nombre']     = $usuario['Nombre'];
            $_SESSION['apellido']   = $usuario['Apellido'];

            header("Location: index.php");
            exit();
        }
    }

    // Error de login
    $_SESSION['error'] = "Usuario o contraseña incorrectos";
    header("Location: inicio_sesion.php");
    exit();
}
