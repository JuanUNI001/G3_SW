<?php

require_once 'includes/config.php';
require_once 'includes/src/Eventos/listaEventos.php';

$tituloPagina = 'Eventos';
$form = new es\ucm\fdi\aw\src\Eventos\FormularioBusquedaEventos();
    
    $htmlFormLogin = $form->gestiona();

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = <<<EOF
  	
    $htmlFormLogin

EOF;
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>