<?php

require_once 'includes/config.php';
require_once 'includes/src/Eventos/listaEventos.php';

$tituloPagina = 'Eventos';
$form = new es\ucm\fdi\aw\src\Eventos\FormularioBusquedaEventos();

$AddEventoRuta = '';
$BotonAddEvento = '';
if(isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin"){
    $AddEventoRuta = resuelve('AddEventoView.php');

    $BotonAddEvento = <<<EOF
    <div>
        <a href="$AddEventoRuta" class="button-like-link">Añadir evento</a>
    </div>
    EOF;
}
    
$htmlFormLogin = $form->gestiona();

$contenidoPrincipal = <<<EOF
    $BotonAddEvento
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Eventos'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
