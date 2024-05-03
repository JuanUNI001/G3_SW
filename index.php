<?php

//Inicio del procesamiento

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/src/Productos/productosDestacados.php';
$tituloPagina = 'MesaMaestra';
$login = resuelve('/login.php');


$contenidoPrincipal = <<<EOS
<div style="text-align: center;">
    <h1>Página principal</h1>
    <p> Bienvenidos a Mesamaestra, tu punto de encuentro para tus juegos de mesa favoritos. </p>
    <img src="images/juegos_mesa.png" alt="Juegos de Mesa" style="width: 30%; margin: 0 auto;">
    </div>
EOS;
$contenidoPrincipal .= '<div>'.productosDestacados().'</div>';

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
