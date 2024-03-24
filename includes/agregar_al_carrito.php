<?php
require_once 'config.php';
use es\ucm\fdi\aw\src\BD;
use \es\ucm\fdi\aw\src\Pedidos_user\Pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\usuarios\Usuario;
use \es\ucm\fdi\aw\src\Productos\Producto;
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión
    header('Location: login.php');
    exit();
}

// Obtiene el ID del producto y la cantidad del formulario
$id_producto = $_POST['id_producto'] ?? null;
$cantidad = $_POST['cantidad'] ?? 1;

// Verifica si se proporcionó un ID de producto válido y una cantidad válida
if ($id_producto && is_numeric($id_producto) && $cantidad && is_numeric($cantidad) && $cantidad > 0) {
    // Obtiene el correo electrónico del usuario de la sesión
   
    $producto = Producto::buscaPorId($id_producto);
    if (!$producto || $producto->getCantidad() < $cantidad) {
        // Si el producto no existe o la cantidad disponible no es suficiente, redirige al usuario a la página de características del producto con un mensaje de error
        header('Location: /G3_SW/caracteristicaProducto.php?id_producto=' . $id_producto . '&added=false&error=insufficient_quantity');
        exit();
    }
    $correo_usuario = $_SESSION['correo'];

    // Busca el usuario en la base de datos utilizando el correo electrónico
    $usuario = Usuario::buscaUsuario($correo_usuario);

    // Verifica si se encontró al usuario y obtiene su ID
    if ($usuario) {
        $id_usuario = $usuario->getId();
    } else {
        // Si el usuario no existe, redirige al usuario a la página de inicio
        header('Location: index.php');
        exit();
    }

    // Verifica si el usuario ya tiene un pedido en estado "carrito"
    $pedido_existente = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);

    // Si el usuario no tiene un pedido "carrito", crea uno nuevo
    if (!$pedido_existente) {
        $pedido = Pedido::crea(null, $id_usuario, 'carrito');
        $pedido->guarda();
        $id_pedido = $pedido->getIdPedido();
    } else {
        // Si el usuario ya tiene un pedido "carrito", obtiene su ID
        $id_pedido = $pedido_existente->getIdPedido();
    }
    
    // Verifica si el producto ya está en el pedido
    $producto_existente = Pedidos_producto::buscaPorIdPedidoProducto($id_pedido, $id_producto);

    // Si el producto ya está en el pedido, actualiza la cantidad
    if ($producto_existente) {
        $cantidad += $producto_existente->getCantidad();
        $producto_existente->setCantidad($cantidad);
        $producto_existente->guarda();
    } else {
        // Si el producto no está en el pedido, lo añade
        $pedidos_producto = Pedidos_producto::crea($id_pedido, $id_producto, $cantidad);
        $pedidos_producto->guarda();
    }
    $nueva_cantidad = $producto->getCantidad() - $cantidad;
    $producto->actualizaCantidad($id_producto,$nueva_cantidad);
    $producto->guarda();
    // Redirige al usuario de vuelta a la página del producto con un mensaje de éxito
    header('Location: /G3_SW/caracteristicaProducto.php?id_producto=' . $id_producto . '&added=true');
    exit();
} else {
    // Si no se proporcionaron datos válidos, redirige al usuario a la página de inicio
    header('Location: index.php');
    exit();
}
?>
