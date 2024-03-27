<?php
require_once __DIR__.'/../../config.php';

use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Pedidos_user\Pedidos_producto;
use \es\ucm\fdi\aw\src\usuarios\Usuario;
use \es\ucm\fdi\aw\src\Productos\Producto;
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header('Location: /G3_SW/loginView.php');
    exit();
}

$correo_usuario = $_SESSION['correo'];

$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();

// Obtener los pedidos anteriores del usuario con estado "comprado"
$pedidosAnteriores = Pedido::buscarPedidosAnteriores($id_usuario);

// Verificar si se encontraron pedidos
if ($pedidosAnteriores) {
    $contenidoPrincipal = '';
    foreach ($pedidosAnteriores as $pedido) {
        $contenidoPrincipal .= '<div>';
        $contenidoPrincipal .= '<p><strong>Fecha:</strong> ' . $pedido->getFecha() . '</p>';
        $contenidoPrincipal .= '<p><strong>Precio Total:</strong> ' . $pedido->getPrecioTotal() . ' €</p>';
        $contenidoPrincipal .= '<p><strong>Productos Comprados:</strong></p>';
        
        // Obtener los detalles de los productos comprados en este pedido
        $detallesProductos = Pedidos_producto::buscaPorIdPedido_Producto($pedido->getIdPedido());
        $contenidoPrincipal .= '<ul>';
        foreach ($detallesProductos as $idProducto => $cantidad) {
            $producto = Producto::buscaPorId($idProducto);

            // Verificar si el producto se encontró correctamente
            if ($producto) {
                $nombreProducto = $producto->getNombre();
                // Agregar cada producto como un elemento de la lista
                $contenidoPrincipal .= '<li><strong> Nombre: </strong>' . $nombreProducto . ', <strong>Cantidad: </strong>' . $cantidad . '</li>';
            } 
        }
        $contenidoPrincipal .= '</ul>';

        
        $contenidoPrincipal .= '</div>';
        $contenidoPrincipal .= '<hr>'; 
    }
} else {
    $contenidoPrincipal = "No tienes pedidos anteriores :(";
}

require_once __DIR__.'/../comun/layout.php';
?>
