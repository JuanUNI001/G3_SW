<?php

//Inicio del procesamiento
session_start();

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/profesores.php';


$tituloPagina = 'Profesores';

$contenidoPrincipal = mostrarProfesores();

require_once 'includes/vistas/comun/layout.php';
