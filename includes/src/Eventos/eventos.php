<?php 

//namespace es\ucm\fdi\aw\src\Eventos;
use es\ucm\fdi\aw\src\BD;


class Evento
{
    const MAX_SIZE = 500;
    
    //use MagicProperties;
    private $idEvento;

    private $inscritos;
    //cambiar a juego
    private $categoria;

    private $numJugadores;

    public $nombre;

    private $descripcion;

   private $fecha;

   private $lugar;

   private $estado;

   private $premio;

   private $ganador;

   private $tasaInscripcion;

    private function __construct($idTorneo, $inscritos, $categoria, $numJugadores, $nombreTorneo,$descripcionEvento,$fecha,$lugar,$estado,$premio,$ganador,$inscripcion)
    {
        $this->idEvento = intval($idTorneo);
        $this->inscritos = intval($inscritos);
        $this->categoria = $categoria;
        $this->numJugadores = $numJugadores;
        $this->nombre = $nombreTorneo;
        $this->descripcion = $descripcionEvento;
        $this->fecha = $fecha;
        $this->lugar = $lugar;
        $this->estado = $estado;
        $this->premio = $premio;
        $this->ganador = $ganador;
        $this->tasaInscripcion = $inscripcion; 
    
    }

    public static function Nuevo($idTorneo,$inscritos,$categoria,$numJugadores, $nombreTorneo,$descripcionEvento,$fecha,$lugar,$estado,$premio,$ganador,$inscripcion){
        $NuevoEvento = new Evento($idTorneo,$inscritos,$categoria,$numJugadores, $nombreTorneo,$descripcionEvento,$fecha,$lugar,$estado,$premio,$ganador,$inscripcion);
        return $NuevoEvento;

    }

    public function getId()
    {
        return $this->idEvento;
    }
    public function getEvento()
    {
        return $this->nombre;
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
        return $this->descripcion;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getLugar(){
        return $this->lugar;
    }
    
    public function getEstado(){
        return $this->estado;
    }

    public function getPremio(){
        return $this->premio;
    }

    public function getGanador(){
        return $this->ganador;
    }

    public function getTasaInscripcion(){
        return $this->tasaInscripcion;
    }
    public function setId($id){
        $this->idEvento = $id;
    }
    public function setTorneo($nombre){
        $this->nombre = $nombre;
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
        $this->descripcion = $descripcionEvento;

    }
    private static function inserta($evento)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO eventos ( inscritos, categoria, numJugadores, nombre, descripcion, fecha, lugar, estado, premio, ganador, tasaInscripcion) VALUES ('%s', %f, '%s', '%s', %f, %d)",
           // $evento->idEvento,
            $evento->inscritos,
            $conn->real_escape_string($evento->categoria),
            $evento->numJugadores,
            $conn->real_escape_string($evento->nombre),
            $conn->real_escape_string($evento->descripcion),
            $conn->real_escape_string($evento->fecha),
            $conn->real_escape_string($evento->lugar),
            $conn->real_escape_string($evento->estado),
            $evento->premio,
            $conn->real_escape_string($evento->ganador),
            $evento->tasaInscripcion,

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
            "DELETE FROM eventos WHERE idEvento = %d",
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
        $query = sprintf('SELECT * FROM eventos E WHERE E.idEvento = %d;', $idEvento); 
        $rs = null;
        try{
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Evento($fila['idEvento'],$fila['inscritos'],$fila['categoria'],$fila['numJugadores'], $fila['nombre'],$fila['descripcion'],$fila['fecha'],$fila['lugar'],$fila['estado'],$fila['premio'],$fila['ganador'],$fila['tasaInscripcion']);
            }
        } finally {
            if ($rs != null) {
                $rs->free();
            }
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
                    $fila['idEvento'],
                    $fila['inscritos'],
                    $fila['categoria'],
                    $fila['numJugadores'],
                    $fila['nombre'],
                    $fila['descripcion'],
                    $fila['fecha'],
                    $fila['lugar'],
                    $fila['estado'],
                    $fila['premio'],
                    $fila['ganador'],
                    $fila['tasaInscripcion'],
                );
                $eventos[] = $evento; 
            }
            $rs->free();
        }
        return $eventos;
    }


    public static function inscribirseEvento($idEvento) {
        $conn = BD::getInstance()->getConexionBd();
    
        // Verificar si el evento existe
        $evento = Evento::buscaPorId($idEvento);
        if (!$evento) {
            return false;
        }
    
        // Obtener el número actual de inscritos del evento
        $inscritosActuales = $evento->getInscritos();
    
        // Incrementar el número de inscritos
        $nuevosInscritos = $inscritosActuales + 1;
    
        // Actualizar el número de inscritos en la base de datos
        $query = sprintf("UPDATE eventos SET inscritos = %d WHERE idEvento = %d", $nuevosInscritos, $idEvento);
        $result = $conn->query($query);
    
        if ($result) {
            return true; // La inscripción se realizó correctamente
        } else {
            return false; // Hubo un error al actualizar el número de inscritos
        }

    }
    

    
    

}
