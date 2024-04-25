<?php

namespace es\ucm\fdi\aw\src\Carrito;
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use es\ucm\fdi\aw\src\BD;

class Carrito
{
    public static function obtenerPedidosEnCarrito()
    {
        $pedido = null;

        // Obtener el pedido con estado "carrito"
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT id_pedido FROM pedidos WHERE estado = 'carrito' LIMIT 1";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $pedido = $fila['id_pedido'];
            $result->free();
        }

        return $pedido;
    }

    public static function obtenerProductosPorPedido($id_pedido)
    {
        $productos = array();

        // Obtener todos los productos asociados a un pedido
        $productos_pedido = Pedidos_producto::buscaPorIdPedido_Producto($id_pedido);

        foreach ($productos_pedido as $id_producto => $cantidad) {
            $productos[$id_producto] = $cantidad;
        }

        return $productos;
    }

    public static function obtenerDetallesCarrito()
    {
        $detallesCarrito = array();

        // Obtener pedidos en estado "carrito"
        $id_pedido = self::obtenerPedidosEnCarrito();

        // Para cada pedido en el carrito, obtener los productos asociados
        
            $productosPorPedido = self::obtenerProductosPorPedido($id_pedido);
            $detallesCarrito[$id_pedido] = $productosPorPedido;
        

        return $detallesCarrito;
    }
}
