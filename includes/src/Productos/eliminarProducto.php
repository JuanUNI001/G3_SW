<?php
require_once '../includes/config.php';
require_once '../includes/vistas/helpers/autorizacion.php';
require_once '../includes/src/Productos/productos.php';

verificaLogado(Utils::buildUrl('/login.php'));

$tituloPagina = 'Editar Productos';

if (!esAdmin()) {
    Utils::paginaError(403, $tituloPagina, 'No tienes permisos para editar productos');
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id) {
    Utils::redirige(Utils::buildUrl('/index.php'));
}

$producto = Producto::buscaPorId($id);

$contenidoPrincipal = <<<EOS
	<h1>Eliminar producto</h1>
	
EOS;

require '../includes/vistas/comun/layout.php';
