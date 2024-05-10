<?php
require_once 'includes/config.php';
require_once 'includes/src/Productos/listaProductos.php';
require_once 'includes/vistas/helpers/auxBusquedaProducto.php';
$tituloPagina = 'Tienda';
$contenidoPrincipal = '';
$botonAñadirProducto = '';
$direccionBusca = generarHTML();

// Verificar si el usuario es administrador para mostrar el botón "Añadir producto"
if(isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin"){
    $AddProductoRuta = resuelve('/AddProductoView.php');

    $botonAñadirProducto .= <<<EOF
    <div>
        <a href="$AddProductoRuta" class="button-like-link">Añadir producto</a>
    </div>
    EOF;
}

// Generar contenido principal de la página
$contenidoPrincipal = <<<EOS
    
    $botonAñadirProducto
    $direccionBusca
EOS;

// Parámetros para generar la vista
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Tienda'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
