<?php
class SessionHelper {

    /**
     * Inicia la sesión de forma segura.
     */
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Añade un valor a la sesión.
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtiene un valor de la sesión.
     */
    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
}
?>