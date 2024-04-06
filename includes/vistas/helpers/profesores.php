<?php

require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../../src/usuarios/listaProfesores.php'; // Ruta al archivo que contiene la función para listar profesores

$tituloPagina = 'Lista de Profesores';

$profesores = listaProfesores(); // Llama a la función para obtener la lista de profesores

$contenidoPrincipal = <<<HTML
    <h1>Lista de Profesores</h1>
    <div class="contenedor-profesores">
        $profesores
    </div>
HTML;

require_once __DIR__.'/../comun/layout.php'; // Incluye el layout común para mostrar la página
