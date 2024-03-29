<?php
require_once __DIR__.'/../../config.php';

use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Pedidos_user\Pedidos_producto;
use \es\ucm\fdi\aw\src\usuarios\Usuario;
use \es\ucm\fdi\aw\src\productos\Producto;
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión si no ha iniciado sesión
    header('Location: /G3_SW/loginView.php');
    exit();
}

$correo_usuario = $_SESSION['correo'];

$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();

// Obtener los detalles del último pedido del usuario
$ultimoPedido = Pedido::getUltimoPedidoUsuario($id_usuario);

// Verificar si se encontró el último pedido
if ($ultimoPedido) {
    // Mostrar mensaje de confirmación de compra
    $mensajeConfirmacion = "¡Compra realizada con éxito!";

    $detallesProductos = Pedidos_producto::buscaPorIdPedido_Producto($ultimoPedido->getIdPedido());

    $listaProductos = '<ul>';
    foreach ($detallesProductos as $idProducto => $cantidad) {
        $producto = Producto::buscaPorId($idProducto); // Suponiendo que tienes una clase Producto y un método buscaPorId para obtener el nombre del producto
        if ($producto) {
            $nombreProducto = $producto->getNombre();
            $listaProductos .= "<li>$nombreProducto -> Cantidad: $cantidad</li>";
        }
    }
    $listaProductos .= '</ul>';

    // Agregar la lista de productos comprados al mensaje de confirmación
    $mensajeConfirmacion .= "<h3>Detalles de los productos comprados:</h3>$listaProductos";

} else {
    $mensajeConfirmacion = "No se encontraron pedidos para mostrar detalles.";
}
$contenidoPrincipal = $mensajeConfirmacion ;
require_once __DIR__.'/../comun/layout.php';
?>