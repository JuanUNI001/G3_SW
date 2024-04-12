<?php


require_once __DIR__.'includes/config.php';
require_once __DIR__.'includes/vistas/helpers/verPerfil.php';

$tituloPagina = 'Ver_Perfil';

$contenidoPrincipal =  mostrar_contenidoPerfil();

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
        $app->generaVista('/plantillas/plantilla.php', $params);