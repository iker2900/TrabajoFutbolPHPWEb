<?php

class PersistentManager {


    private $dbhost = 'localhost';
    private $dbuser = 'root';
    private $dbpass = '';
    private $dbname = 'competicion';

    private $conn;

    /**
     * Constructor. Llama al método de conexión.
     */
    public function __construct() {
        $this->connect();
    }

    /**
     * Crea la conexión mysql
     */
    public function connect() {
        try {
            $this->conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        } catch (Exception $e) {

            die("Error en la conexión de BBDD: " . $e->getMessage());
        }
    }

    /**
     * Devuelve la conexión activa
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Cierra la conexión
     */
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>