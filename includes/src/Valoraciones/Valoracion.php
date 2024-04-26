<?php
namespace es\ucm\fdi\aw\src\Valoraciones;
use \es\ucm\fdi\aw\src\BD;
use \es\ucm\fdi\aw\src\Productos\Producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \DateTime;

class Valoracion
{  
    
    private $id_producto;

    private $id_user;

    private $valoracion;

    private $comentario;

    private function __construct($id_user, $id_producto, $valoracion, $comentario)
    {
        $this->id_user = $id_user;
        $this->id_producto = $id_producto;
        $this->valoracion = $valoracion;
        $this->comentario = $comentario;
    }

    public static function crea($id_user, $id_producto, $valoracion, $comentario)
    {      
        return new Valoracion($id_user, $id_producto, $valoracion, $comentario);
    }
    public function getIdUsuario()
    {
        return $this->id_user;
    }
    
    public function getIdProducto()
    {
        return $this->id_producto;
    }
    
    public function getValoracion()
    {
        return $this->valoracion;
    }
    
    public function getComentario()
    {
        return $this->comentario;
    }
    public function guarda()
    {
        if (!$this->id_user || !$this->id_producto) {
            // Si la valoración no tiene un usuario o producto asociado, no se puede guardar
            return false;
        }

        if (!self::comrpuebaExisteValoracion($this->id_user, $this->id_producto)) {
            // Si la valoración no existe en la base de datos, se inserta como una nueva
            if (!self::inserta($this)) {
                // Manejar el caso en que la inserción falle
                return false;
            }
        } else {
            // Si la valoración ya existe en la base de datos, se actualiza
            if (!self::actualiza($this)) {
                // Manejar el caso en que la actualización falle
                return false;
            }
        }

        return true;
    }
    public static function inserta($valoracion)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO valoraciones (id_user, id_producto, valoracion, comentario) VALUES (%d, %d, %f, '%s')",
            $valoracion->getIdUsuario(),
            $valoracion->getIdProducto(),
            $valoracion->getValoracion(),
            $conn->real_escape_string($valoracion->getComentario())
        );
    
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
            return false;
        }
        return true;
    }
    
    public static function actualiza($valoracion)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE valoraciones SET valoracion = %f, comentario = '%s' WHERE id_user = %d AND id_producto = %d",
            $valoracion->getValoracion(),
            $conn->real_escape_string($valoracion->getComentario()),
            $valoracion->getIdUsuario(),
            $valoracion->getIdProducto()
        );
    
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
            return false;
        } elseif ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' filas!");
            return false;
        }
        return true;
    }
    
    public static function comrpuebaExisteValoracion($id_user, $id_producto){
        $conn = BD::getInstance()->getConexionBd();
    
        $query = sprintf('SELECT * FROM valoraciones WHERE id_user = %d AND id_producto = %d', $id_user, $id_producto);
        
        $result = $conn->query($query);
    
        if ($result && $result->num_rows > 0) {
            $result->free();
            return true; 
        }
    
        $result->free();
        return false; 

    }
    public static function buscaValoracion($id_user, $id_producto)
    {
        $conn = BD::getInstance()->getConexionBd();
        
        $query = sprintf('SELECT * FROM valoraciones WHERE id_user = %d AND id_producto = %d', $id_user, $id_producto);
        
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $valoracion = $result->fetch_assoc();
            $result->free();
            return Valoracion::crea($valoracion['id_user'], $valoracion['id_producto'], $valoracion['valoracion'], $valoracion['comentario']);
        }

        $result->free();
        return null; 
    }
    public static function listarValoracion($id_producto)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM valoraciones WHERE id_producto = %d', $id_producto);
        $result = $conn->query($query);
    
        $valoraciones = array();
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $valoraciones[] = Valoracion::crea($row['id_user'], $row['id_producto'], $row['valoracion'], $row['comentario']);
            }
            $result->free();
        }
    
        return $valoraciones;
    }
    
}