<?php

require_once 'includes/config.php';
require_once 'includes/src/Eventos/listaEventos.php';

$tituloPagina = 'Eventos';
$form = new es\ucm\fdi\aw\src\Eventos\FormularioBusquedaEventos();

$AddEventoRuta = '';
if(isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin"){
    $AddEventoRuta = resuelve('AddEventoView.php');

    $AddEventoRuta .= <<<EOF
    <div>
        <a href="$AddEventoRuta" class="button-like-link">Añadir evento</a>
    </div>
    EOF;
}
    
$htmlFormLogin = $form->gestiona();

$contenidoPrincipal = <<<EOF
    $AddEventoRuta
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
