<?php

//Inicio del procesamiento
session_start();

require_once 'includes/config.php';
require_once 'includes/src/Productos/productos.php';

$nombre= $_POST['nombre'] ?? null;
$id= $_POST['id'] ?? null;
$precioNuevo = $_POST['precioNuevo'] ?? null; 
$descripcionNueva = $_POST['descripcionNueva'] ?? null; 
$eliminar = isset($_POST['eliminar']) && $_POST['eliminar'] === '1';


if ($eliminar) {
    Producto::elimina($id);
} else {
	$prodActual = Producto::buscaPorId($id);
    $producto = Producto::crea($id, $nombre, $precioNuevo, $descripcionNueva, $prodActual->getImagen(), $prodActual->getValoracion(), $prodActual->getNumValoraciones(),$prodActual->getCantidad());
    Producto::actualiza($producto);
}

$tituloPagina = 'Pagina principal';

$contenidoPrincipal=<<<EOS
<h1>Página principal</h1>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require 'includes/vistas/comun/layout.php';