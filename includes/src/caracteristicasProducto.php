<?php 
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/autorizacion.php';
require_once 'includes/src/Productos/productos.php.php';

$tituloPagina = 'Producto';

$idPelicula = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$pelicula = Producto::buscaPorId($id);
if(!$pelicula){
    Utils::paginaError(403, '','Error articulo');
}

$contenidoPrincipal= visualizaProducto($pelicula);

require 'includes/vistas/comun/layout.php';