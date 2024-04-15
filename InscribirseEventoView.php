<?php


require_once 'includes/config.php'; 

use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\src\Eventos\FormularioInscripcion;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

$form = new es\ucm\fdi\aw\src\Eventos\FormularioInscripcion();
$tituloPagina = 'Inscripción en Evento';

$idEvento = $_GET['id'];
$correo = $_SESSION['correo'];
$usuario = Usuario::buscaUsuario($correo);
$idUsuario = $usuario->getId();
$evento = Evento::buscaPorId($idEvento);
$nombreEvento = $evento->getEvento();

$form->idEvento = $idEvento;
$form->idUsuario=$idUsuario;
$htmlFormulario = $form->gestiona();

$contenidoPrincipal = <<<EOS
    <h1>Inscripción en Evento</h1>
    $htmlFormulario
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Inscribirse evento'];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
