<?php
session_start();
$error = "";
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Para que no se repita al refrescar
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Proyecto UTU</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles-base.css">
    <link rel="stylesheet" href="styles-login-register-new.css">
</head>

<body class="login-register-page">
    <main class="container">
        <div class="login-contenedor row mx-auto overflow-hidden" style="max-width: 900px;">
            <!-- Columna de la Imagen -->
            <div class="col-md-6 d-none d-md-block p-0 login-imagen">
                <img src="Login.jpg" alt="Imagen Login">
            </div>
            <!-- Columna del Formulario -->
            <div class="col-md-6 p-4 p-sm-5 form-box d-flex flex-column justify-content-center">
                <h2 class="text-center mb-4">Iniciar Sesión</h2>
                
                <!-- Mensaje de error -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger text-center">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="Correo" class="form-label">Correo</label>
                        <input type="text" class="form-control" id="Correo" name="Correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="Contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="Contrasena" name="Contrasena" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Iniciar Sesión</button>
                </form>

                <p class="text-center mt-4 mb-0 form-text text-muted">
                    ¿No tienes cuenta? 
                    <a href="register.php" class="text-decoration-none">Crear cuenta</a>
                </p>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
