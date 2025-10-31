<?php

// 1. INCLUIR FICHEROS
require_once 'utils/SessionHelper.php';
require_once 'persistence/conf/PersistentManager.php';
require_once 'persistence/DAO/EquipoDAO.php';
require_once 'templates/header.php';

// 2. INICIAR SESIÓN
SessionHelper::start();

// 3. OBTENER DATOS
$equipos = [];
try {
    $db = new PersistentManager();
    $conn = $db->getConnection();
    $equipoDAO = new EquipoDAO($conn);
    $equipos = $equipoDAO->selectAll();
    $db->closeConnection();
} catch (Exception $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// 4. PINTAR HTML
?>

<div class="row">

    <div class="col-md-7">
        <h2 class="mb-3">Lista de Equipos</h2>

        <?php if (count($equipos) > 0): ?>
            <ul class="list-group shadow-sm">
                <?php foreach ($equipos as $equipo): ?>
                    <a href="partidosEquipo.php?id_equipo=<?php echo htmlspecialchars($equipo['id_equipo']); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <strong><?php echo htmlspecialchars($equipo['nombre']); ?></strong>
                        <small class="text-muted">Estadio: <?php echo htmlspecialchars($equipo['estadio']); ?></small>
                    </a>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-info">No hay equipos registrados todavía.</div>
        <?php endif; ?>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Añadir Nuevo Equipo</h4>

                <form action="app/addEquipo.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del equipo:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="estadio" class="form-label">Estadio:</label>
                        <input type="text" class="form-control" id="estadio" name="estadio" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Añadir Equipo</button>
                </form>
            </div>
        </div>
    </div>

</div> <?php

?>
</main> <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>