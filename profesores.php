<?php

require_once 'includes/config.php';
require_once 'includes/src/Profesores/listaProfesores.php';

$tituloPagina = 'Búsqueda Profesor';

$form = new es\ucm\fdi\aw\src\Profesores\FormularioBusquedaProfesor();
$htmlFormLogin = $form->gestiona();

$contenidoPrincipal = <<<EOF
$htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
