<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Productos\Producto;


$id_producto = $_GET['id_producto'];

$producto = Producto::buscaPorId($id_producto);

$form = new es\ucm\fdi\aw\src\Productos\FormularioEdicionProducto($producto);

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor producto';
$contenidoPrincipal=<<<EOF
  	
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor Producto'];
$app->generaVista('/plantillas/plantilla.php', $params);