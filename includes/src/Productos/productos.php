<?php 


class Producto
{
    const MAX_SIZE = 500;
    
    use MagicProperties;
    private $id;

    private $nombre;

    private $precio;

    private $descripcion;

    private $imagen;

    private $valoracion;

    private $num_valoraciones;

    private $cantidad;

    private function __construct($id, $nombre, $precio, $descripcion, $imagen, $valoracion, $num_valoraciones,$cantidad)
    {
        $this->id = intval($id);
        $this->nombre = $nombre;
        $this->precio = floatval($precio);
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
        $this->valoracion = floatval($valoracion);
        $this->num_valoraciones = intval($num_valoraciones);
        $this->cantidad = intval($cantidad);
        $this->id = $id !== null ? intval($id) : null;
    }
    public static function crea($id, $nombre, $precio, $descripcion, $imagen, $valoracion, $num_valoraciones,$cantidad)
    {
        $m = new Producto($id, $nombre, $precio, $descripcion, $imagen, $valoracion, $num_valoraciones,$cantidad);
        return $m;
    }
    public static function listarProductoPrueba()
    {
        $conn = BD::getInstance()->getConexionBd();
        $query =" ";
       
        $query = sprintf("SELECT * FROM productos");
            
        
        $rs = $conn->query($query);
        $productos = array(); 
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $producto = new Producto(
                    $fila['id'],
                    $fila['nombre'],
                    $fila['precio'],
                    $fila['descripcion'],
                    $fila['imagen'],
                    $fila['valoracion'],
                    $fila['num_valoraciones'],
                    $fila['cantidad'],
                );
                $productos[] = $producto; 
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $productos;
    }
    public function Id()
    {
        return $this->id;
    }
    public function getIdProducto()
    {
        return $this->id;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function getPrecio()
    {
        return $this->precio;
    }
    
    public function descripcion()
    {
        return $this->descripcion;
    }
    
    public function getImagen()
    {
        return $this->imagen;
    }
    public function Imagen()
    {
        return $this->imagen;
    }
    public function getValoracion()
    {
        return $this->valoracion;
    }
    public function getCantidad()
    {
        return $this->cantidad;
    }
    
    public function getNumValoraciones()
    {
        return $this->num_valoraciones;
    }
    public function setId($id)
    {
        $this->idProducto = $id;
    }
    public function setNombre($nuevoNombre)
    {
        $this->nombre = $nuevoNombre;
    }

    public function setDescripcion($nuevaDescripcion)
    {
        if (mb_strlen($nuevaDescripcion) > self::MAX_SIZE) {
            throw new Exception(sprintf('El mensaje no puede exceder los %d caracteres', self::MAX_SIZE));
        }
        $this->descripcion = $nuevaDescripcion;
    }

    public function setPrecio($nuevoPrecio)
    {
        $this->precio = $nuevoPrecio;
    }
    public function setImagen($nuevaImagen)
    {
        $this->imagen = $nuevaImagen;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
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

    private static function borra($producto)
    {
        return self::borraPorId($producto->id);
    }


    public static function borraPorId($idProducto)
    {
        if (!$idProducto) {
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM productos WHERE id = %d", $idProducto);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
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
    
    public static function buscaPorNombre($nombreProducto = '')
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf("SELECT * FROM productos P WHERE P.nombre LIKE '%%%s%%'"
            , $conn->real_escape_string($nombreProducto)
        );

        $query .= ' ORDER BY P.precio DESC';

        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
            $result[] = new Producto($fila['id'], $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['imagen'], $fila['valoracion'], $fila['num_valoraciones'], $fila['cantidad']);
            }
            $rs->free();
        }

        return $result;
    }
    public function actualizarValoracion($nuevaValoracion) {
        $nuevaValoracionTotal = ($this->valoracion * $this->num_valoraciones) + $nuevaValoracion;

        $nuevoNumValoraciones = $this->num_valoraciones + 1;

        $nuevaValoracionPromedio = $nuevaValoracionTotal / $nuevoNumValoraciones;

        $this->valoracion = $nuevaValoracionPromedio;
        $this->num_valoraciones = $nuevoNumValoraciones;
    }

    public static function contarProductos()
    {
      $conn = BD::getInstance()->getConexionBd();
    
      $query = "SELECT COUNT(*) AS total FROM productos";
    
      $rs = $conn->query($query);
      $total = 0;
      if ($rs) {
        $fila = $rs->fetch_assoc();
        $total = $fila['total'];
        $rs->free();
      }
    
      return $total;
    }
    
    public static function buscaPorPrecioMaximo(&$maximoPrecio)
    {
        $result = [];
    
        $conn = BD::getInstance()->getConexionBd();
    
        $query = sprintf("SELECT * FROM productos P WHERE P.precio <= %f", $maximoPrecio);
    
        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['imagen'], $fila['valoracion'], $fila['num_valoraciones']);
            }
            $rs->free();
        }
    
        return $result;
    }
    public static function buscarPorValoracionMinima(&$valoracionMinima)
    {
        $result = [];
    
        $conn = BD::getInstance()->getConexionBd();
    
        $query = sprintf("SELECT * FROM productos WHERE valoracion >= %f", floatval($valoracionMinima));
    
        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['imagen'], $fila['valoracion'], $fila['num_valoraciones']);
            }
            $rs->free();
        }
    
        return $result;
    }    
    

    private static function inserta($producto)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO productos (nombre, precio, descripcion, imagen, valoracion, num_valoraciones, cantidad) VALUES ('%s', %f, '%s', '%s', %f, %d, %d)",
            $conn->real_escape_string($producto->nombre),
            $producto->precio,
            $conn->real_escape_string($producto->descripcion),
            $conn->real_escape_string($producto->imagen),
            $producto->valoracion,
            $producto->num_valoraciones,
            $producto->cantidad
        );
        $result = $conn->query($query);
        if ($result) {
            $producto->id = $conn->insert_id;
            $result = $producto;
        } else {
            error_log($conn->error);
        }

        return $result;
    }


    public static function actualiza($producto)
    {
        $result = false;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE productos P SET nombre = '%s', precio = %f, descripcion = '%s', imagen = '%s', valoracion = %f, num_valoraciones = %d WHERE P.id = %d",
            $conn->real_escape_string($producto->nombre),
            $producto->precio,
            $conn->real_escape_string($producto->descripcion),
            $conn->real_escape_string($producto->imagen),
            $producto->valoracion,
            $producto->num_valoraciones,
            $producto->id
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' !");
        }
    
        return $result;
    }

    public static function elimina($id_producto)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "DELETE FROM productos WHERE id = %d",
            $id_producto
        );
        $result = $conn->query($query);

        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("No se ha eliminado ningún producto.");
        }

        return $result;
    }


}
