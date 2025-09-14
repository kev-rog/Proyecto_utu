<?php
session_start();
include("conexion.php");

// Verificamos si el usuario ha iniciado sesión
$esta_logueado = isset($_SESSION['usuario']);

// Si no está logueado, lo redirigimos a la página de login.
if (!$esta_logueado) {
    header("Location: inicio_sesion.php");
    exit();
}

$mensaje_reserva = '';

// --- LÓGICA PARA CANCELAR UNA RESERVA ---
if (isset($_GET['cancelar'])) {
    $reservaID_a_cancelar = filter_var($_GET['cancelar'], FILTER_VALIDATE_INT);
    $clienteID = $_SESSION['usuario_id'];

    if ($reservaID_a_cancelar) {
        // Actualizamos el estado a 'Cancelada' solo si la reserva pertenece al usuario actual
        $stmt_cancelar = $conn->prepare("UPDATE reservas SET Estado = 'Cancelada' WHERE ReservaID = ? AND ClienteID = ?");
        $stmt_cancelar->bind_param("ii", $reservaID_a_cancelar, $clienteID);
        
        if ($stmt_cancelar->execute() && $stmt_cancelar->affected_rows > 0) {
            $_SESSION['mensaje_reserva'] = '<div class="alert alert-warning">Tu reserva ha sido cancelada.</div>';
        }
        $stmt_cancelar->close();
    }
    header("Location: Index.php"); // Redirigimos al inicio
    exit();
}
// --- LÓGICA PARA PROCESAR EL FORMULARIO DE RESERVA ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reservar'])) {
    $servicioID = $_POST['servicio'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $clienteID = $_SESSION['usuario_id']; // Asumimos que guardaste 'usuario_id' en el login

    // Validaciones básicas
    if (empty($servicioID) || empty($fecha) || empty($hora)) {
        $mensaje_reserva = '<div class="alert alert-danger">Por favor, completa todos los campos.</div>';
    } else {
        // Insertar la reserva en la base de datos
        $stmt = $conn->prepare("INSERT INTO reservas (ClienteID, ServicioID, FechaReserva, HoraReserva) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $clienteID, $servicioID, $fecha, $hora);

        if ($stmt->execute()) {
            $_SESSION['mensaje_reserva'] = '<div class="alert alert-success">¡Tu reserva ha sido registrada con éxito!</div>';
            $stmt->close();
            header("Location: Index.php"); // Redirigimos al inicio
            exit();
        } else {
            $mensaje_reserva = '<div class="alert alert-danger">Hubo un error al procesar tu reserva. Inténtalo de nuevo.</div>';
        }
    }
}

// Mostramos el mensaje si existe en la sesión y luego lo borramos
if (isset($_SESSION['mensaje_reserva'])) {
    $mensaje_reserva = $_SESSION['mensaje_reserva'];
    unset($_SESSION['mensaje_reserva']);
}

// --- LÓGICA PARA OBTENER DATOS ---

// 1. Obtener la lista de servicios para el dropdown
$servicios = [];
$resultado_servicios = $conn->query("SELECT ServicioID, Nombre, Precio FROM servicios ORDER BY Nombre");
if ($resultado_servicios) {
    $servicios = $resultado_servicios->fetch_all(MYSQLI_ASSOC);
}

// 2. Obtener las reservas del usuario actual
$reservas_usuario = [];
$clienteID = $_SESSION['usuario_id'];
$stmt_reservas = $conn->prepare("SELECT r.ReservaID, r.FechaReserva, r.HoraReserva, s.Nombre, r.Estado FROM reservas r JOIN servicios s ON r.ServicioID = s.ServicioID WHERE r.ClienteID = ? ORDER BY r.FechaReserva DESC, r.HoraReserva DESC");
$stmt_reservas->bind_param("i", $clienteID);
$stmt_reservas->execute();
$resultado_reservas = $stmt_reservas->get_result();
if ($resultado_reservas) {
    $reservas_usuario = $resultado_reservas->fetch_all(MYSQLI_ASSOC);
}
$stmt_reservas->close();

// Definimos los horarios disponibles para el formulario
$horarios = [
    "09:00:00" => "09:00",
    "10:00:00" => "10:00",
    "11:00:00" => "11:00",
    "12:00:00" => "12:00",
    "14:00:00" => "14:00",
    "15:00:00" => "15:00",
    "16:00:00" => "16:00",
    "17:00:00" => "17:00",
    "18:00:00" => "18:00",
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Cita | Proyecto</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Estilos Base y de la página -->
    <link rel="stylesheet" href="styles-base.css">
    <link rel="stylesheet" href="styles-reservas.css">
</head>
<body>
    <!-- Navbar (idéntica a la de Index.php) -->
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
                        <a class="nav-link active" href="Reservas.php">Reservar Cita</a>
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

    <!-- Contenido principal de la página de Reservas -->
    <div class="container mt-5 pt-5">
        <main class="menu-main">
            <h2 class="text-center">Reserva tu Cita</h2>
            <p class="text-center">
                Selecciona el servicio, la fecha y la hora que prefieras. ¡Te esperamos!
            </p>

            <?php echo $mensaje_reserva; // Muestra mensajes de éxito o error ?>

            <!-- Formulario de Reservas -->
            <form action="Reservas.php" method="POST" class="mt-4">
                <div class="row g-3">
                    <!-- Selector de Servicio -->
                    <div class="col-md-12">
                        <label for="servicio" class="form-label"><strong>1. Elige un servicio:</strong></label>
                        <select class="form-select" id="servicio" name="servicio" required>
                            <option value="" selected disabled>-- Selecciona un servicio --</option>
                            <?php foreach ($servicios as $servicio): ?>
                                <option value="<?php echo $servicio['ServicioID']; ?>">
                                    <?php echo htmlspecialchars($servicio['Nombre']) . ' - $' . number_format($servicio['Precio'], 2); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Selector de Fecha -->
                    <div class="col-12">
                        <label for="fecha" class="form-label"><strong>2. Elige una fecha:</strong></label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <!-- Selector de Hora -->
                    <div class="col-12">
                        <label class="form-label"><strong>3. Elige una hora:</strong></label>
                        <div class="horarios-disponibles">
                            <?php foreach ($horarios as $valor => $texto): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hora" id="hora-<?php echo str_replace(':', '', $valor); ?>" value="<?php echo $valor; ?>" required>
                                    <label class="form-check-label" for="hora-<?php echo str_replace(':', '', $valor); ?>">
                                        <?php echo $texto; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" name="reservar" class="btn btn-cta btn-reserva">Confirmar Reserva</button>
                </div>
            </form>

            <!-- Sección Mis Reservas -->
            <div class="mt-5">
                <h3 class="text-center mb-4">Mis Reservas</h3>
                <?php if (empty($reservas_usuario)): ?>
                    <div class="alert alert-secondary text-center">
                        Aún no tienes ninguna reserva registrada.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-custom">
                                <tr>
                                    <th>Servicio</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservas_usuario as $reserva): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($reserva['Nombre']); ?></td>
                                        <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($reserva['FechaReserva']))); ?></td>
                                        <td><?php echo htmlspecialchars(date("H:i", strtotime($reserva['HoraReserva']))); ?></td>
                                        <td>
                                            <span class="badge <?php echo $reserva['Estado'] === 'Cancelada' ? 'bg-danger' : 'bg-primary'; ?>">
                                                <?php echo htmlspecialchars($reserva['Estado']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($reserva['Estado'] === 'Pendiente'): ?>
                                                <button type="button" class="btn btn-cancelar" data-bs-toggle="modal" data-bs-target="#confirmarCancelacionModal" data-url="Reservas.php?cancelar=<?php echo $reserva['ReservaID']; ?>">
                                                    Cancelar
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modal de Confirmación de Cancelación -->
    <div class="modal fade" id="confirmarCancelacionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="modalLabel">Confirmar Cancelación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres cancelar esta reserva? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="#" id="btnConfirmarCancelacion" class="btn btn-danger">Sí, cancelar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para manejar el modal de cancelación -->
    <script>
        const confirmarCancelacionModal = document.getElementById('confirmarCancelacionModal');
        if (confirmarCancelacionModal) {
            confirmarCancelacionModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget; // El botón que activó el modal
                const url = button.getAttribute('data-url'); // Extraemos la URL del atributo data-url
                const btnConfirmar = confirmarCancelacionModal.querySelector('#btnConfirmarCancelacion');
                btnConfirmar.setAttribute('href', url); // Asignamos la URL al botón de confirmación del modal
            });
        }
    </script>
</body>
</html>