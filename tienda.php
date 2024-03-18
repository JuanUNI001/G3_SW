<?php

require_once 'includes/config.php';
require_once 'includes/src/Productos/listaProductos.php';



$productos = listaproductos();
$tituloPagina = 'Tienda';
$contenidoPrincipal=<<<EOF
  	<h1>Tienda</h1>
    $productos
EOF;

require_once 'includes/vistas/comun/layout.php';
?>
