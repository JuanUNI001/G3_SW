<?php
require_once __DIR__.'/../../config.php';
use es\ucm\fdi\aw\src\Pedidos\Pedido;

// Verificar si se recibieron los datos esperados por GET
if (isset($_GET['idPedido']) && isset($_GET['idProducto'])) {
    // Obtener el ID del pedido y el ID del producto a eliminar del formulario
    $idPedido = $_GET['idPedido'];
    $idProducto = $_GET['idProducto'];
   
    // Verificar si se proporcionaron ambos IDs
    if (!empty($idPedido) && !empty($idProducto)) {
        // Intentar eliminar el producto del pedido
        $nuevoTotal = Pedido::eliminarProducto($idPedido, $idProducto);

        if ($nuevoTotal !== false) {
            // Éxito al eliminar el producto
            
            header('Location: /G3_SW/includes/carrito_usuario.php');
            exit();
        } else {
            // Error al eliminar el producto
            $contenidoPrincipal  =  "No se pudo eliminar el producto del pedido.";
        }
    } else {
        // No se proporcionaron ambos IDs
        $contenidoPrincipal  =  "Se requieren el ID del pedido y el ID del producto para eliminar el producto del pedido.";
    }
} else {
    // Si no se recibieron los datos esperados por GET
    $contenidoPrincipal = "No se recibieron los datos esperados por GET.";
}

require_once __DIR__.'/../../vistas/comun/layout.php';

?>
