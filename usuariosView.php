<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Usuarios/ListaUsuarios.php';

$form = new es\ucm\fdi\aw\src\Usuarios\FormularioBusquedaUsuarios();
$tituloPagina = 'Lista de Usuarios';
  
$htmlFormLogin = $form->gestiona();
$contenidoPrincipal = <<<HTML
    
    <div>
        $htmlFormLogin
    </div>
HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal,  'cabecera' => 'Usuarios'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
