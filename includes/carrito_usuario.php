<?php

require_once __DIR__.'/config.php';
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Carrito\Carrito;
use \es\ucm\fdi\aw\src\Productos\Producto;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

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
$contenidoPrincipal = "";
$pedido = Pedido::buscarPedidoPorEstadoUsuario('carrito', $id_usuario);
if($pedido){
    $idPedido = $pedido->getIdPedido();
   
    $productosPorPedido = Pedido::obtenerProductosPorPedido($idPedido);

        
    foreach ($productosPorPedido as $idProducto => $cantidad) {
            
        $producto = Producto::buscaPorId($idProducto);

            // Verificar si se encontró el producto
        if ($producto) {
            $imagenPath = RUTA_IMGS . $producto->getImagen();
            $precioProducto = $producto->getPrecio();
            $precioTotal = $precioProducto * $cantidad;
            
            $total = $pedido->getPrecioTotal();
            
            // Construir el href con la URL proporcionada
            $rutaCar = resuelve('/includes/src/Productos/caracteristicaProducto.php');
            $rutaEliminar = resuelve('/includes/src/Pedidos/eliminar_producto.php');
            $rutaActualizar =  resuelve('/includes/src/Pedidos/actualizar_cantidad.php');
            $href = $rutaCar."?idProducto=" . $producto->getIdProducto();
            $direccion_eliminar = $rutaEliminar.'?idPedido=' . $idPedido . '&idProducto=' . $idProducto ;
            $direccion_actualizar = $rutaActualizar.'?idPedido=' . $idPedido . '&idProducto=' . $idProducto ; 
            
            // Generar un ID único para el formulario de actualización de cantidad
            $formActualizarId = "form-actualizar-cantidad-$idProducto";
            // Generar un ID único para el formulario de eliminación
            $formEliminarId = "form-eliminar-producto-$idProducto";
            
            // Agregar el enlace al contenido principal
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
                            <!-- Formulario para actualizar la cantidad -->
                            <div style="display: flex; align-items: center;">
                                <span style="margin-right: 10px;margin-top: 80px">Cantidad:</span>
                                <form id="$formActualizarId" action="$direccion_actualizar" method="post">
                                    <input type="hidden" name="idPedido" value="$idPedido">
                                    <input type="hidden" name="idProducto" value="$idProducto">
                                    <input type="number" name="nuevaCantidad" value="$cantidad" min="1" onchange="actualizarCantidad(this.value, '$formActualizarId')">
                                </form>
                            </div>
                            <!-- Formulario para eliminar el producto -->
                            <form id="$formEliminarId" action="$direccion_eliminar" method="post">
                                <input type="hidden" name="idPedido" value="$idPedido">
                                <input type="hidden" name="idProducto" value="$idProducto">
                                <button type="submit" class="botonCarrito" style="margin-top: 10px; margin-top: 20px">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                
                <script>
                function actualizarCantidad(nuevaCantidad, formId) {
                    // Obtener el formulario por su ID único
                    var form = document.getElementById(formId);
                    // Enviar el formulario automáticamente
                    form.submit();
                }
                </script>
            EOF;
        } 
    }
    $total = $pedido->getPrecioTotal();
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
