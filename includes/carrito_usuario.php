<?php
require_once 'config.php';


use \es\ucm\fdi\aw\src\usuarios\Usuario;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Pedidos_user\Pedidos_producto;
use \es\ucm\fdi\aw\src\Carrito\Carrito;
use \es\ucm\fdi\aw\src\Productos\Producto;

// Incluye el CSS necesario
echo '<link rel="stylesheet" type="text/css" href="../css/imagenes.css">';


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión
    header('Location: /G3_SW/loginView.php');
    exit();
}

$tituloPagina = 'Carrito';


$correo_usuario = $_SESSION['correo'];

$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();

$detallesCarrito = Carrito::obtenerDetallesCarrito();

$contenidoPrincipal = "";

foreach ($detallesCarrito as $idPedido => $productosPorPedido) {
    
    foreach ($productosPorPedido as $idProducto => $cantidad) {
        
        $producto = Producto::buscaPorId($idProducto);

        // Verificar si se encontró el producto
        if ($producto) {
            $imagenPath = RUTA_IMGS . $producto->getImagen();
            $precioProducto = $producto->getPrecio();
            $precioTotal = $precioProducto * $cantidad;

            // Construir el href con la URL proporcionada
            $href = "/G3_SW/caracteristicaProducto.php?id_producto=" . $producto->getIdProducto();

            // Agregar el enlace al contenido principal
            $contenidoPrincipal .= <<<EOF
            <div class="producto_detalles">
                <a href="$href">
                    <img src="$imagenPath" alt="{$producto->getNombre()}" class="carrito_imagen">
                </a>
                <div>
                    <p>{$producto->getNombre()}</p>
                    <p>Cantidad: $cantidad</p>
                    <p>Precio total: \$$precioTotal</p>
                </div>
            </div>
            <hr> <!-- Línea horizontal -->
            EOF;
        } 
        
    }
}
$pedido_carrito = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);

if ($pedido_carrito) {
    $contenidoPrincipal .= <<<EOF
    <div>
        <button onclick="location.href='/G3_SW/includes/comprar.php'" type="button">Comprar</button>
    </div>
    EOF;
}
else{
    $contenidoPrincipal .= <<<EOF
    <div>
        <p>No tienes ningún artículo en la cesta :(</p>
    </div>
    EOF;
}
// Imprimir el contenido principal

require_once 'vistas/comun/layout.php';
?>
