<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Profesores/listaProfesores.php';

$tituloPagina = 'Lista de Profesores';

$profesores = listaProfesores(); // Llama a la función para obtener la lista de profesores

$contenidoPrincipal = <<<HTML
    <h1>Lista de Profesores</h1>
    <div class="contenedor-profesores">
        $profesores
    </div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
