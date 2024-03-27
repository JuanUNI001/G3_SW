<?php
require_once 'config.php';

use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Pedidos_user\Pedidos_producto;
use \es\ucm\fdi\aw\src\Carrito\Carrito;
use \es\ucm\fdi\aw\src\Productos\Producto;
use \es\ucm\fdi\aw\src\usuarios\Usuario;


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header('Location: /G3_SW/loginView.php');
    exit();
}

$correo_usuario = $_SESSION['correo'];

$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();
// Verificar si el usuario tiene algún pedido en estado "carrito"
$pedido_carrito = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);

if ($pedido_carrito) {
        // Si no hay ningún pedido en estado "carrito", redirigir al usuario a su perfil o a la página de inicio con un mensaje de error
    $detallesCarrito = Carrito::obtenerDetallesCarrito();

    foreach ($detallesCarrito as $idPedido => $productosPorPedido) {
        foreach ($productosPorPedido as $idProducto => $cantidad) {
            $producto = Producto::buscaPorId($idProducto);

            if ($producto) {
                if ($producto->getCantidad() >= $cantidad) {
                    $nuevaCantidad = $producto->getCantidad() - $cantidad;
                    $producto->setCantidad($nuevaCantidad);
                    $producto->guarda();             
                    
                } else {
                    // No hay suficiente cantidad del producto en el stock
                    echo "No hay suficiente cantidad disponible del producto '{$producto->getNombre()}' en el stock.";
                }
            } else {
                // Producto no encontrado
                echo "Producto no encontrado en la base de datos.";
            }
        }
    }
    $pedido = Pedido::buscaPorId($idPedido);
    $pedido->setEstado("comprado");
    $pedido->guarda();
    }
// Redirigir al usuario a una página de confirmación o a su perfil
header('Location: /G3_SW/includes/vistas/helpers/confirmacionCompra.php');
exit();
?>