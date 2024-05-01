<?php
require_once __DIR__.'/../../config.php';

use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\Productos\Producto;

$app = BD::getInstance();
    

if (!$app->usuarioLogueado())  {
    $dir = resuelve('/login.php');
    header("Location: $dir");
    exit();
}

$tituloPagina = 'Compra';
$contenidoPrincipal = "";

$correo_usuario = $_SESSION['correo'];
$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();

// Obtener los detalles del último pedido del usuario
$ultimoPedido = Pedido::getUltimoPedidoUsuario($id_usuario);

// Verificar si se encontró el último pedido
if ($ultimoPedido) {
    // Mostrar mensaje de confirmación de compra
    $contenidoPrincipal .= "<div class='producto_compra'>";
    $contenidoPrincipal .= "<h1>¡Compra realizada con éxito!</h1>";

    $detallesProductos = Pedidos_producto::buscaPorIdPedido_Producto($ultimoPedido->getIdPedido());
    $contenidoPrincipal .= "<h3>Detalles de los productos comprados:</h3>";

    // Lista de productos
    $contenidoPrincipal .= "<ul class='lista_productos'>";
    foreach ($detallesProductos as $pedido_producto) {
        $idProducto = $pedido_producto->getId_producto_pedido();
        $cantidad = $pedido_producto->getCantidad();
        $producto = Producto::buscaPorId($idProducto);
        
        if ($producto) {
            $nombreProducto = $producto->getNombre();
            $imagenProducto = RUTA_IMGS . $producto->getImagen();
            $precioProducto = $producto->getPrecio();
            
            // Agregar cada detalle del producto como un ítem de lista
            $contenidoPrincipal .= <<<EOF
            <div class='producto_compra_'>
                <div class='producto_info_compra'>
                    <p>$nombreProducto</p> <br>
                    <img src='$imagenProducto' alt='$nombreProducto' class='producto_imagen' width='100'><br>
                    <div class='producto_precio'>
                        <strong>Precio:</strong> $precioProducto € <br>
                        <strong>Cantidad:</strong> $cantidad <br>
                    </div>
                </div>
            </div>
        EOF;
        }
    }

        
    $contenidoPrincipal .= "</ul>";

    // Precio total de la compra
    $precioTotal = $ultimoPedido->getPrecioTotal();
    $contenidoPrincipal .= "<p><strong>Precio total de la compra:</strong> $precioTotal €</p>";

    $contenidoPrincipal .= "</div>";

} else {
    $contenidoPrincipal = "<p>No se encontraron pedidos para mostrar detalles.</p>";
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
