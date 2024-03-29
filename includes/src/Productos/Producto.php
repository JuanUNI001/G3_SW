<?php 
namespace es\ucm\fdi\aw\src\Productos;
use \es\ucm\fdi\aw\src\BD;

$bdDatosConexion = array(
    'host' => BD_HOST,
    'bd' => BD_NAME,
    'user' => BD_USER,
    'pass' => BD_PASS
);
BD::getInstance()->init($bdDatosConexion);
class Producto
{
    const MAX_SIZE = 500;
    
   
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
        $m = new  es\ucm\fdi\aw\Producto($id, $nombre, $precio, $descripcion, $imagen, $valoracion, $num_valoraciones,$cantidad);
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
        }
        return $productos;
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
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function getImagen()
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
            // Actualiza la información del producto en la base de datos
            $result = self::actualiza($this);
            // Actualiza la cantidad del producto en la base de datos
            $resultCantidad = self::actualizaCantidad($this->id, $this->cantidad);
            // Verifica si ambas operaciones fueron exitosas
            if ($result && $resultCantidad) {
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

    private static function borra($producto)
    {
        return self::borraPorId($producto->id);
    }


    public static function borraPorId($id_producto)
    {
        if (!$id_producto) {
            return false;
        } 
        
        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "DELETE FROM productos WHERE id = %d",
            $id_producto
        );
        $conn->query($query);

    }
    public static function buscaPorId($idProducto)
    {
        $result = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM productos P WHERE P.id = %d;', $idProducto); 
        $rs = null;
        try{
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto($fila['id'], $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['imagen'], $fila['valoracion'], $fila['num_valoraciones'], $fila['cantidad']);
            }
        } finally {
            if ($rs != null) {
                $rs->free();
            }
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
        try{
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            while($fila) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['imagen'], $fila['valoracion'], $fila['num_valoraciones'], $fila['cantidad']);
            }
        } finally {
            if ($rs != null) {
                $rs->free();
            }
        }
        return $result;        
    }
    public static function actualizaCantidad($id_producto, $nueva_cantidad)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE productos SET cantidad = %d WHERE id = %d",
            $nueva_cantidad,
            $id_producto
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' filas!");
        }

        return $result;
    }

    public function actualizarValoracion($nuevaValoracion) {
        $nuevaValoracionTotal = ($this->valoracion * $this->num_valoraciones) + $nuevaValoracion;
        $nuevoNumValoraciones = $this->num_valoraciones + 1;
        $nuevaValoracionPromedio = $nuevaValoracionTotal / $nuevoNumValoraciones;
    
        // Actualizar en la base de datos
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE productos SET valoracion = %f, num_valoraciones = %d WHERE id = %d",
            $nuevaValoracionPromedio,
            $nuevoNumValoraciones,
            $this->id
        );
    
        try {
            $result = $conn->query($query);
            if ($result) {              
                $this->valoracion = $nuevaValoracionPromedio;
                $this->num_valoraciones = $nuevoNumValoraciones;
            }
        
        } finally {
          
        }
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
        try {
            $conn->query($query);
            $usuario->id = $conn->insert_id;
            $result = $producto;
            return $result;
        } catch( \mysqli_sql_exception $e) {
            if ($conn->sqlstate == 23000) { // código de violación de restricción de integridad (PK)
                throw new ProductoYaExistenteException("Ya existe el producto {$producto->nombre}");
            }
        }
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
        return $result;
    }
    
    


}
