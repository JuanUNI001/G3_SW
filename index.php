<?php

//Inicio del procesamiento

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'MesaMaestra';
$login = resuelve('/login.php');

$contenidoPrincipal=<<<EOS
  <h1>Página principal</h1>
  <p> Bienvenidos a Mesamaestra, tu punto de encuentro para tus juegos de mesa favoritos. </p>
EOS;


$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
