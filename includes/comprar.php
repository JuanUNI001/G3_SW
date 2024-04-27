<?php
require_once 'config.php';

use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Productos\Producto;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    $dir = resuelve('/login.php');
    header("Location: $dir");
    exit();
}

$correo_usuario = $_SESSION['correo'];
$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();

$pedido = Pedido::obtenerPedidosEnCarrito();

if ($pedido) {
    $idPedido =  $pedido->getIdPedido();
    
    $productosPorPedido = Pedidos_producto::buscaPorIdPedido_Producto($idPedido);
    
    foreach ($productosPorPedido as $idProducto => $cantidad) {
        $producto = Producto::buscaPorId($idProducto);
        
        if ($producto) {
            echo "Producto encontrado: {$producto->getNombre()}, Cantidad: $cantidad <br>";
        } else {
            echo "Producto no encontrado con ID: $idProducto <br>";
        }
    }
    
    $pedido->setEstado("comprado");
    $pedido->guarda();
    
    $dir = resuelve('/includes/vistas/helpers/confirmacionCompra.php');
    header("Location: $dir");
    exit();
}
?>
