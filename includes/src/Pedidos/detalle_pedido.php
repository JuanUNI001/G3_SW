<?php
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Pedidos\Pedido;
use \es\ucm\fdi\aw\src\Pedidos\Pedidos_producto;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\Productos\Producto;
echo '<link rel="stylesheet" type="text/css" href="../../../css/imagenes.css">';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $dir = resuelve('/login.php');
    header("Location: $dir");
    exit();
}

$idPedido = $_GET['id'];

$pedido = Pedido::buscaPorId($idPedido);

if (!$pedido) {
    $dir = resuelve('/login.php');
    header("Location: $dir");
    exit();
}

$detallesProductos = Pedidos_producto::buscaPorIdPedido_Producto($idPedido);

$tituloPagina = 'Detalles del Pedido';

$contenidoPrincipal = '<div id="contenedor_principal">'; 
$contenidoPrincipal .= '<h2>Detalles del Pedido </h2>';
$contenidoPrincipal .=  '<div class="info_pedido">';
$fecha_pedido = date_format(date_create($pedido->getFecha()), 'd/m/Y');
$contenidoPrincipal .=  '<p class="fecha"><strong>Fecha:</strong> ' . $fecha_pedido . '</p>'; 
$contenidoPrincipal .=  '<p><strong>Precio Total:</strong> ' . $pedido->getPrecioTotal() . ' €</p>';
$contenidoPrincipal .=  '</div>'; 

if ($detallesProductos) {
  

    $contenidoPrincipal .= '<h3>Productos Comprados:</h3>';
    foreach ($detallesProductos as $idProducto => $cantidad) {
        $producto = Producto::buscaPorId($idProducto);
        if ($producto) {
            $imagenPath = RUTA_IMGS . $producto->getImagen();
            $precioProducto = $producto->getPrecio();
            $precioTotal = $precioProducto * $cantidad;
            $contenidoPrincipal .= <<<HTML
            <div class="deta_pedido">
                <div class="deta_info">
                    <div class="titulo_imagen">
                        <h3>{$producto->getNombre()}</h3>
                        <img src="$imagenPath" alt="{$producto->getNombre()}" class="deta_detalle">
                    </div>
                </div>
                <div class="producto_precio">
                    <p>{$producto->getPrecio()} €</p>
                
            <hr>
        HTML;
        $ruta = resuelve('/includes/src/Productos/caracteristicaProducto.php');
        if ($producto->getArchivado() == 0) {
            
            $contenidoPrincipal .= '<a href="' . $ruta . '?id_producto=' . $producto->getIdProducto() . '" class="botonPedido">Ir a la página</a>';
        }
    
        $contenidoPrincipal .= <<<HTML
                </div>                                           
            </div>
            <hr>
        HTML;
        
        }
    }
    $contenidoPrincipal .= '</div>';
    
    
}
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
