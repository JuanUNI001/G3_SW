<?php
require_once 'includes/config.php';
require_once 'includes/src/Productos/listaProductos.php';

$productos = "a";
$productos = includes\src\Productos\listaproductos();
$tituloPagina = 'Tienda';
$contenidoPrincipal=<<<EOF
  	<h1>Registro de subasta</h1>
    $productos
EOF;

require 'includes/vistas/comun/layout.php';
?>
