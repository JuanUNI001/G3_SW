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

    private $es_privado;

    private $texto;

    private $fechaHora;

    private function __construct($idEmisor, $idDestinatario, $texto, $fechaHora = null, $es_privado, $id = null)
    {
        $this->idEmisor = intval($idEmisor);
        $this->idDestinatario = intval($idDestinatario);
        $this->es_privado = $es_privado;
        $this->texto = $texto;
        $this->fechaHora = $fechaHora !== null ? DateTime::createFromFormat(self::DATE_FORMAT, $fechaHora) :  new DateTime();
       
        //$this->id = $id !== null ? intval($id) : null;
    }

    public static function crea($idEmisor, $idDestinatario, $texto, $es_privado, $id)
    {
        $m = new Mensaje($idEmisor, $idDestinatario, $texto, date('Y-m-d H:i:s'), $es_privado, $id);
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

    public function getTexto()
    {
        return $this->texto;
    }

    public function getEsPrivado()
    {
        return $this->es_privado;
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
                $result[] = new Mensaje($idEmisor, $fila['idDestinatario'], $fila['mensaje'],
                                        $fila['fechaHora'], $fila['es_privado'], $fila['id']);
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
                $result[] = new Mensaje($fila['idEmisor'], $idDestinatario, $fila['mensaje'],
                                        $fila['fechaHora'], $fila['es_privado'], $fila['id']);
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
            $result[] = new Mensaje($idEmisor, $idDestinatario, $fila['mensaje'],
                                    $fila['es_privado'], $fila['fechaHora'], $fila['id']);
        }
        $rs->free();
    } else {
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }

    return $result;
    }

    public static function buscaPorContenido($textoMensaje = '', $numPorPagina = 0, $numPagina = 0)
    {
      $result = [];
  
      $conn = BD::getInstance()->getConexionBd();
  
      $query = sprintf("SELECT * FROM mensajes M WHERE M.mensaje LIKE '%%%s%%'"
        , $conn->real_escape_string($textoMensaje)
      );
  
      $query .= ' ORDER BY M.fechaHora DESC';
  
      if ($numPorPagina > 0) {
        $query .= " LIMIT $numPorPagina";
      
        /* XXX NOTA: Este método funciona pero poco eficiente (OFFSET y LIMIT se aplican una vez se ha ejecutado la
         * consulta), lo utilizo por simplicidad. En un entorno real se debe utilizar la cláusula WHERE para "saltar"
         * los elementos que NO interesen y utilizar exclusivamente la cláusula LIMIT
         */
        $offset = $numPagina * ($numPorPagina - 1);
        if ($offset > 0) {
          $query .= " OFFSET $offset";
        }
      }
  
      $rs = $conn->query($query);
      if ($rs) {
        while($fila = $rs->fetch_assoc()) {
          $result[] = new Mensaje($fila['idEmisor'], $fila['idDestinatario'], $fila['mensaje'],
          $fila['fechaHora'], $fila['es_privado'], $fila['id']);
        }
        $rs->free();
      }else {
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

    public static function buscaPorId($idMensaje)
    {
        $result = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM mensajes M WHERE M.id = %d;', $idMensaje);
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            while ($fila = $rs->fetch_assoc()) {
                $result =  new Mensaje($fila['idEmisor'], $fila['idDestinatario'], $fila['mensaje'],
                $fila['fechaHora'], $fila['es_privado'], $idMensaje);
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
            "INSERT INTO mensajes (idEmisor, idDestinatario, texto, fechaHora, es_privado) VALUES (%d, %d, '%s', '%s', %d)",
            $mensaje->idEmisor,
            $mensaje->idDestinatario,
            $conn->real_escape_string($mensaje->texto),
            $conn->real_escape_string($mensaje->fechaYHora),
            $mensaje->es_privado
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
            "UPDATE mensajes M SET idEmisor = %, idDestinatario = %d, texto = '%s', fechaHora = '%s', es_privado = %d WHERE M.id = %d",
            $mensaje->idEmisor,
            $mensaje->idDestinatario,
            $conn->real_escape_string($mensaje->texto),
            $conn->real_escape_string($mensaje->fechaYHora),
            $mensaje->es_privado
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
