<?php


require_once 'includes/config.php'; 

use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\FormularioInscripcion;


$form = new es\ucm\fdi\aw\src\Eventos\FormularioInscripcion();
$tituloPagina = 'Inscripción en Evento';

$idEvento = $_GET['id'];
$evento = Evento::buscaPorId($idEvento);
$nombreEvento = $evento->getEvento();

// Asignamos los valores al formulario de inscripción
$form->idEvento = $idEvento;

$htmlFormulario = $form->gestiona();

$contenidoPrincipal = <<<EOS
    <h1>Inscripción en Evento</h1>
    $htmlFormulario
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Inscribirse evento'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
