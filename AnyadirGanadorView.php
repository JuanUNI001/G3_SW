
<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Eventos\Evento;


$idEvento = $_GET['id'];

$evento = Evento::buscaPorId($idEvento);

$form = new es\ucm\fdi\aw\src\Eventos\FormularioAnyadirGanador($evento);

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor evento';
$contenidoPrincipal=<<<EOF
  	<h1>Acceso al sistema</h1>
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor Producto'];
$app->generaVista('/plantillas/plantilla.php', $params);