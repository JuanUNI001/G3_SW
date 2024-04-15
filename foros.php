<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Foros/Foro.php';
require_once __DIR__.'/includes/src/Foros/listaForos.php';

$tituloPagina = 'Chatea aprende y diviertete en los foros';

$foros = listaForos(); // Llama a la función para obtener la lista de foros

$contenidoPrincipal = <<<HTML
    <h1>Lista de Foros</h1>
    <div class="contenedor-foros">
        $foros
    </div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
