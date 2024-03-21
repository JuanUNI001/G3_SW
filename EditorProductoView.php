<?php

require_once 'includes/config.php';
require_once 'includes/src/Productos/Producto.php';

$form = new es\ucm\fdi\aw\FormularioEdicion();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor Producto';

$id_producto = $_GET['id_producto'];
$producto = Producto::buscaPorId($id_producto);
$nombre = $producto->getNombre();

$contenidoPrincipal=<<<EOS
    <h1>
        <p>Modificando datos de producto</p>
        <p> $nombre</p>
    </h1>
    $htmlFormLogin
EOS;

require_once 'includes/vistas/comun/layout.php';
