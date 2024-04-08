<?php
require_once 'config.php';


use \es\ucm\fdi\aw\src\usuarios\Usuario;
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
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
            $pedido = Pedido::buscaPorId($idPedido);
            $total = $pedido->getPrecioTotal();
            // Construir el href con la URL proporcionada
            $href = "/G3_SW/caracteristicaProducto.php?idProducto=" . $producto->getIdProducto();
            $direccion_eliminar = '/G3_SW/includes/src/Pedidos/eliminar_producto.php?idPedido=' . $idPedido . '&idProducto=' . $idProducto ;
            $direccion_actualizar = '/G3_SW/includes/src/Pedidos/actualizar_cantidad.php?idPedido=' . $idPedido . '&idProducto=' . $idProducto . '&nuevaCantidad=';            // Agregar el enlace al contenido principal
            $contenidoPrincipal .= <<<EOF
                <div class="producto_detalles">
                    <a href="$href">
                        <img src="$imagenPath" alt="{$producto->getNombre()}" class="carrito_imagen">
                    </a>
                    <div>
                        <p>{$producto->getNombre()}</p>
                        <p>Cantidad: 
                            <input type='number' id='cantidad_$idProducto' name='cantidad' value='$cantidad' min='1' style='width: 50px;'>
                            {$producto->getPrecio()} €
                        </p>
                        <p>Total: {$precioTotal} €</p>
                        <button onclick="window.location.href='$direccion_eliminar'">Eliminar</button>
                        <button onclick="window.location.href='$direccion_actualizar' + document.getElementById('cantidad_$idProducto').value">Actualizar</button>
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
      
        <button onclick="location.href='/G3_SW/includes/comprar.php'" type="button">Comprar</button>    Total compra: {$total} €
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



?>    
