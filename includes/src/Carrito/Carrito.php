<?php

namespace es\ucm\fdi\aw\src\Carrito;
use \es\ucm\fdi\aw\src\Pedidos\pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use es\ucm\fdi\aw\src\BD;

class Carrito
{
    public static function obtenerPedidosEnCarrito()
    {
        $pedidos = array();

        // Obtener todos los pedidos con estado "carrito"
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT id_pedido FROM pedidos WHERE estado = 'carrito'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                $id_pedido = $fila['id_pedido'];
                $pedidos[] = $id_pedido;
            }
        }

        return $pedidos;
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
        $pedidosEnCarrito = self::obtenerPedidosEnCarrito();

        // Para cada pedido en el carrito, obtener los productos asociados
        foreach ($pedidosEnCarrito as $id_pedido) {
            $productosPorPedido = self::obtenerProductosPorPedido($id_pedido);
            $detallesCarrito[$id_pedido] = $productosPorPedido;
        }

        return $detallesCarrito;
    }
}
