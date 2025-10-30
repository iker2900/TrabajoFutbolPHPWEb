<?php
/*
 * 1. INCLUIR FICHEROS
 */
require_once 'utils/SessionHelper.php';

/*
 * 2. MANEJO DE SESIÓN
 */
SessionHelper::start();

/*
 * 3. REDIRECCIÓN
  */
if (SessionHelper::get('last_team_viewed') !== null) {

    // Si existe, recuperamos el ID del equipo guardado en la sesión
    $last_team_id = SessionHelper::get('last_team_viewed');

    /*
     * 4. REDIRECCIÓN (header)
     */
    header("Location: partidosEquipo.php?id_equipo=" . $last_team_id);

    die();

} else {

    /*
     * 5. CASO POR DEFECTO
     */
    header("Location: equipos.php");
    die();
}

?>