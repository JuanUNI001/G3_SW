<?php

require_once 'includes/config.php';
require_once 'includes/src/Eventos/listaEventos.php';




$tituloPagina = 'Eventos';
$form = new es\ucm\fdi\aw\src\Eventos\FormularioBusquedaEventos();
    $form->productos = listaeventos();
    
    $htmlFormLogin = $form->gestiona();

    $tituloPagina = 'Búsqueda Producto';
    $contenidoPrincipal = <<<EOF
  	
    $htmlFormLogin

EOF;
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>