<?php 
namespace es\ucm\fdi\aw\src\Foros;
use \es\ucm\fdi\aw\src\BD;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

class Foro
{
    public const MAX_SIZE_TITULO = 25;
    public const MAX_SIZE_DESCRIPCION = 40;

    private $id;

    private $autor;

    private $descripcion;

    private $titulo;

    private function __construct($id, $autor, $titulo, $descripcion )
    {
        $this->id =  intval($id) ;
        $this->autor = intval($autor);
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
    }

    public static function crea($id, $autor, $titulo,$descripcion)
    {
        $m = new Foro($id, $autor, $titulo,$descripcion);
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
                    $fila['autor_id'],
                    $fila['titulo'],
                    $fila['descripcion']
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
        
        $query = "SELECT * FROM foros WHERE 1";
        
        if (!empty($autor)) {
            // Buscar usuario por nombre
            $usuarios = Usuario::listarUsuariosBusquedaForo($autor, '', '', '');
            $autorIds = array_map(function($usuario) {
                return $usuario->getId();
            }, $usuarios);
            $autorIdsString = implode(',', $autorIds);
            $query .= " AND autor_id IN ($autorIdsString)";
        }
        if (!empty($tema)) {
            $query .= " AND titulo LIKE '%" . $conn->real_escape_string($tema) . "%'";
        }
        
        switch ($orden) {
            case '1':
                $query .= " ORDER BY autor ASC";
                break;
            case '2':
                $query .= " ORDER BY titulo ASC";
                break;
            default:
                break;
        }
    
        $rs = $conn->query($query);
        $foros = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $foro = new Foro(
                    $fila['id'],      
                    $fila['autor_id'],   
                    $fila['titulo'],
                    $fila['descripcion']
                );
                $foros[] = $foro; 
            }
            $rs->free();
        }
        return $foros;
    }
    

    public static function buscaForo($idForo)
    {
        $conn = BD::getInstance()->getConexionBd();
        
        $query = "SELECT * FROM foros WHERE id = " . $idForo;
        
        $rs = $conn->query($query);
        $foro = null; 
        if ($rs) {
            $fila = $rs->fetch_assoc(); // Obtener la fila de resultados
            // Verificar si se encontraron resultados
            if ($fila) {
                $foro = new Foro(
                    $fila['id'],      
                    $fila['autor_id'],   
                    $fila['titulo'],
                    $fila['descripcion']
                );
            }
            $rs->free();
        }
        return $foro;
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

    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function setId($id)
    {
        $this->idProducto = $id;
    }

    public function setTitulo($nuevo_titulo)
    {
        if (mb_strlen($nuevo_titulo) > self::MAX_SIZE_TITULO) {
            throw new Exception(sprintf('El titulo no puede exceder los %d caracteres', self::MAX_SIZE_TITULO   ));
        }
        $this->titulo = $nuevo_titulo;
    }

    public function setDescripcion($nueva_descripcion)
    {
        if (mb_strlen($nueva_descripcion) > self::MAX_SIZE_DESCRIPCION) {
            throw new Exception(sprintf('La descripcion no puede exceder los %d caracteres', self::MAX_SIZE_DESCRIPCION));
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
        $result = $conn->query($query);
       
        return true;
    }
    
    public static function eliminarForosPorIdAutor($idAutor)
    {
        $conn = BD::getInstance()->getConexionBd();
    
        $query = sprintf("DELETE FROM foros WHERE autor_id = %d", $idAutor);
    
        $result = $conn->query($query);
        
        return $result !== false; 
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
                    $fila['autor_id'],
                    $fila['titulo'],
                    $fila['descripcion']
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
                    $fila['autor_id'],
                    $fila['titulo'],
                    $fila['descripcion']
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
            "INSERT INTO foros ( titulo, autor_id, descripcion) VALUES ('%s', '%d', '%s')",
            $conn->real_escape_string($foro->getTitulo()),
            $foro->getAutor(),
            $conn->real_escape_string($foro->getDescripcion())
        );

        if ($conn->query($query)) {
            $foro->id = $conn->insert_id;
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
      
        
        return $result;
    }



    public static function actualiza($foro)
    {
        $result = false;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE foros F SET titulo = '%s', autor_id = %s, descripcion = '%s' WHERE F.id = %d",
            $conn->real_escape_string($foro->titulo),
            $conn->$foro->autor,
            $conn->real_escape_string($foro->getDescripcion())
        );
        $result = $conn->query($query);        
        return $result;
    }
    
    


}
