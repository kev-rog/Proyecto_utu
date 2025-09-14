<?php
session_start();
$esta_logueado = isset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | Proyecto</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Estilos Base -->
    <link rel="stylesheet" href="styles-base.css">
    <link rel="stylesheet" href="styles-contacto.css">
</head>
<body>
    <!-- Navbar (idéntica a las otras páginas) -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top menu-header">
        <div class="container">
            <a class="navbar-brand" href="Index.php">
                <h1 class="mb-0">Proyecto</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Index.php">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="Servicios.php" id="serviciosDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Servicios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="serviciosDropdown">
                            <li><a class="dropdown-item" href="Servicios.php#cortes">Cortes</a></li>
                            <li><a class="dropdown-item" href="Servicios.php#peinados">Peinados</a></li>
                            <li><a class="dropdown-item" href="Servicios.php#coloracion">Coloración</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Reservas.php">Reservar Cita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="Contacto.php">Contacto</a>
                    </li>
                    <?php if ($esta_logueado): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><h6 class="dropdown-header">
                                    <?php echo htmlspecialchars(($_SESSION['nombre'] ?? '') . ' ' . ($_SESSION['apellido'] ?? '')); ?>
                                </h6></li>
                                <li><span class="dropdown-item-text text-muted small"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="inicio_sesion.php">Iniciar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal de la página de Contacto -->
    <div class="container mt-5 pt-5">
        <main class="menu-main">
            <h2 class="text-center">Ponte en Contacto</h2>
            <p class="text-center mb-5">
                ¿Tienes alguna pregunta? No dudes en llamarnos o visitarnos.
            </p>

            <!-- Información de Contacto con Íconos -->
            <div class="row text-center">
                <div class="col-lg-4 mb-4">
                    <div class="contact-info-item">
                        <i class="bi bi-geo-alt-fill contact-icon"></i>
                        <h4 class="mt-3">Dirección</h4>
                        <p class="text-muted">Calle Falsa 123, Montevideo</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="contact-info-item">
                        <i class="bi bi-telephone-fill contact-icon"></i>
                        <h4 class="mt-3">Teléfono</h4>
                        <p class="text-muted"><a href="tel:+59899123456">099 123 456</a></p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="contact-info-item">
                        <i class="bi bi-clock-fill contact-icon"></i>
                        <h4 class="mt-3">Horario</h4>
                        <p class="text-muted">Lunes a Sábado de 9:00 a 19:00</p>
                    </div>
                </div>
            </div>

            <!-- Mapa de Google Maps -->
            <div class="mt-5 pt-3">
                <h3 class="text-center mb-4">Nuestra Ubicación</h3>
                <!-- El div .map-container ahora envuelve al div de ratio para mantener los estilos de borde y sombra -->
                <div class="map-container">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13090.34472918064!2d-56.19692237910156!3d-34.8921987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x959f802b207f05ab%3A0x897532795413a94!2sPlaza%20Independencia!5e0!3m2!1ses-419!2suy!4v1716320098533!5m2!1ses-419!2suy" 
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>