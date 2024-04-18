<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Usuarios/ListaUsuarios.php';

$tituloPagina = 'Lista de Usuarios';

$usuarios = listaUsuarios();

$contenidoPrincipal = <<<HTML
    <h1>Lista de Usuarios</h1>
    <div class="contenedor-usuarios">
        $usuarios
    </div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
