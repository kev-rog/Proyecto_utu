<?php
session_start();
include("conexion.php");

$esta_logueado = isset($_SESSION['usuario']);

// Obtener los servicios de la base de datos
$servicios_db = [];
$resultado_servicios = $conn->query("SELECT ServicioID, Nombre, Descripcion, Precio FROM servicios ORDER BY ServicioID");
if ($resultado_servicios) {
    $servicios_db = $resultado_servicios->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros Servicios | Proyecto</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Estilos Base y de la página -->
    <link rel="stylesheet" href="styles-base.css">
    <link rel="stylesheet" href="styles-index.css"> <!-- Reutilizamos estilos del index para las tarjetas -->
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
                        <a class="nav-link dropdown-toggle active" href="Servicios.php" id="serviciosDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Servicios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="serviciosDropdown">
                            <?php foreach ($servicios_db as $servicio): ?>
                                <li><a class="dropdown-item" href="#servicio-<?php echo $servicio['ServicioID']; ?>"><?php echo htmlspecialchars($servicio['Nombre']); ?></a></li>
                            <?php endforeach; ?>
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

    <!-- Contenido principal de la página de Servicios -->
    <div class="container mt-5 pt-5">
        <main class="menu-main">
            <h2 class="text-center mb-5">Nuestros Servicios</h2>

            <?php foreach ($servicios_db as $servicio): ?>
                <section id="servicio-<?php echo $servicio['ServicioID']; ?>" class="mb-5 pt-4 text-start">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3><?php echo htmlspecialchars($servicio['Nombre']); ?></h3>
                        <span class="fs-4 fw-bold text-primary">$<?php echo number_format($servicio['Precio'], 2); ?></span>
                    </div>
                    <p><?php echo htmlspecialchars($servicio['Descripcion']); ?></p>
                </section>
                <hr class="my-5">
            <?php endforeach; ?>

            <div class="text-center my-5">
                <a href="Reservas.php" class="btn btn-cta">¡Reserva tu servicio!</a>
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>