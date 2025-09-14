<?php
session_start();
$error = "";
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // evitar que quede al refrescar
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Proyecto UTU</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles-base.css">
    <link rel="stylesheet" href="styles-login-register-new.css">
</head>

<body class="login-register-page">
    <main class="container my-4">
        <div class="login-contenedor row mx-auto overflow-hidden" style="max-width: 900px;">
            <!-- Columna de la Imagen (visible en md y superior) -->
            <div class="col-md-6 d-none d-md-block p-0 login-imagen">
                <img src="Login.jpg" alt="Imagen Registro">
            </div>
            <!-- Columna del Formulario -->
         <div class="col-md-6 p-4 p-sm-5 form-box d-flex flex-column justify-content-center">
    <h2 class="text-center mb-4">Crear Cuenta</h2>

    <!-- Mostrar errores -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="post" action="registro.php">
        <div class="row g-3 mb-3">
            <div class="col">
                <label for="nombre" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="col">
                <label for="apellido" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
        </div>
        <div class="mb-3">
            <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required>
        </div>
        <button type="submit" name="registrar" class="btn btn-primary w-100 mt-4">Registrarse</button>
    </form>
    <p class="text-center mt-4 mb-0 form-text text-muted">
        ¿Ya tienes cuenta? 
        <a href="inicio_sesion.php" class="text-decoration-none">Iniciar sesión</a>
    </p>
</div>

        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>