<?php


require_once 'includes/config.php';

require_once 'includes/vistas/helpers/mostrarPedidiosAnteriores.php';

$tituloPagina = 'Pedidos Anteriores';

$contenidoPrincipal =  mostrar_pedidosAnteriores();
$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);