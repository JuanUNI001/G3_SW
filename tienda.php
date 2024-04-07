<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Productos/listaProductos.php';

$tituloPagina = 'Tienda';
$contenidoPrincipal='';


$rutaAñadirProducto = __DIR__ . '/includes/src/Productos/añadir_producto.php';
// Botón "Añadir Producto"
$botonAñadirProducto = '
    <form action="' . $rutaAñadirProducto . '" method="post">
        <button type="submit">Añadir Producto</button>
    </form>
';

$productos = listaproductos();

$contenidoPrincipal=<<<EOS
    <h1>Tienda</h1>
    $botonAñadirProducto
    $productos
EOS;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
