<?php 


class Evento
{
    const MAX_SIZE = 500;
    
    use MagicProperties;
    private $idTorneo;

    private $inscritos;

    private $categoria;

    private $numJugadores;

    private $nombreTorneo;

    //podria hacer falta una descripcion del toreneo

    private function __construct($idTorneo, $inscritos, $categoria, $numJugadores, $nombreTorneo)
    {
        $this->idTorneo = intval($idTorneo);
        $this->inscritos = intval($inscritos);
        $this->categoria = $categoria;
        $this->numJugadores = $numJugadores;
        $this->nombreTorneo = $nombreTorneo;
    
    }

    public static function Nuevo($idTorneo,$inscritos,$categoria,$numJugadores, $nombreTorneo){
        $NuevoEvento = new Evento($idTorneo,$inscritos,$categoria,$numJugadores, $nombreTorneo);
        return $NuevoEvento;

    }

    public function getId()
    {
        return $this->idTorneo;
    }
    public function getTorneo()
    {
        return $this->nombreTorneo;
    }
    
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    public function getInscritos()
    {
        return $this->inscritos;
    }

    public function getNumJugadores()
    {
        return $this->numJugadores;
    }
    
    public function setId($id){
        $this->idTorneo = $id;
    }
    public function setTorneo($nombre){
        $this->nombreTorneo = $nombre;
    }
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }
    public function setInscritos($inscritos){
        $this->inscritos = $inscritos;
    }
    public function setNumJugadores($numJugadores){
        $this->numJugadores = $numJugadores;
    }

    private static function inserta($evento)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO eventos (idTorneo, inscritos, categoria, numJugadores, nombreTorneo) VALUES ('%s', %f, '%s', '%s', %f, %d)",
            $conn->real_escape_string($evento->inscritos),
            $evento->numJugadores,
            $conn->real_escape_string($evento->categoria),
            $conn->real_escape_string($evento->nombreTorneo),

        );
        $result = $conn->query($query);
        if ($result) {
            $evento->id = $conn->insert_id;
            $result = $evento;
        } else {
            error_log($conn->error);
        }

        return $result;
    }

    public static function elimina($idTorneo)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "DELETE FROM eventos WHERE id = %d",
            $idTorneo
        );
        $result = $conn->query($query);

        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("No se ha eliminado ningún evento.");
        }

        return $result;
    }

    public static function buscaPorId($idProducto)
    {
        $result = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM productos P WHERE P.id = %d;', $idProducto); 
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            while ($fila = $rs->fetch_assoc()) {
                $result = new Producto($fila['id'], $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['imagen'], $fila['valoracion'], $fila['num_valoraciones'], $fila['cantidad']);
            }
            $rs->free();
        }
        return $result;
    }

}
