<?php
// 1. INCLUIR FICHEROS
require_once 'utils/SessionHelper.php';
require_once 'persistence/conf/PersistentManager.php';
require_once 'persistence/DAO/PartidoDAO.php';
require_once 'persistence/DAO/EquipoDAO.php';
require_once 'templates/header.php';

// 2. INICIAR SESIÓN
SessionHelper::start(); //

// 3. VALIDAR ENTRADA (GET)

if (!isset($_GET['id_equipo'])) {
    die("Error: ID de equipo no especificado.");
}

$idEquipo = $_GET['id_equipo'];

/*
 * 4.Aquí es donde "recordamos" su última visita:
 */
SessionHelper::set('last_team_viewed', $idEquipo); //

// 5. OBTENER DATOS
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

// 6. PINTAR HTML
?>

    <h2>Partidos de <?php echo htmlspecialchars($equipoNombre); ?></h2>

<?php
if (count($partidos) > 0) {
    echo "<ul>";

    foreach ($partidos as $partido) {
        echo "<li>";
        echo "Jornada " . htmlspecialchars($partido['jornada']) . ": ";
        echo "<strong>" . htmlspecialchars($partido['nombre_local']) . "</strong> vs ";
        echo "<strong>" . htmlspecialchars($partido['nombre_visitante']) . "</strong>";
        echo " | Resultado: <strong>" . htmlspecialchars($partido['resultado']) . "</strong>";
        echo " | (Estadio: " . htmlspecialchars($partido['estadio']) . ")";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Este equipo no tiene partidos registrados.</p>";
}
?>

<?php

?>