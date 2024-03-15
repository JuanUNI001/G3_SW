<?php
session_start();

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/verPerfil.php';

$tituloPagina = 'Ver_Perfil';

$contenidoPrincipal =  mostrar_contenidoPerfil();

require_once 'includes/vistas/comun/layout.php';