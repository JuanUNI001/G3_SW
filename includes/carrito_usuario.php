<?php
require_once 'config.php';


use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Carrito\Carrito;
use \es\ucm\fdi\aw\src\Productos\Producto;

// Incluye el CSS necesario
echo '<link rel="stylesheet" type="text/css" href="../css/imagenes.css">';


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // Redirige al usuario a la página de inicio de sesión
    $dir = resuelve('/login.php');
    header("Location: $dir");
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
            $rutaCar = resuelve('/includes/src/Productos/caracteristicaProducto.php');
            $rutaEliminar = resuelve('/includes/src/Pedidos/eliminar_producto.php');
            $rutaActualizar =  resuelve('/includes/src/Pedidos/actualizar_cantidad.php');
            $href = $rutaCar."?idProducto=" . $producto->getIdProducto();
            $direccion_eliminar = $rutaEliminar.'?idPedido=' . $idPedido . '&idProducto=' . $idProducto ;
            $direccion_actualizar = $rutaActualizar.'?idPedido=' . $idPedido . '&idProducto=' . $idProducto ;            // Agregar el enlace al contenido principal
            $contenidoPrincipal .= <<<EOF
                <div class="producto_carrito">
                    <div class="producto_info">
                        <div class="titulo_imagen">
                            <h3>{$producto->getNombre()}</h3>
                            <a href="$href">
                                <img src="$imagenPath" alt="{$producto->getNombre()}" class="carrito_imagen">
                            </a>
                        </div>
                    </div>
                    <div class="producto_precio">
                        <p>{$producto->getPrecio()} €</p>
                        <div class="producto_detalle">
                            <div style="display: flex; align-items: center;">
                                <span style="margin-right: 10px;margin-top: 80px">Cantidad:</span>
                                <input type='number' id='cantidad_$idProducto' name='cantidad' value='$cantidad' min='1' style='width: 30px; margin-right: 10px;margin-top: 80px' onchange="actualizarCantidad(this.value);">
                            </div>
                        </div>
                        <button class="botonCarrito" style="margin-top: 10px;  margin-top: 20px" onclick="window.location.href='$direccion_eliminar'">Eliminar</button>
                        
                    </div>                                           
                </div>
                <hr>

                <script>
                function actualizarCantidad( nuevaCantidad) {
                    var direccionActualizar = "$direccion_actualizar . &nuevaCantidad=" + nuevaCantidad;
                    window.location.href = direccionActualizar;
                }
                </script>
            EOF;
        } 
        
    }
}
$pedido_carrito = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);

if ($pedido_carrito) {
    $rutaComprar =  resuelve('/includes/comprar.php');
    $contenidoPrincipal .= <<<EOF
    <div>
        <button onclick="location.href='{$rutaComprar}'" type="button">Comprar</button> Total compra: {$total} €
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
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Login'];
$app->generaVista('/plantillas/plantilla.php', $params);


?>    
