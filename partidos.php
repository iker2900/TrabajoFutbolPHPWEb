<?php

// 1. INCLUIR FICHEROS
require_once 'utils/SessionHelper.php';
require_once 'persistence/conf/PersistentManager.php';
require_once 'persistence/DAO/PartidoDAO.php';
require_once 'persistence/DAO/EquipoDAO.php';
require_once 'templates/header.php';

// 2. INICIAR SESIÓN Y OBTENER DATOS
SessionHelper::start();
$jornadas = [];
$equipos = [];
$partidos = [];
$jornada_seleccionada = null;

if (isset($_GET['jornada'])) {
    $jornada_seleccionada = $_GET['jornada'];
}
try {
    $db = new PersistentManager();
    $conn = $db->getConnection();
    $partidoDAO = new PartidoDAO($conn);
    $equipoDAO = new EquipoDAO($conn);
    $jornadas = $partidoDAO->selectAllJornadas();
    $equipos = $equipoDAO->selectAll();
    if ($jornada_seleccionada !== null) {
        $partidos = $partidoDAO->selectByJornada($jornada_seleccionada);
    }
    $db->closeConnection();
} catch (Exception $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// 4. PINTAR HTML
?>

<div class="row">
    <div class="col-md-7">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">Partidos por Jornada</h4>
                <form action="partidos.php" method="GET" class="d-flex">
                    <select name="jornada" id="jornada" class="form-select me-2">
                        <option value="">Selecciona una jornada...</option>
                        <?php foreach ($jornadas as $j):
                            $selected = ($j == $jornada_seleccionada) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($j) . '" ' . $selected . '>';
                            echo 'Jornada ' . htmlspecialchars($j);
                            echo '</option>';
                        endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-info flex-shrink-0">Filtrar</button>
                </form>
            </div>
        </div>

        <?php if ($jornada_seleccionada !== null): ?>
            <h3 class="mb-3">Resultados de la Jornada <?php echo htmlspecialchars($jornada_seleccionada); ?></h3>
            <?php if (count($partidos) > 0): ?>
                <ul class="list-group shadow-sm">
                    <?php foreach ($partidos as $partido): ?>
                        <li class="list-group-item">
                            <strong><?php echo htmlspecialchars($partido['nombre_local']); ?></strong>
                            vs
                            <strong><?php echo htmlspecialchars($partido['nombre_visitante']); ?></strong>
                            | Resultado: <strong class="text-primary"><?php echo htmlspecialchars($partido['resultado']); ?></strong>
                            <small class="text-muted d-block mt-1">Estadio: <?php echo htmlspecialchars($partido['estadio']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="alert alert-info">No hay partidos registrados para esta jornada.</div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Añadir Nuevo Partido</h4>
                <form action="app/addPartido.php" method="POST">
                    <div class="mb-3">
                        <label for="id_local" class="form-label">Equipo Local:</label>
                        <select id="id_local" name="id_local" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php foreach ($equipos as $equipo): ?>
                                <option value="<?php echo htmlspecialchars($equipo['id_equipo']); ?>">
                                    <?php echo htmlspecialchars($equipo['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_visitante" class="form-label">Equipo Visitante:</label>
                        <select id="id_visitante" name="id_visitante" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php foreach ($equipos as $equipo): ?>
                                <option value="<?php echo htmlspecialchars($equipo['id_equipo']); ?>">
                                    <?php echo htmlspecialchars($equipo['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="resultado" class="form-label">Resultado:</label>
                            <select id="resultado" name="resultado" class="form-select" required>
                                <option value="1">1</option>
                                <option value="X">X</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="jornada_nueva" class="form-label">Jornada:</label>
                            <input type="number" class="form-control" id="jornada_nueva" name="jornada" min="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="estadio" class="form-label">Estadio:</label>
                        <input type="text" class="form-control" id="estadio" name="estadio" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Añadir Partido</button>
                </form>
            </div>
        </div>
    </div>
</div> <?php
// (5. Cierre de tags y carga de JS - SIN FOOTER.PHP)
?>
</main> <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>