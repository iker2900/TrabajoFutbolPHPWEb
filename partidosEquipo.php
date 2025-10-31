<?php

// 1. INCLUIR FICHEROS
require_once 'utils/SessionHelper.php';
require_once 'persistence/conf/PersistentManager.php';
require_once 'persistence/DAO/PartidoDAO.php';
require_once 'persistence/DAO/EquipoDAO.php';
require_once 'templates/header.php';

// 2. INICIAR SESIÓN Y OBTENER ID
SessionHelper::start(); //

if (!isset($_GET['id_equipo'])) {
    die("Error: ID de equipo no especificado.");
}
$idEquipo = $_GET['id_equipo'];
SessionHelper::set('last_team_viewed', $idEquipo);

// 3. OBTENER DATOS
$partidos = [];
$equipoNombre = "Equipo Desconocido";
try {
    $db = new PersistentManager();
    $conn = $db->getConnection();
    $partidoDAO = new PartidoDAO($conn);
    $equipoDAO = new EquipoDAO($conn);
    $partidos = $partidoDAO->selectByEquipo($idEquipo);
    $equipo = $equipoDAO->selectById($idEquipo);
    if ($equipo) {
        $equipoNombre = $equipo['nombre'];
    }
    $db->closeConnection();
} catch (Exception $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}

// 4. PINTAR HTML
?>

<h2 class="mb-3">Partidos de <?php echo htmlspecialchars($equipoNombre); ?></h2>

<?php if (count($partidos) > 0): ?>
    <ul class="list-group shadow-sm">
        <?php foreach ($partidos as $partido): ?>
            <li class="list-group-item">
                <span class="badge bg-secondary me-2">Jornada <?php echo htmlspecialchars($partido['jornada']); ?></span>
                <strong><?php echo htmlspecialchars($partido['nombre_local']); ?></strong>
                vs
                <strong><?php echo htmlspecialchars($partido['nombre_visitante']); ?></strong>
                | Resultado: <strong class="text-primary"><?php echo htmlspecialchars($partido['resultado']); ?></strong>
                <small class="text-muted d-block mt-1">Estadio: <?php echo htmlspecialchars($partido['estadio']); ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <div class="alert alert-info">Este equipo no tiene partidos registrados.</div>
<?php endif; ?>

<?php

?>
</main> <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>