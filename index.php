<?php

//Inicio del procesamiento

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Productos/productosDestacados.php';
require_once __DIR__.'/includes/src/Foros/forosDestacados.php';
require_once __DIR__.'/includes/src/Eventos/eventosDestacados.php';
$tituloPagina = 'MesaMaestra';
$login = resuelve('/login.php');


$contenidoPrincipal = <<<EOS
<div style="text-align: center;">
    <h1>Página principal</h1>
    <p> Bienvenidos a Mesamaestra, tu punto de encuentro para tus juegos de mesa favoritos. </p>
    
    </div>
EOS;
$contenidoPrincipal .= '<div>'.forosDestacados().'</div>';
$contenidoPrincipal .= '<div>'.productosDestacados().'</div>';
$contenidoPrincipal .= '<div>'.eventossDestacados().'</div>';


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
