<?php
require_once 'config.php';

use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\Productos\Producto;
use es\ucm\fdi\aw\src\BD;
$app = BD::getInstance();

if (!$app->usuarioLogueado())  {
    $dir = resuelve('/login.php');
    header("Location: $dir");
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_producto = $_POST['id_producto'] ?? null;
    $cantidad = $_POST['cantidad'] ?? 1;

    if ($id_producto && is_numeric($id_producto) && $cantidad && is_numeric($cantidad) && $cantidad > 0) {
        // Obtiene el producto
        $producto = Producto::buscaPorId($id_producto);

        // Verifica si el producto existe y si la cantidad disponible es suficiente
        if (!$producto || $producto->getCantidad() < $cantidad) {
            // Redirige al usuario a la página de características del producto con un mensaje de error
            $url = resuelve('/includes/src/Productos/caracteristicaProducto.php') . '?id_producto=' . $id_producto;
            header("Location: $url");
            $mensajes = ['Parece que no hay la cantidad que pides'];
        
        }
        else{
            $correo_usuario = $_SESSION['correo'];

            $usuario = Usuario::buscaUsuario($correo_usuario);

            if ($usuario) {
                $id_usuario = $usuario->getId();
            } else {
                $url = resuelve('/index.php');
                header("Location: $url");
                exit();
            }

            $pedido_existente = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);

            if (!$pedido_existente) {
                $pedido = Pedido::crea(null, $id_usuario, 'carrito', 0.0); 
                $pedido->guarda();
            }
            $pedido_existente = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);
            $precio_producto = $producto->getPrecio(); 
            $precio_total_pedido = $precio_producto * $cantidad;

            $pedido_existente->setPrecioTotal($precio_total_pedido);
            $pedido_existente->guarda();

            $id_pedido = $pedido_existente->getIdPedido();
            $producto_existente = Pedidos_producto::buscaPorIdPedidoProducto($id_pedido, $id_producto);

            if ($producto_existente) {
                $cantidad += $producto_existente->getCantidad();
                $producto_existente->setCantidad($cantidad);
                $producto_existente->guarda();
            } else {
                $pedidos_producto = Pedidos_producto::crea($id_pedido, $id_producto, $cantidad, $precio_total_pedido);
                $pedidos_producto->guarda();
            }
            
            $mensajes = ['Producto añadido correctamente al carrito'];
            
        
            $url = resuelve('/includes/src/Productos/caracteristicaProducto.php') . '?id_producto=' . $id_producto;
            header("Location: $url" );
        }
    } else {
        
        $mensajes = ['Parece que algo ha salido mal :('];
        
    
        $url = resuelve('/tienda.php');
        header("Location: $url");
    }
}
$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>
