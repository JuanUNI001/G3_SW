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

    private $total;

    private function __construct($id_pedido, $id_user, $estado, $fecha, $total)
    {
        $this->id_pedido = $id_pedido;
        $this->id_user = $id_user;
        $this->estado = $estado;
        $this->fecha = $fecha;
        $this->total = $total;
    }

    public static function crea($id_pedido,$id_user, $estado, $total)
    {
        $fechaActual = new DateTime();
        $fechaFormateada = $fechaActual->format('Y-m-d');
        return new Pedido($id_pedido, $id_user, $estado, $fechaFormateada, $total);
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
    public function getPrecioTotal(){
        return $this->total;
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
    public function setPrecioTotal($nuevoPrecio){
        $this->total = $nuevoPrecio;
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
    public static function buscarPedidosAnteriores($id_usuario)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos WHERE estado = "comprado" AND id_user = %d', $id_usuario);
        $result = $conn->query($query);

        $pedidosAnteriores = array();

        if ($result && $result->num_rows > 0) {
            while ($pedido = $result->fetch_assoc()) {
                $pedidosAnteriores[] = new Pedido($pedido['id_pedido'], $pedido['id_user'], $pedido['estado'], $pedido['fecha'], $pedido['total']);
            }
        }

        return $pedidosAnteriores;
    }

    public static function buscarPedidoPorEstadoUsuario($estado, $id_usuario)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos WHERE estado = "%s" AND id_user = %d', $estado, $id_usuario);
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $pedido = $result->fetch_assoc();
            return new Pedido($pedido['id_pedido'], $pedido['id_user'], $pedido['estado'], $pedido['fecha'], $pedido['total']);
        } else {
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

        // Utiliza comillas simples para la fecha y no para el precio
        $query = sprintf(
            "INSERT INTO pedidos (id_user, estado, fecha, total) VALUES (%d, '%s', '%s', %f)",
            $pedido->id_user,
            $conn->real_escape_string($pedido->estado),
            $pedido->fecha,
            $pedido->total
        );        

        try {
            $conn->query($query);
            $result = true;
        } catch (\mysqli_sql_exception $e) {
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
    public static function buscaPorId($id_pedido)
    {
        $result = null;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf('SELECT * FROM pedidos WHERE id_pedido = %d;', $id_pedido); 
        $rs = null;
        
        try {
            $rs = $conn->query($query);
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Pedido($fila['id_pedido'], $fila['id_user'], $fila['estado'], $fila['fecha'], $fila['total']);
            }
        } finally {
            if ($rs != null) {
                $rs->free();
            }
        }
        
        return $result;
    }
    public static function crearDesdeArray($fila) {
        $idPedido = $fila['id_pedido'];
        $idUsuario = $fila['id_user'];
        $estado = $fila['estado'];
        $fecha = $fila['fecha'];
        $total = $fila['total'];
        // Aquí puedes incluir más campos si es necesario
    
        return new Pedido($idPedido, $idUsuario, $estado, $fecha, $total);
    }
    public static function getUltimoPedidoUsuario($id_usuario) {
        $conn = BD::getInstance()->getConexionBd();
    
        // Consulta SQL para obtener el último pedido del usuario
        $query = "SELECT * FROM pedidos WHERE id_user = $id_usuario ORDER BY fecha DESC LIMIT 1";
    
        $rs = $conn->query($query);
    
        if ($rs && $rs->num_rows > 0) {
            // Si se encontró un pedido, crear un objeto Pedido y devolverlo
            $fila = $rs->fetch_assoc();
            return Pedido::crearDesdeArray($fila);
        } else {
            // Si no se encontró ningún pedido, devolver null
            return null;
        }
    }
    
    public function guarda()
    {
        if (!$this->id_pedido) {
            // Si el pedido no tiene un ID asignado, es un nuevo pedido, por lo que se debe insertar en la base de datos
            if (!self::inserta($this)) {
                // Manejar el caso en el que la inserción falla
                return false;
            }
        } else {
            // Si el pedido ya tiene un ID asignado, es un pedido existente que se debe actualizar en la base de datos
            if (!self::actualiza($this)) {
                // Manejar el caso en el que la actualización falla
                return false;
            }
        }

        // Actualiza el precio total del pedido
        if (!self::actualizaPrecioTotal($this->id_pedido, $this->total)) {
            // Manejar el caso en el que la actualización del precio total falla
            return false;
        }

        return true;
    }

    public static function actualiza($pedido)
    {
        $result = false;
    
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE pedidos SET id_user = %d, estado = '%s', fecha = '%s' WHERE id_pedido = %d",
            $pedido->id_user,
            $conn->real_escape_string($pedido->estado),
            $pedido->fecha,
            $pedido->id_pedido
        );
    
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' filas!");
        }
    
        return $result;
    }
    
    public static function actualizaPrecioTotal($id_pedido, $nuevo_precio_total)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE pedidos SET total = %f WHERE id_pedido = %d",
            $nuevo_precio_total,
            $id_pedido
        );
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' filas!");
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
