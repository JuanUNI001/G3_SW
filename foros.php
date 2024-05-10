<?php

require_once 'includes/config.php';
require_once 'includes/src/Foros/listaForos.php';

$form = new es\ucm\fdi\aw\src\Foros\FormularioBusquedaForo();
$htmlFormLogin = $form->gestiona();
$tituloPagina = 'Chatea aprende y diviertete en los foros';

$contenidoPrincipal = <<<EOF
  	
$htmlFormLogin

EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Foros'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>

