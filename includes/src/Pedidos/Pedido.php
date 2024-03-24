<?php
namespace es\ucm\fdi\aw\src\Pedidos;
use es\ucm\fdi\aw\src\BD;
use \DateTime;



class Pedido
{  
    
    private $id_pedido;

    private $id_user;

    private $estado;

    private $fecha;

    private function __construct($id_pedido, $id_user, $estado)
    {
        $this->id_pedido = intval($id_pedido);
        $this->id_user = intval($id_user);
        $this->estado = $estado;
        $fecha = new \DateTime();
        $fecha = $fecha->format('Y-m-d H:i:s');
        $this->id_pedido = $id_pedido !== null ? intval($id_pedido) : null;
        $this->id_user = $id_user !== null ? intval($id_user) : null;
    }

    public static function crea($id_pedido, $id_user, $estado)
    {
        $p = new Pedido($id_pedido, $id_user, $estado);
        return $p;
    }
    
    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function setId($id_pedido)
    {
        $this->idProducto = $id_pedido;
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
        if (!$this->id_pedido) {
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
        return self::borraPorId($pedido->id_pedido);
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
    public static function buscarPedidoPorEstadoUsuario($estado, $id_usuario)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos WHERE estado = "%s" AND id_user = %d', $estado, $id_usuario);
        $result = $conn->query($query);
    
        if ($result && $result->num_rows > 0) {
            // Si se encuentra un pedido en el estado y usuario especificados, devolver el primero encontrado
            $pedido = $result->fetch_assoc();
            return Pedido::crea($pedido['id_pedido'], $pedido['id_user'], $pedido['estado']);
        } else {
            // Si no se encuentra ningún pedido, devolver null
            return null;
        }
    }
    
    public static function buscarPedidosPorUser($id_user)
    {
        $result[] = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos P WHERE P.id_user = %d;', $id_user); 
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            while ($fila = $rs->fetch_assoc()) {
                if ($fila) {
                    $result = $fila['id_pedido'];
                }         
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscarPedidosPorFecha($id_user)
    {
        $result[] = null;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos P WHERE P.id_user = %d;', $id_user); 
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
            while ($fila = $rs->fetch_assoc()) {
                if ($fila) {
                    $result = $fila['id_pedido'];
                }         
            }
            $rs->free();
        }
        return $result;
    }

    public static function cantidad_Pedidos($idUser)
    {
      $conn = BD::getInstance()->getConexionBd();
    
      $query = sprintf('SELECT COUNT(*) AS total FROM pedidos P WHERE P.id_user = %d;', $idUser); 

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

    // Formatear la fecha correctamente
    
    $query = sprintf(
        "INSERT INTO pedidos (id_pedido, id_user, estado, fecha) VALUES ('%d', %d, '%s', '%s')",
        $pedido->id_pedido,
        $pedido->id_user,
        $conn->real_escape_string($pedido->estado),
        $pedido->fecha->format('Y-m-d H:i:s')
    );

    try {
        $conn->query($query);
        $result = true;
    } catch( \mysqli_sql_exception $e) {
        if ($conn->sqlstate == 23000) { // código de violación de restricción de integridad (PK)
            throw new PedidoYaExistenteException("Ya existe el pedido {$pedido->id_pedido}");
        }
    }
    
    return $result;
    }


    public static function actualizaEstado($pedido)
    {
        $result = false;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE pedidos P SET estado = '%s' WHERE P.id = %d",
            $pedido->estado,
            $pedido->fecha->format('Y-m-d H:i:s')
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' !");
        }
    
        return $result;
    }

    public static function actualizaFecha($pedido)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE pedidos P SET fecha = '%s' WHERE P.id = %d",
            $pedido->fecha->format('Y-m-d H:i:s'),
            $pedido->id_pedido
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
