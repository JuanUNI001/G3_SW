<?php
session_start();

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/verPerfil.php';

$tituloPagina = 'Pagina principal';

$contenidoPrincipal =  mostrar_contenidoPerfil();

require 'includes/vistas/comun/layout.php';