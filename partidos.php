<?php


// 1. INCLUIR FICHEROS
require_once 'utils/SessionHelper.php';
require_once 'persistence/conf/PersistentManager.php';
require_once 'persistence/DAO/PartidoDAO.php';
require_once 'persistence/DAO/EquipoDAO.php';
require_once 'templates/header.php';

// 2. INICIAR SESIÓN
SessionHelper::start();

// 3. OBTENER DATOS
$jornadas = [];
$equipos = [];
$partidos = [];
$jornada_seleccionada = null;

// (Comprobamos si se ha enviado una jornada por GET)

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

    // Si el usuario seleccionó una jornada, buscamos los partidos
    if ($jornada_seleccionada !== null) {

        $partidos = $partidoDAO->selectByJornada($jornada_seleccionada);
    }

    $db->closeConnection();

} catch (Exception $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// 4. PINTAR HTML
?>

    <h2>Partidos por Jornada</h2>

    <form action="partidos.php" method="GET">
        <label for="jornada">Selecciona una jornada:</label>
        <select name="jornada" id="jornada">
            <option value="">-- Ver todas --</option>
            <?php
            // (llenamos el <select>)
            foreach ($jornadas as $j) {
                // (Marcamos como 'selected' si es la jornada activa)
                $selected = ($j == $jornada_seleccionada) ? 'selected' : '';
                echo '<option value="' . htmlspecialchars($j) . '" ' . $selected . '>';
                echo 'Jornada ' . htmlspecialchars($j);
                echo '</option>';
            }
            ?>
        </select>
        <input type="submit" value="Filtrar">
    </form>

    <hr>

<?php
if ($jornada_seleccionada !== null && count($partidos) > 0) {
    echo "<h3>Resultados de la Jornada " . htmlspecialchars($jornada_seleccionada) . "</h3>";
    echo "<ul>";
    foreach ($partidos as $partido) {
        echo "<li>";
        echo htmlspecialchars($partido['nombre_local']) . " vs ";
        echo htmlspecialchars($partido['nombre_visitante']);
        echo " | Resultado: <strong>" . htmlspecialchars($partido['resultado']) . "</strong>";
        echo " (Estadio: " . htmlspecialchars($partido['estadio']) . ")";
        echo "</li>";
    }
    echo "</ul>";
} elseif ($jornada_seleccionada !== null) {
    echo "<p>No hay partidos registrados para la jornada " . htmlspecialchars($jornada_seleccionada) . ".</p>";
}
?>

    <hr>

    <h2>Añadir Nuevo Partido</h2>

    <form action="app/addPartido.php" method="POST">
        <div>
            <label for="id_local">Equipo Local:</label>
            <select id="id_local" name="id_local" required>
                <?php foreach ($equipos as $equipo): ?>
                    <option value="<?php echo htmlspecialchars($equipo['id_equipo']); ?>">
                        <?php echo htmlspecialchars($equipo['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="id_visitante">Equipo Visitante:</label>
            <select id="id_visitante" name="id_visitante" required>
                <?php foreach ($equipos as $equipo): ?>
                    <option value="<?php echo htmlspecialchars($equipo['id_equipo']); ?>">
                        <?php echo htmlspecialchars($equipo['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="resultado">Resultado (1, X, 2):</label>
            <select id="resultado" name="resultado" required>
                <option value="1">1</option>
                <option value="X">X</option>
                <option value="2">2</option>
            </select>
        </div>

        <div>
            <label for="estadio">Estadio:</label>
            <input type="text" id="estadio" name="estadio" required>
        </div>

        <div>
            <label for="jornada_nueva">Jornada:</label>
            <input type="number" id="jornada_nueva" name="jornada" min="1" required>
        </div>

        <div>
            <input type="submit" value="Añadir Partido">
        </div>
    </form>

<?php

?>