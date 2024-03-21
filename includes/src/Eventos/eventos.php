<?php 

use es\ucm\fdi\aw\src\BD;

class Evento
{
    const MAX_SIZE = 500;
    
    //use MagicProperties;
    private $idTorneo;

    private $inscritos;
    //cambiar a juego
    private $categoria;

    private $numJugadores;

    public $nombreTorneo;

    private $descripcionEvento;

   // private $fechaEvento;

   // private $lugarEvento;

   //$estado (finalizado)

   //$premio

   //$Ganador

    //podria hacer falta una descripcion del toreneo

    private function __construct($idTorneo, $inscritos, $categoria, $numJugadores, $nombreTorneo,$descripcionEvento)
    {
        $this->idTorneo = intval($idTorneo);
        $this->inscritos = intval($inscritos);
        $this->categoria = $categoria;
        $this->numJugadores = $numJugadores;
        $this->nombreTorneo = $nombreTorneo;
        $this->descripcionEvento = $descripcionEvento;
    
    }

    public static function Nuevo($idTorneo,$inscritos,$categoria,$numJugadores, $nombreTorneo,$descripcionEvento){
        $NuevoEvento = new Evento($idTorneo,$inscritos,$categoria,$numJugadores, $nombreTorneo,$descripcionEvento);
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

    public function getDescripcion(){
        return $this->descripcionEvento;
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

    public function setDescripcion($descripcionEvento){
        $this->descripcionEvento = $descripcionEvento;

    }
    private static function inserta($evento)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO eventos (idTorneo, inscritos, categoria, numJugadores, nombreTorneo, descripcionEvento) VALUES ('%s', %f, '%s', '%s', %f, %d)",
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

    public static function buscaPorId($idEvento)
    {
        $result = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM eventos P WHERE P.id = %d;', $idEvento); 
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            
            $rs->free();
        }
        return $result;
    }

    public static function listarEventos()
    {
        $conn = BD::getInstance()->getConexionBd();
        $query =" ";
       
        $query = sprintf("SELECT * FROM eventos");
            
        
        $rs = $conn->query($query);
        $eventos = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $evento = new Evento(
                    $fila['idTorneo'],
                    $fila['inscritos'],
                    $fila['categoria'],
                    $fila['numJugadores'],
                    $fila['nombreTorneo'],
                    $fila['descripcionEvento']
                );
                $eventos[] = $evento; 
            }
            $rs->free();
        }
        return $eventos;
    }
    

}
