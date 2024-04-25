<?php

require_once 'includes/config.php'; 
use \es\ucm\fdi\aw\src\Profesores\Profesor;

$form = new es\ucm\fdi\aw\src\Profesores\FormularioEdicionProfesor();

$id_Profesor = $_POST['id_profesor'];
$Profesor = Profesor::buscaPorId($id_Profesor);
$nombre = $Profesor->getNombre();

$form->id = $id_Profesor;
$form->nombre = $nombre;

$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Editor Profesor';
$contenidoPrincipal=<<<EOF
  	<h1>Acceso al sistema</h1>
    $htmlFormLogin
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal, 'cabecera' => 'Editor profesor'];
$app->generaVista('/plantillas/plantilla.php', $params);