<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Productos\Producto;

$form = new es\ucm\fdi\aw\src\Productos\FormularioEdicionProducto();

$id_producto = $_GET['id_producto'];
$producto = Producto::buscaPorId($id_producto);
$nombre = $producto->getNombre();

$form->id = $id_producto;
$form->nombre = $nombre;
$form->precio = $producto->getPrecio();
$form->descripcion = $producto->getDescripcion();
$form->imagen = $producto->getImagen();

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor producto';
$contenidoPrincipal=<<<EOF
  	<h1>Acceso al sistema</h1>
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor Producto'];
$app->generaVista('/plantillas/plantilla.php', $params);