<?php

require_once 'includes/config.php'; 

use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\src\Eventos\FormularioDesinscripcionEvento;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

$idEvento = intval($_GET['id']);

//$evento = Evento::buscaPorId($idEvento);

$correo = $_SESSION['correo'];
$usuario = Usuario::buscaUsuario($correo);
$idUsuario = $usuario->getId();

//$form->idEvento = $idEvento;
//$form->idUsuario = $idUsuario;

$form = new es\ucm\fdi\aw\src\Eventos\FormularioDesinscripcionEvento($idEvento, $idUsuario);
$tituloPagina = 'Desinscripcion Evento';

$htmlFormulario = $form->gestiona();

$contenidoPrincipal = <<<EOS
    <h1> Desinscripcion</h1>
    $htmlFormulario
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Desinscribirse evento'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
