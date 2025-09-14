<?php
session_start();
$esta_logueado = isset($_SESSION['usuario']);

// Preparamos el mensaje de sesión si existe para mostrarlo en la página
$mensaje_sesion = '';
if (isset($_SESSION['mensaje_reserva'])) {
    $mensaje_sesion = $_SESSION['mensaje_reserva'];
    unset($_SESSION['mensaje_reserva']); // Lo borramos para que no se muestre de nuevo
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Proyecto</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles-base.css">
    <link rel="stylesheet" href="styles-index.css">
</head>
<body>
    <!-- Navbar de Bootstrap -->
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
                        <a class="nav-link active" href="Index.php">Inicio</a>
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
                        <a class="nav-link" href="Contacto.php">Contacto</a>
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

    <!-- Contenedor del contenido principal -->
    <div class="container mt-5 pt-5">
        <?php echo $mensaje_sesion; // Aquí se mostrará el mensaje de éxito o cancelación ?>
        <!-- Contenido principal -->
        <main class="menu-main">
            <h2>Tu Estilo, Nuestra Pasión</h2>
            <p>
                Bienvenido/a a nuestro salón. Aquí nos dedicamos a realzar tu belleza y a cuidar de tu cabello con productos de la más alta calidad y las últimas tendencias.
                Nuestro equipo de estilistas profesionales está listo para asesorarte y darte el look que siempre has deseado.
            </p>

            <h2>Una Experiencia Única</h2>
            <p>
                Relájate y disfruta de un ambiente diseñado para tu confort.
                Explora nuestra gama de servicios, desde cortes modernos y coloraciones vibrantes hasta tratamientos capilares que devolverán la vida a tu pelo.
                <br><br>
            </p>

            <!-- Llamado a la acción -->
            <div class="text-center my-5">
                <a href="Reservas.php" class="btn btn-cta">¡Reserva tu cita ahora!</a>
            </div>

            <!-- Sección de Servicios Destacados -->
            <div class="servicios-destacados">
                <h3 class="text-center mb-4">Servicios Populares</h3>
                <div class="row">
                    <!-- Tarjeta 1: Cortes -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 card-servicio">
                            <div class="card-body text-center">
                                <h5 class="card-title">Cortes Modernos</h5>
                                <p class="card-text">Estilos vanguardistas y clásicos para damas, caballeros y niños.</p>
                                <a href="Servicios.php#cortes" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 2: Coloración -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 card-servicio">
                            <div class="card-body text-center">
                                <h5 class="card-title">Coloración Experta</h5>
                                <p class="card-text">Desde tintes completos hasta técnicas avanzadas como Balayage.</p>
                                <a href="Servicios.php#coloracion" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 3: Tratamientos -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 card-servicio">
                            <div class="card-body text-center">
                                <h5 class="card-title">Tratamientos</h5>
                                <p class="card-text">Recupera la salud y el brillo de tu cabello con nuestros tratamientos.</p>
                                <a href="Servicios.php#peinados" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
