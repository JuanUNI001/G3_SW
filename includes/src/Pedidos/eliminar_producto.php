<?php
require_once __DIR__.'/../../config.php';
use es\ucm\fdi\aw\src\Pedidos\Pedido;
use es\ucm\fdi\aw\src\BD;


$app = BD::getInstance();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idPedido']) && isset($_POST['idProducto'])) {
        // Obtener el ID del pedido y el ID del producto a eliminar del formulario
        $idPedido = $_POST['idPedido'];
        $idProducto = $_POST['idProducto'];
    
        // Verificar si se proporcionaron ambos IDs
        if (!empty($idPedido) && !empty($idProducto)) {
            // Intentar eliminar el producto del pedido
            $nuevoTotal = Pedido::eliminarProducto($idPedido, $idProducto);

            if ($nuevoTotal !== false) {
                // Éxito al eliminar el producto
                $mensajes = ['Producto eliminado.'];
                
            } else {
                // Error al eliminar el producto
                $mensajes = ['No se pudo eliminar el producto del pedido.'];
            }
        } else {
            // No se proporcionaron ambos IDs
            $mensajes = ['Se requieren el ID del pedido y el ID del producto para eliminar el producto del pedido.'];
        }
    } else {
        // Si no se recibieron los datos esperados por GET
        $mensajes = ['Parece que algo ha ido mal :('];
    }
}
$app->putAtributoPeticion('mensajes', $mensajes);
$url = resuelve('/includes/vistas/helpers/carrito_usuario.php');
header("Location: $url");
exit();
?>
