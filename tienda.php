<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Productos/listaProductos.php';

$tituloPagina = 'Tienda';
$contenidoPrincipal='';
$botonAñadirProducto ='';

if(isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin"){

    $botonAñadirProducto .=<<<EOF
    <div>
    <a href="/G3_SW/AddProductoView.php" class="button-like-link">Añadir producto</a>
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
