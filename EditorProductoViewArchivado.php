<?php

require_once __DIR__.'/includes/config.php'; 
  $id_producto = $_GET['id_producto'];
  $form = new es\ucm\fdi\aw\src\Productos\FormularioProductoArchivado($id_producto);

  $htmlFormLogin = $form->gestiona();

  $tituloPagina = 'Editor producto';
  $contenidoPrincipal=<<<EOF
      
      $htmlFormLogin
  EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor Producto'];
$app->generaVista('/plantillas/plantilla.php', $params);
