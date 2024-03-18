<?php 


class Pedido
{  
    use MagicProperties;
    
    private $id;

    private $id_user;

    bool $estado;

    date $fecha;

    private function __construct($id, $id_user, $estado)
    {
        $this->id = intval($id);
        $this->id_user = intval($id_user);
        $this->estado = $estado;

        $this->id = $id !== null ? intval($id) : null;
        $this->id_user = $id_user !== null ? intval($id_user) : null;
    }

    public static function crea($id, $id_user, $id_user)
    {
        $p = new Pedido($id, $id_user, $id_user);
        return $p;
    }
    
    public static function listarPedidoPrueba()
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
    public function getId()
    {
        return $this->id;
    }
    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getEstado()
    {
        return $this->estado;
    }
    
    public function setId($id)
    {
        $this->idProducto = $id;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function setEstado($nuevoEstado)
    {
        $this->estado = $nuevoEstado;
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

    private static function borra($pedido)
    {
        return self::borraPorId($pedido->id);
    }


    public static function borraPorId($idPedido)
    {
        if (!$idPedido) {
            return false;
        }
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM pedidos WHERE id = %d", $idPedido);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }
    public static function buscarPedido($idPedido)
    {
        $result = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos P WHERE P.id = %d;', $idPedido); 
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            while ($fila = $rs->fetch_assoc()) {
                $result = new Producto($fila['id'], $fila['nombre'], $fila['precio'], $fila['descripcion'], $fila['imagen'], $fila['valoracion'], $fila['num_valoraciones'], $fila['cantidad']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function cantidad_Productos()
    {
      $conn = BD::getInstance()->getConexionBd();
    
      $query = sprintf('SELECT COUNT(*) AS total FROM pedidos P WHERE P.id = %d;', $idPedido); 

      $rs = $conn->query($query);
      $total = 0;
      if ($rs) {
        $fila = $rs->fetch_assoc();
        $total = $fila['total'];
        $rs->free();
      }
    
      return $total;
    }
    
    private static function inserta($pedido)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO pedidos (id, id_user, estado)", getId(), get_idUser());
        $result = $conn->query($query);
        if ($result) {
            $producto->id = $conn->insert_id;
            $result = $producto;
        } else {
            error_log($conn->error);
        }

        return $result;
    }


    public static function actualiza($pedido)
    {
        $result = false;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE pedidos P SET id = '%f', id_user = %f, estado = '%d' WHERE P.id = %d",
            $pedido->id,
            $pedido->id_user,
            $pedido->estado
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' !");
        }
    
        return $result;
    }

    public static function elimina($id_pedido)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();

        $query = sprintf(
            "DELETE FROM pedidos WHERE id = %d",$id_pedido);
        $result = $conn->query($query);

        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("No se ha eliminado ningún producto.");
        }

        return $result;
    }


}
