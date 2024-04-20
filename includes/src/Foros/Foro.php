<?php 
namespace es\ucm\fdi\aw\src\Foros;
use \es\ucm\fdi\aw\src\BD;


class Foro
{
    public const MAX_SIZE = 25;

    private $id;

    private $autor;

    private $titulo;

    private function __construct($id, $autor, $titulo)
    {
        $this->id =  intval($id) ;
        $this->autor = $autor;
        $this->titulo = $titulo;
    }

    public static function crea($id, $autor, $titulo)
    {
        $m = new Foro($id, $autor, $titulo);
        return $m;
    }

    public static function listarForos()
    {
        $conn = BD::getInstance()->getConexionBd();
        $query =" ";
       
        $query = sprintf("SELECT * FROM foros");
            
        
        $rs = $conn->query($query);
        $foros = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $foro = new Foro(
                    $fila['id'],
                    $fila['autor'],
                    $fila['titulo']
                );
                $foros[] = $foro; 
            }
            $rs->free();
        }
        return  $foros;
    }
    public static function listarForosBusqueda($autor, $tema, $orden)
    {
        $conn = BD::getInstance()->getConexionBd();
        
        // Inicializar la consulta SQL con la parte común
        $query = "SELECT * FROM foros WHERE 1 = 1";
        
        // Agregar filtros según los parámetros proporcionados
        if (!empty($autor)) {
            $query .= " AND autor LIKE '%" . $conn->real_escape_string($autor) . "%'";
        }
        if (!empty($tema)) {
            $query .= " AND titulo LIKE '%" . $conn->real_escape_string($tema) . "%'";
        }
        
        // Agregar filtro de ordenamiento si se proporciona
        switch ($orden) {
            case '1':
                // Ordenar por autor
                $query .= " ORDER BY autor ASC";
                break;
            case '2':
                // Ordenar por tema
                $query .= " ORDER BY titulo ASC";
                break;
            default:
                // No hacer nada si el orden no es válido
                break;
        }

        // Ejecutar la consulta
        $rs = $conn->query($query);
        $foros = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $foro = new Foro(
                    $fila['id'],      
                    $fila['autor'],   
                    $fila['titulo']
                );
                $foros[] = $foro; 
            }
            $rs->free();
        }
        return $foros;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAutor()
    {
        return $this->autor;
    }
    
    public function getTitulo()
    {
        return $this->titulo;
    }
    
    public function setId($id)
    {
        $this->idProducto = $id;
    }

    public function setTitulo($nuevo_titulo)
    {
        if (mb_strlen($nuevo_titulo) > self::MAX_SIZE) {
            throw new Exception(sprintf('El titulo no puede exceder los %d caracteres', self::MAX_SIZE));
        }
        $this->titulo = $nuevo_titulo;
    }

    public function guarda()
    {
        if (!$this->id) {
            self::inserta($this);
        } else {
            // Actualiza la información en la base de datos
            $result = self::actualiza($this);         
            if ($result) {
                return $this;
            } else {
                return false;
            }
        }
    }

    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }

    private static function borra($foro)
    {
        return self::borraPorId($foro->id);
    }


    public static function borraPorId($id_foro)
    {
        if (!$id_foro) {
            return false;
        } 
        
        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "DELETE FROM foros WHERE id = %d",
            $id_foro
        );
        $conn->query($query);

    }

    public static function buscaPorId($id_foro)
    {
        $result = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM foros F WHERE F.id = %d;', $id_foro); 
        $rs = null;
        try{
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Foro(
                    $fila['id'],
                    $fila['autor'],
                    $fila['titulo']
                );
            }
        } finally {
            if ($rs != null) {
                $rs->free();
            }
        }
        return $result; 
    }
    
    public static function buscaPorTitulo($tituloForo = '')
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM foros F WHERE F.titulo LIKE '%%%s%%'"
            , $conn->real_escape_string($tituloForo)
        );

        try{
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            while($fila) {
                $result[] = new Foro(
                    $fila['id'],
                    $fila['autor'],
                    $fila['titulo']
                );
            }
        } finally {
            if ($rs != null) {
                $rs->free();
            }
        }
        return $result;        
    }

    public static function contarForos()
    {
      $conn = BD::getInstance()->getConexionBd();
    
      $query = "SELECT COUNT(*) AS total FROM foros";
    
      $rs = $conn->query($query);
      $total = 0;
      if ($rs) {
        $fila = $rs->fetch_assoc();
        $total = $fila['total'];
        $rs->free();
      }
    
      return $total;
    }
    
    private static function inserta($foro)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "INSERT INTO foros (titulo, autor) VALUES ('%s', '%s')",
            $conn->real_escape_string($foro->getTitulo()),
            $conn->real_escape_string($foro->getAutor())
        );

        if ($conn->query($query)) {
            $foro->id = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
    }


    public static function actualiza($foro)
    {
        $result = false;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE foros F SET titulo = '%s', autor = %s WHERE F.id = %d",
            $conn->real_escape_string($foro->titulo),
            $conn->real_escape_string($foro->autor)
        );
        $result = $conn->query($query);        
        return $result;
    }
    
    


}
