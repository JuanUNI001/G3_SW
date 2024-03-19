<?php 
use es\ucm\fdi\aw\src\BD;
require_once __DIR__.'/../BD.php';
$bdDatosConexion = array(
    'host' => BD_HOST,
    'bd' => BD_NAME,
    'user' => BD_USER,
    'pass' => BD_PASS
);
BD::getInstance()->init($bdDatosConexion);

class Pedidos_producto
{
    const MAX_SIZE = 500;
    
    use MagicProperties;
    

    private $id_pedido;

    private $id_producto;

    private $cantidad;


    private function __construct($id_pedido, $id_producto, $cantidad)
    {
        $this->id_pedido = intval($id_pedido);
        $this->id_producto = intval($id_producto);
        $this->cantidad = intval($cantidad);       
        $this->id_pedido = $id_pedido !== null ? intval($id_pedido) : null;
    }
    public static function crea($id_pedido, $id_producto, $cantidad)
    {
        $m = new Pedidos_producto($id_pedido, $id_producto, $cantidad);
        return $m;
    }
    

    public function getId_pedido_producto()
    {
        return $this->id_pedido;
    }
    
    public function getId_producto_pedido()
    {
        return $this->id_producto;
    }
    
    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setId_pedido_producto($id)
    {
        $this->id_pedido = $id;
    }
    public function setId_producto_pedido($id)
    {
        $this->id_producto = $id;
    }
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }
    public function guarda()
    {
        if (!$this->id_pedido) {
            self::inserta($this);
        } else {
            self::actualiza($this);
        }

        return $this;
    }
    
    public function borrate()
    {
        if ($this->id_pedido !== null) {
            return self::borra($this);
        }
        return false;
    }

    private static function borra($pedido_producto)
    {
        return self::borraPorId($pedido_producto->id_pedido);
    }


    public static function borraPorId($id_pedido)
    {
        if (!$id_pedido) {
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM pedidos_productos WHERE id_producto = %d", $id_pedido);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }
    public static function buscaPorIdPedido_Producto($id_pedido)
    {
        $result = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos_productos P WHERE P.id_pedido = %d;', $id_pedido); 
        $rs = null;
        try{
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Pedidos_producto($fila['id_pedido'], $fila['id_producto'], $fila['cantidad']);
            }
        }
       finally {
            if ($rs != null) {
                $rs->free();
            }
        }
        return $result;
    }
    
    public static function buscaPorIdProducto_Pedido($id_producto)
    {
        $result = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos_productos P WHERE P.id_producto = %d;', $id_producto); 
        $rs = null;
        try{
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Pedidos_producto($fila['id_pedido'], $fila['id_producto'], $fila['cantidad']);
            }          
        }
        finally {
            if ($rs != null) {
                $rs->free();
            }
        }
        return $result;
    }   
    

    private static function inserta($pedidos_producto)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO pedidos_productos (id_pedido, id_producto, cantidad) VALUES ('%d', %d, '%d')",
            $pedidos_producto->id_pedido,
            $pedidos_producto->id_producto,
            $pedidos_producto->cantidad
        );
        $result = $conn->query($query);
        if ($result) {
            $pedidos_producto->id_pedido = $conn->insert_id;
            $result = $pedidos_producto;
        } else {
            error_log($conn->error);
        }

        return $result;
    }


    public static function actualiza($pedidos_producto)
    {
        $result = false;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE pedidos_productos P SET id_pedido = %d, id_producto = %d, cantidad = %d",
            $pedidos_producto->id_pedido,
            $pedidos_producto->id_producto,
            $pedidos_producto->cantidad
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' !");
        }
    
        return $result;
    }

    


}
