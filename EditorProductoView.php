<?php

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/EditorProductoFormulario.php';

$tituloPagina = 'Editor Producto';

$id_producto = $_GET['id_producto'];

$htmlFormLogin = buildFormularioEditorProducto();
$contenidoPrincipal=<<<EOS
<h1>Acceso al sistema $id_producto</h1>
$htmlFormLogin
EOS;

require_once 'includes/vistas/comun/layout.php';
