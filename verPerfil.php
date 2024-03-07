<?php
session_start();

require_once 'includes/config.php';
require_once 'includes/vistas/comun/verPerfil.php';

$tituloPagina = 'Pagina principal';

$contenidoPrincipal =  contenidoPerfil();

require 'includes/vistas/comun/layout.php';