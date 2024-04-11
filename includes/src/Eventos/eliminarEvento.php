<?php
use es\ucm\fdi\aw\src\Eventos\Evento;
require_once '../includes/config.php';


verificaLogado(Utils::buildUrl('/login.php'));

$tituloPagina = 'Eliminar Evento';

if (!esAdmin()) {
    Utils::paginaError(403, $tituloPagina, 'No tienes permisos para eliminar');
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
    Utils::redirige(Utils::buildUrl('/index.php'));
}

$evento = Evento::buscaPorId($id);

$contenidoPrincipal = <<<EOS
	<h1>Eliminar evento</h1>
	
EOS;

require '../includes/vistas/comun/layout.php';
