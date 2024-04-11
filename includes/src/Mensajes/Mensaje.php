<?php
require_once __DIR__ . '/../../traits/MagicProperties.php'; 
namespace es\ucm\fdi\aw\src\Mensajes;
use \es\ucm\fdi\aw\src\BD;

class Mensaje
{
    public const MAX_SIZE = 200;

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private $id;

    private $idEmisor;

    private $idDestinatario;

    private $idForo;

    private $texto;

    private $fechaHora;

    private function __construct($id = null, $idEmisor, $idDestinatario, $idForo, $texto, $fechaHora = null)
    {
        $this->id = $id !== null ? intval($id) : null;
        $this->idEmisor = $idEmisor !== null ? intval($idEmisor) : null;
        $this->idDestinatario = $idDestinatario !== null ? intval($idDestinatario) : null;
        $this->idForo = $idForo !== null ? intval($idForo) : null;
        $this->texto = $texto;
        $this->fechaHora = $fechaHora !== null ? DateTime::createFromFormat(self::DATE_FORMAT, $fechaHora) :  new DateTime();
        $this->idForo = $idForo !== null ? intval($idForo) : null;
    }

    public static function crea($id, $idEmisor, $idDestinatario, $idForo, $texto, $es_privado)
    {
        $m = new Mensaje($id, $idEmisor, $idDestinatario, $idForo, $texto, date('Y-m-d H:i:s'), $es_privado);
        return $m;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdEmisor()
    {
        return $this->idEmisor;
    }

    public function getIdDestinatario()
    {
        return $this->idDestinatario;
    }

    public function getIdForo()
    {
        return $this->idForo;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function getFechaYHora()
    {
        return $this->fechaHora?->format(self::DATE_FORMAT);
    }

    public function setIdEmisor($idEmisor)
    {
        $this->idEmisor = $idEmisor;
    }

    public function setIdDestinatario($idDestinatario)
    {
        $this->idDestinatario = $idDestinatario;
    }

    private function generarFechaActual()
    {
        return date(self::DATE_FORMAT);
    }

    public function setMensaje($nuevoMensaje)
    {
        if (mb_strlen($nuevoMensaje) > self::MAX_SIZE) {
            throw new Exception(sprintf('El mensaje no puede exceder los %d caracteres', self::MAX_SIZE));
        }
        $this->texto = $nuevoMensaje;
    }

    public static function buscaPorIdEmisor($idEmisor)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM mensajes WHERE idEmisor=%d", $idEmisor);

        $query .= ' ORDER BY fechaHora DESC';

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Mensaje($fila['id'], $idEmisor, $fila['idDestinatario'], $fila['idForo'], $fila['mensaje'],
                                        $fila['fechaHora']);
            }
            $rs->free();
        }else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function buscaPorIdDestinatario($idDestinatario)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM mensajes WHERE idDestinatario=%d", $idDestinatario);

        $query .= ' ORDER BY fechaHora DESC';

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Mensaje($fila['id'],$fila['idEmisor'], $idDestinatario, $fila['idForo'], $fila['mensaje'],
                                        $fila['fechaHora']);
            }
            $rs->free();
        }else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function buscaPorEmisorYDestinatario($idEmisor, $idDestinatario)
    {
    $result = [];
    $conn = BD::getInstance()->getConexionBd();
    $query = sprintf("SELECT * FROM mensajes WHERE idEmisor=%d AND idDestinatario=%d", $idEmisor, $idDestinatario);

    $query .= ' ORDER BY fechaHora DESC';

    $rs = $conn->query($query);
    if ($rs) {
        while ($fila = $rs->fetch_assoc()) {
            $result[] = new Mensaje($idEmisor, $idDestinatario, $fila['idForo'], $fila['mensaje'],
                                    $fila['fechaHora']);
        }
        $rs->free();
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }

    return $result;
    }

    public static function numMensajesPorIdEmisor($idEmisor = null)
    {
        $result = 0;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT COUNT(*) FROM mensajes M WHERE M.idEmisor = %d;', $idEmisor);
        $rs = $conn->query($query);

        if ($rs) {
            $result = (int) $rs->fetch_row()[0];
            $rs->free();
        }
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function numMensajesPorIdDestinatario($idDestinatario = null)
    {
        $result = 0;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT COUNT(*) FROM mensajes M WHERE M.idDestinatario = %d;', $idDestinatario);
        $rs = $conn->query($query);

        if ($rs) {
            $result = (int) $rs->fetch_row()[0];
            $rs->free();
        }
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function numMensajesPorIdForo($idForo = null)
    {
        $result = 0;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT COUNT(*) FROM mensajes M WHERE M.idForo = %d;', $idForo);
        $rs = $conn->query($query);

        if ($rs) {
            $result = (int) $rs->fetch_row()[0];
            $rs->free();
        }
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idMensaje)
    {
        $result = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM mensajes M WHERE M.id = %d;', $idMensaje);
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            while ($fila = $rs->fetch_assoc()) {
                $result =  new Mensaje($idMensaje, $fila['idEmisor'], $fila['idDestinatario'], $fila['idForo'] $fila['mensaje'],
                $fila['fechaHora']);
            }
            $rs->free();
        }
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function inserta($mensaje)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO mensajes (idEmisor, idDestinatario, idForo, texto, fechaHora) VALUES (%d, %d, %d, '%s', '%s')",
            $mensaje->idEmisor,
            $mensaje->idDestinatario,
            $mensaje->idForo,
            $conn->real_escape_string($mensaje->texto),
            $conn->real_escape_string($mensaje->fechaYHora)
        );
        $result = $conn->query($query);
        if ($result) {
            $mensaje->id = $conn->insert_id;
            $result = $mensaje;
        } else {
            error_log($conn->error);
        }

        return $result;
    }

    private static function actualiza($mensaje)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE mensajes M SET idEmisor = %, idDestinatario = %d, idDestinatario = %d, idForo = %d, texto = '%s', fechaHora = '%s'WHERE M.id = %d",
            $mensaje->idEmisor,
            $mensaje->idDestinatario,
            $mensaje->idForo,
            $conn->real_escape_string($mensaje->texto),
            $conn->real_escape_string($mensaje->fechaYHora)
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' !");
        }

        return $result;
    }

    private static function borra($mensaje)
    {
        return self::borraPorId($mensaje->id);
    }

    public static function borraPorId($idMensaje)
    {
        if (!$idMensaje) {
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM mensajes WHERE id = %d", $idMensaje);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public function guarda()
    {
        if (!$this->id) {
            self::inserta($this);
        } else {
            self::actualiza($this);
        }

        return $this;
    }
    
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}
