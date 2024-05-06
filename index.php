<?php

//Inicio del procesamiento

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Productos/productosDestacados.php';

require_once __DIR__.'/includes/src/Eventos/eventosDestacados.php';
$tituloPagina = 'MesaMaestra';
$login = resuelve('/login.php');


$contenidoPrincipal = <<<EOS
<div style="text-align: center;">
    <h1 class = "h1-custom">MESAMAESTRA</h1>
    <p> Bienvenidos a Mesamaestra, tu punto de encuentro para tus juegos de mesa favoritos. </p>
    <p> Únete a los mejores foros. </p>
    <p> Compra los mejores juegos de mesa al mejor precio. </p>
    <p> Conoce a los mejores profesionales de tus juegos favoritos. </p>
    <p> Apúntate a los mejores eventos y gana un montón de premios. </p>
    </div>
EOS;
$contenidoPrincipal .= '<div>'.productosDestacados().'</div>';
$contenidoPrincipal .= '<div>'.eventossDestacados().'</div>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantillaIndex.php', $params);
?>
