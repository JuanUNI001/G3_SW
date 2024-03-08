<?php
require_once '../config.php';
require_once 'Productos/listaProductos.php';

$productos = includes\src\Productos\listaproductos();
$tituloPagina = 'Tienda';
$contenidoPrincipal=<<<EOF
  	<h1>Registro de subasta</h1>
    $productos
EOF;

require 'vistas/comun/layout.php';
?>
