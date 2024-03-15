<?php

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/EditorProductoFormulario.php';

$tituloPagina = 'Editor Producto';

$htmlFormLogin = buildFormularioEditorProducto();
$contenidoPrincipal=<<<EOS
<h1>Acceso al sistema</h1>
$htmlFormLogin
EOS;

require_once 'includes/vistas/comun/layout.php';
