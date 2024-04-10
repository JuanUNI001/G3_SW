<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Foros/Foro.php';

$tituloPagina = 'Lista de Foros';

$foros = listaProfesores(); // Llama a la función para obtener la lista de foros

$contenidoPrincipal = <<<HTML
    <h1>Lista de Foros</h1>
    <div class="contenedor-foros">
        $foros
    </div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
