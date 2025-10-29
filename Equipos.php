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
    // Conexión a BBDD
    $db = new PersistentManager();
    $conn = $db->getConnection();

    // Creamos una instancia del DAO
    $equipoDAO = new EquipoDAO($conn);

    // Llamamos al método "selectAll"
    $equipos = $equipoDAO->selectAll();

    // Cerramos la conexión
    $db->closeConnection();

} catch (Exception $e) {
    // Manejo de errores

    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// 4. PINTAR HTML
?>

<h2>Lista de Equipos</h2>

<?php

if (count($equipos) > 0) {
    echo "<ul>"; //
    foreach ($equipos as $equipo) {

        echo '<li>';
        echo '<a href="partidosEquipo.php?id_equipo=' . htmlspecialchars($equipo['id_equipo']) . '">';
        echo htmlspecialchars($equipo['nombre']) . " (Estadio: " . htmlspecialchars($equipo['estadio']) . ")";
        echo '</a>';
        echo '</li>';
    }
    echo "</ul>";
} else {
    echo "<p>No hay equipos registrados todavía.</p>";
}
?>

<hr>

<h2>Añadir Nuevo Equipo</h2>

<form action="app/addEquipo.php" method="POST">
    <div>
        <label for="nombre">Nombre del equipo:</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    <div>
        <label for="estadio">Estadio:</label>
        <input type="text" id="estadio" name="estadio" required>
    </div>
    <div>
        <input type="submit" value="Añadir Equipo">
    </div>
</form>

<?php
?>
