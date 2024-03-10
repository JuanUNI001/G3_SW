<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Productos/listaProductos.php';


$productos = listadoproductosPrueba();
$tituloPagina = 'Tienda';
$contenidoPrincipal=<<<EOF
  	<h1>Registro de subasta</h1>
    $productos
EOF;

require 'includes/vistas/comun/layout.php';
?>
