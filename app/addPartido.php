<?php

// 1. INCLUIMOS LOS FICHEROS
require_once '../utils/SessionHelper.php';
require_once '../persistence/conf/PersistentManager.php';
require_once '../persistence/DAO/PartidoDAO.php';

// 2. INICIAMOS SESIÓN
SessionHelper::start();

// 3. COMPROBAMOS QUE LA PETICIÓN SEA POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. RECOGEMOS LOS DATOS DEL FORMULARIO

    $idLocal = $_POST['id_local'];
    $idVisitante = $_POST['id_visitante'];
    $resultado = $_POST['resultado'];
    $estadio = $_POST['estadio'];
    $jornada = $_POST['jornada'];

    // 5. VALIDACIÓN (Requisito del enunciado)
    if (!empty($idLocal) && !empty($idVisitante) && $idLocal != $idVisitante) {

        try {
            // 6. CONEXIÓN A BBDD
            $db = new PersistentManager();
            $conn = $db->getConnection();

            $partidoDAO = new PartidoDAO($conn);

            /*
             * 7. VALIDACIÓN BBDD
             * (Asumimos que tu DAO tiene un método 'checkIfMatchExists')
             */
            $matchExists = $partidoDAO->checkIfMatchExists($idLocal, $idVisitante);

            if ($matchExists) {

            } else {
                /*
                 * 8. LLAMAMOS AL MÉTODO INSERT (si la validación es OK)
                 */
                $partidoDAO->insert($idLocal, $idVisitante, $resultado, $estadio, $jornada);
            }

            // 9. CERRAMOS CONEXIÓN
            $db->closeConnection();

        } catch (Exception $e) {

            die("Error al procesar el partido: " . $e->getMessage());
        }
    } else {

    }
}

/*
 * 10. REDIRIGIMOS DE VUELTA a partidos.php
 */
header("Location: ../partidos.php");
die(); //

?>