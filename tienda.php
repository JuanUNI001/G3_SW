<?php
require_once 'includes/config.php';
require_once 'includes/src/Productos/listaProductos.php';

$tituloPagina = 'Tienda';
$contenidoPrincipal='';
$botonAñadirProducto ='';

if(isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin"){

    $AddProductoRuta=resuelve('AddProductoView.php');

    $botonAñadirProducto .=<<<EOF
    <div>
    <a href="$AddProductoRuta" class="button-like-link">Añadir producto</a>
    </div>
    EOF; 
}

$productos = listaproductos();

$contenidoPrincipal=<<<EOS
    <h1>Tienda</h1>
    $botonAñadirProducto
    $productos
EOS;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
