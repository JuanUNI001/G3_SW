

<?php
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use es\ucm\fdi\aw\src\Productos\Producto;
use es\ucm\fdi\aw\src\BD;
$app = BD::getInstance();

if (isset($_POST['idPedido']) && isset($_POST['idProducto']) && isset($_POST['nuevaCantidad'])) {
    $idPedido = $_POST['idPedido'];
    $idProducto = $_POST['idProducto'];
    $nuevaCantidad = $_POST['nuevaCantidad'];
    
    // Verificar si se proporcionaron todos los IDs y la cantidad
    if (!empty($idPedido) && !empty($idProducto) && !empty($nuevaCantidad)) {
        $producto = Producto::buscaPorId($idProducto);
        // Verificar si hay suficiente cantidad disponible en el producto
        if ($producto && $producto->getCantidad() >= $nuevaCantidad) {
            $precioProducto = $producto->getPrecio();
            $diferenciaCantidad = Pedidos_producto::ajustarCantidadProducto($idPedido, $idProducto, $nuevaCantidad);

            if ($diferenciaCantidad !== false) {
                        
                $ajustePrecioTotal = $diferenciaCantidad * $precioProducto;
                
                Pedido::actualizarPrecioTotalPedido($idPedido, $ajustePrecioTotal);  
                $mensajes = ['Producto actualizado correctamente :)'];
            } else {
                
                $mensajes = ['No se pudo ajustar la cantidad del producto en el pedido.'];
            }
        }
        else{
            $mensajes = ['No se pudo ajustar la cantidad del producto en el pedido.'];

        }
    } else {
        // No se proporcionaron todos los IDs y la cantidad
        $mensajes = ['Se requieren el ID del pedido, el ID del producto y la cantidad para ajustar la cantidad del producto en el pedido.'];
    }
} else {
    // Si no se recibieron los datos esperados por GET
    $mensajes = ['Ha ocurrido un problema :('];
}

$url = resuelve('/includes/carrito_usuario.php');
header("Location: $url");

$app->putAtributoPeticion('mensajes', $mensajes);

?>
