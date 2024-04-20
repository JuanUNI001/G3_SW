<?php


require_once 'includes/config.php';
require_once 'includes/vistas/helpers/verPerfil.php';

$tituloPagina = 'Ver_Perfil';

$contenidoPrincipal =  mostrar_contenidoPerfil();

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);