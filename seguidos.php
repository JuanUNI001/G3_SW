<?php

require_once 'includes/config.php';
require_once 'includes/src/Usuarios/listaAmigos.php';


$tituloPagina = 'Chatea aprende y diviertete en los foros';
$amiguis = listaAmigos();
$contenidoPrincipal = <<<EOF
  	
$amiguis

EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>

