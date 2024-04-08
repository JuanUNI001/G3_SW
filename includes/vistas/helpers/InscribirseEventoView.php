<?php

require_once 'includes/config.php';
use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\FormularioInscripcion;



$tituloPagina = 'Inscripción en Evento';

$idEvento = $_GET['idEvento'];
$evento = Evento::buscaPorId($idEvento);
$nombreEvento = $evento->getEvento();

// Asignamos los valores al formulario de inscripción
$form->idEvento = $idEvento;

$htmlFormulario = $form->gestiona();

$contenidoPrincipal = <<<EOS
    <h1>Inscripción en Evento</h1>
    $htmlFormulario
EOS;

require_once 'includes/vistas/comun/layout.php';
?>
