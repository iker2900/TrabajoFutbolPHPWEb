<?php


class PartidoDAO {

    private $conn; // (La conexión mysqli)

    /**
     * Constructor que recibe la conexión
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Método selectAllJornadas()
     */
    public function selectAllJornadas() {
        $query = "SELECT DISTINCT jornada FROM partidos ORDER BY jornada ASC";
        $result = mysqli_query($this->conn, $query);

        $jornadas = array();
        // (Fuente: UT1_PHP_ParaWEB.pdf, Página 35, Recorrer resultado)
        while ($row = mysqli_fetch_array($result)) {
            $jornadas[] = $row['jornada'];
        }
        return $jornadas;
    }

    /**
     * Método selectByJornada()
     */
    public function selectByJornada($jornada) {
        // (Necesitamos JOIN para coger los nombres de los equipos)
        $sql = "SELECT p.*, el.nombre AS nombre_local, ev.nombre AS nombre_visitante
                FROM partidos p
                JOIN equipos el ON p.id_equipo_local = el.id_equipo
                JOIN equipos ev ON p.id_equipo_visitante = ev.id_equipo
                WHERE p.jornada = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $jornada); // 'i' es por integer
        $stmt->execute(); //
        $resultado = $stmt->get_result(); //

        $partidos = array();
        // (Fuente: UT1_PHP_ParaWEB.pdf, Pág 34, fetch_assoc)
        while ($partido = $resultado->fetch_assoc()) {
            $partidos[] = $partido;
        }
        return $partidos;
    }

    /**
     * Método selectByEquipo()
     */
    public function selectByEquipo($idEquipo) {
        $sql = "SELECT p.*, el.nombre AS nombre_local, ev.nombre AS nombre_visitante
                FROM partidos p
                JOIN equipos el ON p.id_equipo_local = el.id_equipo
                JOIN equipos ev ON p.id_equipo_visitante = ev.id_equipo
                WHERE p.id_equipo_local = ? OR p.id_equipo_visitante = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idEquipo, $idEquipo); // Dos 'i' (integer)
        $stmt->execute();
        $resultado = $stmt->get_result();

        $partidos = array();
        while ($partido = $resultado->fetch_assoc()) {
            $partidos[] = $partido;
        }
        return $partidos;
    }

    /**
     * Método checkIfMatchExists()
     */
    public function checkIfMatchExists($idLocal, $idVisitante) {
        $sql = "SELECT COUNT(*) AS total FROM partidos 
                WHERE (id_equipo_local = ? AND id_equipo_visitante = ?) 
                   OR (id_equipo_local = ? AND id_equipo_visitante = ?)";

        $stmt = $this->conn->prepare($sql);
        // (Validamos A vs B y B vs A)
        $stmt->bind_param("iiii", $idLocal, $idVisitante, $idVisitante, $idLocal);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();

        return $row['total'] > 0; // Devuelve true si ya existe
    }

    /**
     * Método insert()
     */
    public function insert($idLocal, $idVisitante, $resultado, $estadio, $jornada) {
        $sql = "INSERT INTO partidos (id_equipo_local, id_equipo_visitante, resultado, estadio, jornada) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }

        // i = integer, s = string
        $stmt->bind_param('iissi', $idLocal, $idVisitante, $resultado, $estadio, $jornada);

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    }
}
?>