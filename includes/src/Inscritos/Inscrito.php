<?php
namespace es\ucm\fdi\aw\src\Inscritos;
use \es\ucm\fdi\aw\src\BD;
use \es\ucm\fdi\aw\src\Eventos\Evento;

class Inscrito
{  
    
    private $idEvento;

    private $idUsuario;


    private function __construct($idEvento, $idUsuario)
    {
        $this->idEvento = $idEvento;
        $this->idUsuario = $idUsuario;
    }

    public static function crea($idEvento,$idUsuario)
    {
        return new Inscrito($idEvento, $idUsuario);
    }

    public function getIdEvento()
    {
        return $this->idEvento;
    }

    public function getIdUser()
    {
        return $this->idUsuario;
    }

    public function setIdEvento($idEvento)
    {
        $this->idEvento = $idEvento;
    }

    public function setIdUser($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public static function eliminarPorUserYEven($idEvento,$idUsuario)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM inscritos WHERE idUsuario = %d AND idEvento = %d", $idUsuario, $idEvento);

        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public static function estaUsuarioInscritoEnEvento($idUsuario, $idEvento) {
        $conn = BD::getInstance()->getConexionBd();
    
        $query = sprintf("SELECT COUNT(*) AS numFilas FROM inscritos WHERE idUsuario = %d AND idEvento = %d", $idUsuario, $idEvento);
    
        $result = $conn->query($query);
    
        $numFilas = $result->fetch_assoc()['numFilas'];
    
        return $numFilas > 0;
    }
    

    public static function inscribirUsuarioEnEvento($idUsuario, $idEvento) {
        $conn = BD::getInstance()->getConexionBd();

        if (self::estaUsuarioInscritoEnEvento($idUsuario, $idEvento)) {
            error_log("Ya está inscrito en este evento!!");
            return false; // El usuario ya está inscrito
        }
    
        $query = sprintf("INSERT INTO inscritos (idUsuario, idEvento) VALUES (%d, %d)", $idUsuario, $idEvento);
    
        $result = $conn->query($query);
    
        if (!$result) {
            error_log($conn->error);
        }
        return true;
    }
    
    

}