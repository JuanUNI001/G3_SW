<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Profesores\Profesor;

$form = new es\ucm\fdi\aw\src\Profesores\FormularioEdicionProfesor();

$id_Profesor = $_GET['id_profesor'];
$Profesor = Profesor::buscaPorId($id_Profesor);
$nombre = $Profesor->getNombre();

$form->id = $id_Profesor;
$form->nombre = $nombre;

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor Profesor';
$contenidoPrincipal=<<<EOF
  	
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor profesor'];
$app->generaVista('/plantillas/plantilla.php', $params);