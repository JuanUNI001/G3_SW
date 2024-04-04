<?php

require_once 'includes/config.php';
require_once 'includes/src/Productos/listaProductos.php';

$tituloPagina = 'Tienda';
$rutaAñadirProducto = __DIR__ . '/includes/src/Productos/añadir_producto.php';
// Botón "Añadir Producto"
$botonAñadirProducto = '
    <form action=" . $rutaAñadirProducto . " method="post">
        <button type="submit">Añadir Producto</button>
    </form>
';

$productos = listaproductos();

$contenidoPrincipal=<<<EOF
    <h1>Tienda</h1>
    $botonAñadirProducto
    $productos
EOF;

require_once 'includes/vistas/comun/layout.php';
?>
