<?php
require_once 'config.php';

use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\Productos\Producto;
use es\ucm\fdi\aw\src\BD;
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión
    $dir = resuelve('/login.php');
    header("Location: $dir");
    exit();
}

// Obtiene el ID del producto y la cantidad del formulario
$id_producto = $_POST['id_producto'] ?? null;
$cantidad = $_POST['cantidad'] ?? 1;
$app = BD::getInstance();
// Verifica si se proporcionó un ID de producto válido y una cantidad válida
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
        // Obtiene el correo electrónico del usuario de la sesión
        $correo_usuario = $_SESSION['correo'];

        // Busca el usuario en la base de datos utilizando el correo electrónico
        $usuario = Usuario::buscaUsuario($correo_usuario);

        // Verifica si se encontró al usuario y obtiene su ID
        if ($usuario) {
            $id_usuario = $usuario->getId();
        } else {
            // Si el usuario no existe, redirige al usuario a la página de inicio
            $url = resuelve('/index.php');
            header("Location: $url");
            exit();
        }

        // Busca el pedido del usuario en estado "carrito"
        $pedido_existente = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);

        // Verifica si el usuario ya tiene un pedido "carrito"
        if (!$pedido_existente) {
            // Crea un nuevo pedido para el usuario si no tiene uno
            $pedido = Pedido::crea(null, $id_usuario, 'carrito', 0.0); // El ID del pedido se generará automáticamente
            $pedido->guarda();
        }
        $pedido_existente = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);
        // Actualiza el precio total del pedido
        $precio_producto = $producto->getPrecio(); // Obtener el precio del producto
        $precio_total_pedido = $pedido_existente->getPrecioTotal() + ($precio_producto * $cantidad);
        $pedido_existente->setPrecioTotal($precio_total_pedido);
        $pedido_existente->guarda();
        $id_pedido = $pedido_existente->getIdPedido();
        // Verifica si el producto ya está en el pedido
        $producto_existente = Pedidos_producto::buscaPorIdPedidoProducto($id_pedido, $id_producto);

        // Si el producto ya está en el pedido, actualiza la cantidad
        if ($producto_existente) {
            $cantidad += $producto_existente->getCantidad();
            $producto_existente->setCantidad($cantidad);
            $producto_existente->guarda();
        } else {
            // Si el producto no está en el pedido, lo añade
            $pedidos_producto = Pedidos_producto::crea($id_pedido, $id_producto, $cantidad, $precio_total_pedido);
            $pedidos_producto->guarda();
        }
        
        $mensajes = ['Producto añadido correctamente al carrito'];
        
        // Redirige al usuario de vuelta a la página del producto con un mensaje de éxito
    
        $url = resuelve('/includes/src/Productos/caracteristicaProducto.php') . '?id_producto=' . $id_producto;
        header("Location: $url" );
    }
} else {
    
    $mensajes = ['Parece que algo ha salido mal :('];
    
   
    $url = resuelve('/tienda.php');
    header("Location: $url");
}
$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>
