<?php

//Inicio del procesamiento

require_once 'includes/config.php';

$tituloPagina = 'Pagina principal';

$contenidoPrincipal=<<<EOS
<h1>Página principal</h1>
	<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require_once 'includes/vistas/comun/layout.php';
