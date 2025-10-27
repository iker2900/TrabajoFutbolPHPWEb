<?php
class EquipoDAO {

    private $conn; // (La conexión mysqli)

    /**
     * Constructor que recibe la conexión
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Método selectAll()
     */
    public function selectAll() {
        $query = "SELECT * FROM equipos";
        $result = mysqli_query($this->conn, $query);

        $equipos = array();
        while ($equipoBD = mysqli_fetch_array($result)) {
            $equipos[] = $equipoBD;
        }
        return $equipos;
    }
    /**
     * Método selectById()
     * (Usado por partidosEquipo.php)
      */
    public function selectById($idEquipo) {
        $sql = "SELECT * FROM equipos WHERE id_equipo = ?";
        $stmt = $this->conn->prepare($sql);

        // 'i' significa que el parámetro es un 'integer'
        $stmt->bind_param("i", $idEquipo);
        $stmt->execute();

        $resultado = $stmt->get_result();
        // (Fuente: UT1_PHP_ParaWEB.pdf, Pág 34, fetch_assoc)
        return $resultado->fetch_assoc();
    }
    /**
     * Método insert()
     */
    public function insert($nombre, $estadio) {
        $sql = "INSERT INTO equipos (nombre, estadio) VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }

        // 's' significa que el parámetro es un 'string'
        $stmt->bind_param('ss', $nombre, $estadio);

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    }
}
?>