<?php

// 1. INCLUIMOS LOS FICHEROS
require_once '../utils/SessionHelper.php';
require_once '../persistence/conf/PersistentManager.php';
require_once '../persistence/DAO/EquipoDAO.php';

// 2. INICIAMOS SESIÓN
SessionHelper::start();

// 3. COMPROBAMOS QUE LA PETICIÓN SEA POST

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. RECOGEMOS LOS DATOS DEL FORMULARIO

    $nombre = $_POST['nombre'];
    $estadio = $_POST['estadio'];

    // 5. VALIDACIÓN
    if (!empty($nombre) && !empty($estadio)) {

        try {
            // 6. CONEXIÓN A BBDD
            $db = new PersistentManager();
            $conn = $db->getConnection();

            // 7. CREAMOS INSTANCIA DAO
            $equipoDAO = new EquipoDAO($conn);

            /*
             * 8. LLAMAMOS AL MÉTODO INSERT del DAO

             */
            $equipoDAO->insert($nombre, $estadio);

            // 9. CERRAMOS CONEXIÓN
            $db->closeConnection();

        } catch (Exception $e) {

            die("Error al insertar el equipo: " . $e->getMessage());
        }
    }
}

header("Location: ../equipos.php");
die();

?>